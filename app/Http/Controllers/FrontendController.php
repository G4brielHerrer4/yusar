<?php

namespace App\Http\Controllers;
use App\Models\ConfirmacionPrenda;
use App\Models\Coleccion;
use App\Models\Categoria;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function ClienteLogin()
    {
        // Redirigir si ya está autenticado
        if (auth()->guard('cliente')->check()) {
            return redirect()->route('cliente.inicio');
        }
        
        return view('frontend.login');
    }

    public function login()
    {
        return view('frontend.login'); // Retorna la vista de la login
    }

    //Metodo para la pagina de registro
    public function registro()
    {
        return view('frontend.registro'); // Retorna la vista de l registro
    }

    // Método para la página de la tienda
    // public function tienda()
    // {
    //     // Obtener prendas confirmadas con su relación 'prenda' y paginación
    //     $prendas = ConfirmacionPrenda::with('prenda')
    //         ->where('stock', '>', 0) // Solo prendas con stock disponible
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(12); // 12 prendas por página (ajusta según necesites)
            
    //     return view('frontend.tienda', compact('prendas'));
    // }

    public function tienda(Request $request)
    {
        // Obtener categorías con prendas confirmadas
        $categorias = Categoria::withCount(['prendas' => function($query) {
            $query->whereHas('confirmacion');
        }])->get();

        // Obtener solo colecciones activas (sin relación con prendas)
        $colecciones = Coleccion::where('activa', true)
                        ->latest()
                        ->get();

        // Query para prendas confirmadas
        $query = ConfirmacionPrenda::with(['prenda.categoria'])
                    ->where('stock', '>', 0);

        // Filtro por categoría
        if ($request->has('categoria')) {
            $query->whereHas('prenda', function($q) use ($request) {
                $q->where('categoria_id', $request->categoria);
            });
        }

        // Ordenamiento
        $order = $request->get('order', 'newest');
        switch ($order) {
            case 'price_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'name_asc':
                $query->join('prendas', 'confirmacion_prendas.prenda_id', '=', 'prendas.id')
                      ->orderBy('prendas.nombre', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $prendas = $query->paginate(12);

        return view('frontend.tienda', compact('prendas', 'categorias', 'colecciones'));
    }

    // Método para la página "Acerca de Nosotros"
    public function acerca()
    {
        return view('frontend.acerca'); // Retorna la vista de acerca
    }

    // Método para la página del blog
    public function blog()
    {
        return view('frontend.blog'); // Retorna la vista del blog
    }

    public function tryon()
    {
        return view('frontend.tryon'); // Retorna la vista de acerca
    }
}