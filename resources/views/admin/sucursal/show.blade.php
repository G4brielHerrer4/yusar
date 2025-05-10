@extends('adminlte::page')

@section('title', 'Detalles de Sucursal')

@section('content_header')
    <h1>Detalles de Sucursal</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h3><strong>Nombre:</strong> {{ $sucursal->nombre }}</h3>
            <p><strong>Dirección:</strong> {{ $sucursal->direccion }}</p>
            <p><strong>Latitud:</strong> {{ $sucursal->latitud ?? 'N/A' }}</p>
            <p><strong>Longitud:</strong> {{ $sucursal->longitud ?? 'N/A' }}</p>
            <p><strong>Departamento:</strong> {{ optional($sucursal->departamento)->nombre ?? 'Sin departamento' }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge {{ $sucursal->estado ? 'badge-success' : 'badge-danger' }}">
                    {{ $sucursal->estado ? 'Activo' : 'Inactivo' }}
                </span>
            </p>
        </div>
        <div class="card-footer">
            <a href="{{ route('sucursal.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('sucursal.edit', $sucursal->id) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
@stop
