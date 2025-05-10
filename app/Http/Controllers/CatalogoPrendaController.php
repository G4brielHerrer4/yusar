<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CatalogoPrenda;
use App\Models\AlmacenPrenda;
use Illuminate\Http\Request;

class CatalogoPrendaController extends Controller
{
    public function index()
    {
        $prendas = CatalogoPrenda::with([
            'inventario.recepcion',
            'inventario.categoria',
            'inventario.coleccion'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.catalogo.index', compact('prendas'));
    }

    public function returnToWarehouse(Request $request)
    {
        $request->validate([
            'prenda_id' => 'required|exists:catalogo_prendas,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $catalogoPrenda = CatalogoPrenda::findOrFail($request->prenda_id);

        if ($request->quantity > $catalogoPrenda->cantidad) {
            return back()->with('error', 'No hay suficiente stock en el catálogo');
        }

        // Buscar o crear registro en almacén
        $almacenPrenda = AlmacenPrenda::firstOrNew([
            'inventario_id' => $catalogoPrenda->inventario_id
        ], ['ubicacion' => 'Pendiente']);

        $almacenPrenda->cantidad += $request->quantity;
        $almacenPrenda->save();

        // Actualizar catálogo
        $catalogoPrenda->cantidad -= $request->quantity;
        if ($catalogoPrenda->cantidad <= 0) {
            $catalogoPrenda->delete();
        } else {
            $catalogoPrenda->save();
        }

        return back()->with('success', 'Prenda devuelta al almacén exitosamente');
    }
}