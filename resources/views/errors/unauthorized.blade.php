@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 my-5">
            <div class="card shadow border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="font-weight-bold mb-3">Acceso Restringido</h2>
                    <p class="text-muted mb-4">Lo sentimos, no tienes los permisos necesarios para acceder a esta sección.</p>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    
                    <a href="javascript:void(0)" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                       class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-home mr-2"></i> Volver al inicio
                    </a>
                </div>
                <div class="card-footer bg-light text-center py-3">
                    <small class="text-muted">
                        Si crees que esto es un error, por favor contacta al administrador del sistema.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection