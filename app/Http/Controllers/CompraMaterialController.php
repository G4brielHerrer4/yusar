<?php

namespace App\Http\Controllers;

use App\Models\{CompraMaterial, DetalleCompra, InventarioMaterial, Material, Almacen, Proveedor,User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CompraMaterialController extends Controller
{
  

    public function create()
    {
        $proveedores = Proveedor::where('activo', true)->get();
        $materiales = Material::all();
        return view('admin.gestion_material.modals.compras.create', compact('proveedores', 'materiales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'materiales' => 'required|array|min:1',
            'materiales.*.material_id' => 'required|exists:materiales,id',
            'materiales.*.cantidad' => 'required|numeric|min:0.01',
            'materiales.*.precio_unitario' => 'required|numeric|min:0.01',
            'fecha_entrega' => 'required|date'
        ]);

        DB::transaction(function () use ($request) {
            $compra = CompraMaterial::create([
                'user_id' => auth()->id(),
                'proveedor_id' => $request->proveedor_id,
                'fecha_entrega_estimada' => $request->fecha_entrega,
                'estado' => 'pendiente'
            ]);

            foreach ($request->materiales as $material) {
                $compra->detalles()->create([
                    'material_id' => $material['material_id'],
                    'cantidad' => $material['cantidad'],
                    'precio_unitario' => $material['precio_unitario'],
                    'precio_total' => $material['cantidad'] * $material['precio_unitario']
                ]);
            }
        });

        return redirect()->route('admin.gestion_material.index')->with('success', 'Compra registrada correctamente');
    }

    public function show($id)
    {
        $compra = CompraMaterial::with([
            'proveedor',
            'user',
            'detalles.material',
            'detalles.inventarios.almacen' // Carga la relación con inventarios
        ])->findOrFail($id);

        return view('admin.gestion_material.modals.compras.show', [
            'compra' => $compra,
            'almacenes' => Almacen::where('activo', true)->get(),
            'users' => User::all()
        ]);
    }

    public function recibir(Request $request, $id)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'materiales' => 'required|array',
            'materiales.*.id' => 'required|exists:detalle_compras,id',
            'materiales.*.cantidad_recibida' => 'required|numeric|min:0.01'
        ]);

        DB::transaction(function () use ($request, $id) {
            $compra = CompraMaterial::findOrFail($id);
            
            // Validar que la compra esté pendiente
            if ($compra->estado != 'pendiente') {
                throw new \Exception('Esta compra ya fue procesada');
            }

            // 1. Actualizar estado de la compra
            $compra->update(['estado' => 'recibido']);

            // 2. Registrar en inventario
            foreach ($request->materiales as $materialData) {
                $detalle = $compra->detalles()->findOrFail($materialData['id']);
                
                InventarioMaterial::updateOrCreate(
                    [
                        'material_id' => $detalle->material_id,
                        'almacen_id' => $request->almacen_id,
                    ],
                    [
                        'detalle_compra_id' => $detalle->id,
                        'stock_actual' => DB::raw("stock_actual + {$materialData['cantidad_recibida']}"),
                    ]
                );
            }
        });

        // Redirección correcta al index
        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Compra recibida e inventario actualizado');
    }

    public function download($id)
    {
        $compra = CompraMaterial::with([
            'proveedor', 
            'user', 
            'detalles.material', 
            'detalles.inventarios.almacen'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.gestion_material.modals.compras.reportepdf', compact('compra'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial'
            ]);
        
        return $pdf->download('compra_yusar_'.$compra->id.'.pdf');
    }

    public function destroy(CompraMaterial $compra)
    {
        $compra->update(['estado' => 'cancelado']);
        return back()->with('success', 'Compra cancelada');
    }
}