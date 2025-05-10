@extends('adminlte::page')

@section('title', 'Editar Sucursal')

@section('content_header')
    <h1>Editar Sucursal</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sucursal.update', $sucursal->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $sucursal->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $sucursal->direccion) }}" required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="latitud">Latitud</label>
                    <input type="text" name="latitud" id="latitud" class="form-control @error('latitud') is-invalid @enderror" value="{{ old('latitud', $sucursal->latitud) }}">
                    @error('latitud')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="longitud">Longitud</label>
                    <input type="text" name="longitud" id="longitud" class="form-control @error('longitud') is-invalid @enderror" value="{{ old('longitud', $sucursal->longitud) }}">
                    @error('longitud')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="departamento_id">Departamento</label>
                    <select name="departamento_id" id="departamento_id" class="form-control">
                        <option value="">Seleccione un departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id }}" {{ old('departamento_id', $sucursal->departamento_id) == $departamento->id ? 'selected' : '' }}>
                                {{ $departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="1" {{ $sucursal->estado ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$sucursal->estado ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
@stop
