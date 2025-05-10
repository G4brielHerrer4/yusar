@extends('adminlte::page')

@section('title', 'Panel de Administrador')

@section('content_header')
    <h1>Bienvenido, vendedor</h1>
@stop

@section('content')
    <p>Este es el panel de vendedor.</p>
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
    <script> console.log('¡Panel de vendedor cargado!'); </script>
@stop