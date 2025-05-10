<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ConfirmacionPrenda;
use App\Models\Categoria;
use App\Models\Coleccion;

class TiendaController extends Controller
{
    public function index()
    {
        $prendas = ConfirmacionPrenda::with(['prenda.categoria', 'prenda.coleccion'])
            ->whereHas('prenda', function($query) {
                $query->where('confirmada', true);
            })
            ->paginate(12);

        $categorias = Categoria::all();
        $colecciones = Coleccion::all();

        return view('frontend.tienda.index', compact('prendas', 'categorias', 'colecciones'));
    }

    public function show($id)
    {
        $prenda = ConfirmacionPrenda::with(['prenda.categoria', 'prenda.coleccion'])
            ->findOrFail($id);

        return view('frontend.tienda.show', compact('prenda'));
    }
}