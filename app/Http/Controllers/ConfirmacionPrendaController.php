<?php

namespace App\Http\Controllers;

use App\Models\ConfirmacionPrenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ConfirmacionPrendaController extends Controller
{
    public function index()
    {
        $prendasConfirmadas = ConfirmacionPrenda::with('prenda')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.prenda.index', compact('prendasConfirmadas'));
    }

    public function show(ConfirmacionPrenda $confirmacionPrenda)
    {
        return view('admin.prenda.show', compact('confirmacionPrenda'));
    }

    public function edit(ConfirmacionPrenda $confirmacionPrenda)
    {
        return view('admin.prenda.edit', compact('confirmacionPrenda'));
    }

    public function update(Request $request, ConfirmacionPrenda $confirmacionPrenda)
    {
        $validator = Validator::make($request->all(), [
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen_principal' => 'nullable|image|max:2048',
            'imagenes_secundarias.*' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Error en el formulario');
        }

        $data = [
            'precio' => $request->precio,
            'stock' => $request->stock
        ];

        // Actualizar imagen principal si se proporciona
        if ($request->hasFile('imagen_principal')) {
            // Eliminar imagen anterior si existe
            if ($confirmacionPrenda->imagen_principal) {
                Storage::delete(str_replace('storage/', 'public/', $confirmacionPrenda->imagen_principal));
            }
            $data['imagen_principal'] = str_replace('public/', 'storage/', 
                $request->file('imagen_principal')->store('public/prendas'));
        }

        // Actualizar imágenes secundarias si se proporcionan
        if ($request->hasFile('imagenes_secundarias')) {
            // Eliminar imágenes anteriores si existen
            if ($confirmacionPrenda->imagenes_secundarias) {
                foreach ($confirmacionPrenda->imagenes_secundarias as $imagen) {
                    Storage::delete(str_replace('storage/', 'public/', $imagen));
                }
            }
            
            $imagenesSecundarias = [];
            foreach ($request->file('imagenes_secundarias') as $imagen) {
                $imagenesSecundarias[] = str_replace('public/', 'storage/', 
                    $imagen->store('public/prendas/secundarias'));
            }
            $data['imagenes_secundarias'] = $imagenesSecundarias;
        }

        $confirmacionPrenda->update($data);

        return redirect()->route('confirmacion-prenda.index')
            ->with('success', 'Prenda confirmada actualizada exitosamente');
    }
}