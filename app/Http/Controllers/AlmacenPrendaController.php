<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AlmacenPrenda;
use App\Models\CatalogoPrenda;
use Illuminate\Http\Request;

class AlmacenPrendaController extends Controller
{
    public function index()
    {
        $prendas = AlmacenPrenda::with([
            'inventario.recepcion',
            'inventario.categoria',
            'inventario.coleccion'
        ])->orderBy('created_at', 'desc')->get();

        return view('admin.almacen.index', compact('prendas'));
    }

    public function transferToCatalog(Request $request)
    {
        $request->validate([
            'prenda_id' => 'required|exists:almacen_prendas,id',
            'quantity' => 'required|numeric|min:1'
        ]);

        $almacenPrenda = AlmacenPrenda::findOrFail($request->prenda_id);

        if ($request->quantity > $almacenPrenda->cantidad) {
            return back()->with('error', 'No hay suficiente stock en el almacén');
        }

        // Buscar o crear registro en catálogo
        $catalogoPrenda = CatalogoPrenda::firstOrNew([
            'inventario_id' => $almacenPrenda->inventario_id
        ]);

        $catalogoPrenda->cantidad += $request->quantity;
        $catalogoPrenda->publicado = true;
        $catalogoPrenda->save();

        // Actualizar almacén
        $almacenPrenda->cantidad -= $request->quantity;
        if ($almacenPrenda->cantidad <= 0) {
            $almacenPrenda->delete();
        } else {
            $almacenPrenda->save();
        }

        return back()->with('success', 'Prenda transferida al catálogo exitosamente');
    }
}