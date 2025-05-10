<?php

namespace App\Http\Controllers;

use App\Models\InventarioMaterial;
use App\Models\ConfiguracionCep;
use Illuminate\Http\Request;

class InventarioMaterialController extends Controller
{
    /**
     * Muestra el listado de inventario de materiales.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $inventario = InventarioMaterial::with(['material', 'almacen'])
                            ->orderBy('almacen_id')
                            ->orderBy('material_id')
                            ->get();

        return view('admin.inventario_material.index', [
            'inventario' => $inventario
        ]);
    }
 
    // InventarioMaterialController.php
    public function storeCEP(Request $request, $inventarioId)
    {
        $validated = $request->validate([
            'demanda_anual' => 'required|numeric|min:1',
            'costo_orden' => 'required|numeric|min:0.01',
            'costo_mantenimiento' => 'required|numeric|min:0.01',
            'tiempo_entrega' => 'required|numeric|min:1'
        ]);
    
        $inventario = InventarioMaterial::findOrFail($inventarioId);
        
        $cep = new ConfiguracionCep($validated);
        $cep->calcularCep(); // Método que calcula automáticamente los campos
        $inventario->configuracionCep()->save($cep);
    
        return redirect()
               ->back()
               ->with('success', 'Configuración CEP guardada exitosamente');
    }
    
    public function updateCEP(Request $request, $inventarioId)
    {
        $validated = $request->validate([
            'demanda_anual' => 'required|numeric|min:1',
            'costo_orden' => 'required|numeric|min:0.01',
            'costo_mantenimiento' => 'required|numeric|min:0.01',
            'tiempo_entrega' => 'required|numeric|min:1'
        ]);
    
        $inventario = InventarioMaterial::findOrFail($inventarioId);
        $inventario->configuracionCep->fill($validated);
        $inventario->configuracionCep->calcularCep();
        $inventario->configuracionCep->save();
    
        return redirect()
               ->back()
               ->with('success', 'Configuración CEP actualizada exitosamente');
    }
}