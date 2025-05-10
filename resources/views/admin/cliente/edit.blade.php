@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente: {{ $cliente->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cliente.update', $cliente->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $cliente->nombre) }}" required>
                            @error('nombre')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" name="apellido" id="apellido" class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido', $cliente->apellido) }}" required>
                            @error('apellido')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ci_nit">CI/NIT:</label>
                            <input type="text" name="ci_nit" id="ci_nit" class="form-control @error('ci_nit') is-invalid @enderror" value="{{ old('ci_nit', $cliente->ci_nit) }}" required>
                            @error('ci_nit')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="genero">Género:</label>
                            <select name="genero" id="genero" class="form-control @error('genero') is-invalid @enderror" required>
                                <option value="Masculino" {{ old('genero', $cliente->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('genero', $cliente->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro" {{ old('genero', $cliente->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="foto">Foto de Perfil:</label>
                    <input type="file" name="foto" id="foto" class="form-control-file @error('foto') is-invalid @enderror">
                    @error('foto')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if($cliente->foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $cliente->foto) }}" alt="Foto actual" width="100" class="img-thumbnail">
                            <div class="form-check mt-2">
                                <input type="checkbox" name="eliminar_foto" id="eliminar_foto" class="form-check-input">
                                <label for="eliminar_foto" class="form-check-label">Eliminar foto actual</label>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_usuario">Nombre de Usuario:</label>
                            <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control @error('nombre_usuario') is-invalid @enderror" value="{{ old('nombre_usuario', $cliente->nombre_usuario) }}" required>
                            @error('nombre_usuario')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="correo">Correo Electrónico:</label>
                            <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo', $cliente->correo) }}" required>
                            @error('correo')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="clave">Nueva Contraseña:</label>
                            <div class="input-group">
                                <input type="password" name="clave" id="clave" class="form-control @error('clave') is-invalid @enderror" placeholder="Dejar en blanco para no cambiar">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('clave')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">
                                La contraseña debe contener al menos 8 caracteres, incluyendo mayúsculas, minúsculas, números y símbolos.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="celular">Celular:</label>
                            <input type="text" name="celular" id="celular" class="form-control @error('celular') is-invalid @enderror" value="{{ old('celular', $cliente->celular) }}" required>
                            @error('celular')
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Cliente
                </button>
                <a href="{{ route('cliente.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .toggle-password {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                const input = $(this).closest('.input-group').find('input');
                const icon = $(this).find('i');
                
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@stop