<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    // Mostrar lista de banners
    public function index()
    {
        $banners = Banner::all();
        return view('frontend.banner.index', compact('banners'));
    }

    // Mostrar formulario para crear un banner
    public function create()
    {
        return view('frontend.banner.create');
    }

    // Guardar un nuevo banner
    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'titulo' => 'nullable|string|max:20',
            'descripcion' => 'nullable|string|max:50',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:0,1',
        ]);

        // Si la validación falla, redirigir con errores
        if ($validator->fails()) {
            // Mensaje personalizado para errores de imagen
            if ($validator->errors()->has('imagen')) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('image_error', 'Por favor, selecciona una imagen válida.');
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear el banner
        $banner = new Banner();
        $banner->titulo = $request->titulo;
        $banner->descripcion = $request->descripcion;
        $banner->estado = $request->estado;

        // Guardar la imagen
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('banners', 'public');
            $banner->imagen = $imagenPath;
        }

        // Guardar el banner en la base de datos
        $banner->save();

        // Redirigir a la lista de banners con un mensaje de éxito
        return redirect()->route('banner.index')->with('success', 'Banner creado correctamente.');
    }

    // Mostrar formulario para editar un banner
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('frontend.banner.edit', compact('banner'));
    }

    // Actualizar un banner
    public function update(Request $request, $id)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'titulo' => 'nullable|string|max:20',
            'descripcion' => 'nullable|string|max:50',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'estado' => 'required|in:0,1',
        ]);

        // Si la validación falla, redirigir con errores
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buscar el banner
        $banner = Banner::findOrFail($id);
        $banner->titulo = $request->titulo;
        $banner->descripcion = $request->descripcion;
        $banner->estado = $request->estado;

        // Actualizar la imagen si se proporciona una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($banner->imagen && Storage::disk('public')->exists($banner->imagen)) {
                Storage::disk('public')->delete($banner->imagen);
            }

            // Guardar la nueva imagen
            $imagenPath = $request->file('imagen')->store('banners', 'public');
            $banner->imagen = $imagenPath;
        }

        // Guardar los cambios en la base de datos
        $banner->save();

        // Redirigir a la lista de banners con un mensaje de éxito
        return redirect()->route('banner.index')->with('success', 'Banner actualizado correctamente.');
    }

    // Eliminar un banner
    public function destroy($id)
    {
        // Buscar el banner
        $banner = Banner::findOrFail($id);

        // Eliminar la imagen si existe
        if ($banner->imagen && Storage::disk('public')->exists($banner->imagen)) {
            Storage::disk('public')->delete($banner->imagen);
        }

        // Eliminar el banner de la base de datos
        $banner->delete();

        // Redirigir a la lista de banners con un mensaje de éxito
        return redirect()->route('banner.index')->with('success', 'Banner eliminado correctamente.');
    }
}