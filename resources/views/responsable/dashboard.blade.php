@extends('adminlte::page')

@section('title', 'Panel de Responsable')

@section('content_header')
    <h1>Bienvenido, Responsable</h1>
@stop

@section('content')
    <p>Este es el panel de responsable.</p>
    <p>Aquí puedes gestionar poco</p>

    <!-- Botón para cerrar sesión -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('¡Panel de REsponsable cargado!'); </script>
@stop