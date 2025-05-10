<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('rol')->get();
        $roles = Rol::all();
        return view('admin.usuario.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('admin.usuario.modals.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|unique:users,ci|max:20',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'celular' => 'required|string|max:20',
            'correo_electronico' => 'required|email|unique:users,correo_electronico|max:255',
            'clave' => 'required|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rol_id' => 'nullable|exists:roles,id',
        ]);

        $usuario = new User($request->except('foto', 'clave'));
        $usuario->clave = Hash::make($request->clave);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('usuarios', 'public');
            $usuario->foto = $path;
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Rol::all();
        return view('admin.usuario.modals.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|unique:users,ci,'.$id.'|max:20',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'celular' => 'required|string|max:20',
            'correo_electronico' => 'required|email|unique:users,correo_electronico,'.$id.'|max:255',
            'clave' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rol_id' => 'nullable|exists:roles,id',
        ]);

        $usuario->fill($request->except('foto', 'clave'));

        if ($request->filled('clave')) {
            $usuario->clave = Hash::make($request->clave);
        }

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
                Storage::disk('public')->delete($usuario->foto);
            }
            
            $path = $request->file('foto')->store('usuarios', 'public');
            $usuario->foto = $path;
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        
        // Eliminar foto si existe
        if ($usuario->foto && Storage::disk('public')->exists($usuario->foto)) {
            Storage::disk('public')->delete($usuario->foto);
        }
        
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}