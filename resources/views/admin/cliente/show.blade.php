@extends('adminlte::page')

@section('title', 'Detalles del Cliente')

@section('content_header')
    <h1>Detalles del Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($cliente->foto)
                        <img src="{{ asset('storage/' . $cliente->foto) }}" alt="Foto de perfil" class="img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; margin: 0 auto;">
                            <i class="fas fa-user fa-5x text-white"></i>
                        </div>
                    @endif
                    
                    <h3 class="mt-3">{{ $cliente->nombre }} {{ $cliente->apellido }}</h3>
                    <p class="text-muted">{{ $cliente->nombre_usuario }}</p>
                </div>
                
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-id-card"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">CI/NIT</span>
                                    <span class="info-box-number">{{ $cliente->ci_nit }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-envelope"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Correo</span>
                                    <span class="info-box-number">{{ $cliente->correo }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-phone"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Celular</span>
                                    <span class="info-box-number">{{ $cliente->celular }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-venus-mars"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Género</span>
                                    <span class="info-box-number">{{ $cliente->genero }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-secondary"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Fecha Registro</span>
                                    <span class="info-box-number">{{ $cliente->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-dark"><i class="fas fa-sync"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Última Actualización</span>
                                    <span class="info-box-number">{{ $cliente->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('cliente.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@stop