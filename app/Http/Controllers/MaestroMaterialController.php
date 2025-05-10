<?php

namespace App\Http\Controllers;

use App\Models\{
    Material, 
    Proveedor, 
    Almacen,
    CompraMaterial,
    InventarioMaterial,
    User
};
use Illuminate\Http\Request;

class MaestroMaterialController extends Controller
{
    public function index()
    {
        return view('admin.gestion_material.index', [
            // Materiales básicos
            'materiales' => Material::with('inventarios')->latest()->get(),
            'proveedores' => Proveedor::where('activo', true)->latest()->get(),
            'almacenes' => Almacen::where('activo', true)->latest()->get(),
            
            // Compras e Inventario
            'compras' => CompraMaterial::with(['proveedor', 'user', 'detalles.material'])
                            ->latest()
                            ->get(),
            
            'inventario' => InventarioMaterial::with(['material', 'almacen'])
                            ->orderBy('almacen_id')
                            ->orderBy('material_id')
                            ->get(),
            
            // Usuarios (confeccionistas)
            'users' => User::all(),
            

        ]);
    }
}

