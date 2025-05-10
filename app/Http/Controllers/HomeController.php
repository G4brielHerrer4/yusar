<?php


namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Obtener los banners activos.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getBanners()
    {
        return Banner::where('estado', 1)->get();
    }

    /**
     * Obtener las sucursales con coordenadas válidas.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getSucursales()
    {
        return Sucursal::where('estado', 1) // Solo sucursales activas
                     ->whereNotNull('latitud')
                     ->whereNotNull('longitud')
                     ->get();
    }

    /**
     * Mostrar la página de inicio con banners y mapa de sucursales.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener los banners activos
        $banners = $this->getBanners();

        // Obtener las sucursales con coordenadas válidas
        $sucursales = $this->getSucursales();

        // Pasar ambas variables a la vista
        return view('frontend.inicio', compact('banners', 'sucursales'));
    }

    /**
     * Mostrar solo los banners (para uso interno o rutas separadas).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexbanner()
    {
        $banners = $this->getBanners();
        return view('frontend.inicio', compact('banners'));
    }

    /**
     * Mostrar solo el mapa de sucursales (para uso interno o rutas separadas).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexmap()
    {
        $sucursales = $this->getSucursales();
        return view('frontend.inicio', compact('sucursales'));
    }
}

// namespace App\Http\Controllers;
// use App\Models\Banner;
// use App\Models\Sucursal;
// use Illuminate\Support\Facades\Storage;

// use Illuminate\Http\Request;

// class HomeController extends Controller
// {
//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('auth')->except('indexbanner','indexmap');
        
//     }


//     public function indexbanner()
//     {
//         // Obtener los banners activos desde la base de datos
//         $banners = Banner::where('estado', 1)->get();

//         // Pasar los banners a la vista
//         return view('frontend.inicio', compact('banners'));
//     }

//     public function indexmap()
//     {
//         // Obtener las sucursales con coordenadas válidas
//         $sucursales = Sucursal::whereNotNull('latitud')
//                             ->whereNotNull('longitud')
//                             ->get();

//         // Pasar las sucursales a la vista
//         return view('frontend.inicio', compact('sucursales'));
//     }

//     /**
//      * Show the application dashboard.
//      *
//      * @return \Illuminate\Contracts\Support\Renderable
//      */
//     public function index()
//     {
//         return view('frontend.inicio');
//     }
// }
