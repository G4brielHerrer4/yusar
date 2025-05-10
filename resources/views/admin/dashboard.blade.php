@extends('adminlte::page')

@section('title', 'Panel de Administración')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bienvenido, <span class="text-primary">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Perfil del usuario mejorado -->
        <div class="col-lg-4 col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center position-relative mb-4">
                        @php
                            $fotoUrl = Auth::user()->foto 
                                ? (Storage::disk('public')->exists(Auth::user()->foto) 
                                    ? asset('storage/'.Auth::user()->foto) 
                                    : asset('img/default-avatar.png'))
                                : asset('img/default-avatar.png');
                            
                            $iniciales = substr(Auth::user()->nombre, 0, 1).substr(Auth::user()->apellido, 0, 1);
                            $avatarUrl = "https://ui-avatars.com/api/?name=".urlencode($iniciales)."&background=random&color=fff&size=120";
                        @endphp
                        
                        <img class="profile-user-img img-fluid img-circle shadow" 
                             src="{{ $fotoUrl }}" 
                             alt="Foto de perfil"
                             style="width: 120px; height: 120px; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ $avatarUrl }}'">
                             
                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-3 border-white" 
                              style="width: 20px; height: 20px;"
                              title="Usuario activo"></span>
                    </div>
                    
                    <h3 class="profile-username text-center mt-3 text-primary">
                        {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                    </h3>
                    
                    <p class="text-muted text-center mb-4">
                        <span class="badge bg-gradient-indigo px-3 py-2">
                            <i class="fas fa-shield-alt mr-2"></i>Administrador
                        </span>
                    </p>
                    
                    <div class="list-group list-group-flush rounded-lg overflow-hidden">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-id-card mr-2 text-primary"></i> 
                                <span>Cédula</span>
                            </span>
                            <span class="font-weight-bold badge bg-light text-dark">
                                {{ Auth::user()->ci ?? 'No especificado' }}
                            </span>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-envelope mr-2 text-danger"></i> 
                                <span>Correo</span>
                            </span>
                            <span class="font-weight-bold text-truncate" style="max-width: 150px;">
                                {{ Auth::user()->correo_electronico }}
                            </span>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-phone mr-2 text-success"></i> 
                                <span>Teléfono</span>
                            </span>
                            <span class="font-weight-bold">
                                {{ Auth::user()->celular ?? 'No especificado' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-center">
                       
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt mr-1"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Widget de actividad reciente -->
            <div class="card mt-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>Actividad Reciente
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="bg-info rounded-circle p-2 mr-3">
                                    <i class="fas fa-user-plus text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Nuevo usuario registrado</h6>
                                    <small class="text-muted">Hace 2 horas</small>
                                </div>
                            </div>
                        </li>
                        <!-- Más actividades... -->
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Resto de tu contenido... -->
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<style>
    .profile-user-img {
        border: 3px solid #adb5bd;
        transition: all 0.3s ease;
    }
    .profile-user-img:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }
    .small-box {
        color: white !important;
        border-radius: 0.25rem;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .small-box:hover {
        transform: translateY(-5px);
    }
    .bg-gradient-indigo {
        background: linear-gradient(to right, #6610f2, #7b2ff7);
    }
    .bg-gradient-olive {
        background: linear-gradient(to right, #3d9970, #4caf50);
    }
    .bg-gradient-orange {
        background: linear-gradient(to right, #ff851b, #ff9800);
    }
    .bg-gradient-red {
        background: linear-gradient(to right, #f012be, #ff2d55);
    }
    .bg-gradient-teal {
        background: linear-gradient(to right, #20c997, #00bcd4);
    }
    .bg-gradient-maroon {
        background: linear-gradient(to right, #d81b60, #e91e63);
    }
    .bg-gradient-navy {
        background: linear-gradient(to right, #001f3f, #0056b3);
    }
    .btn-app {
        border-radius: 3px;
        margin: 0 0 10px 0;
        min-width: 80px;
        height: 80px;
        text-align: center;
        color: #666;
        border: 1px solid #ddd;
        background-color: #f4f4f4;
        font-size: 12px;
        transition: all 0.3s ease;
    }
    .btn-app:hover {
        color: #fff;
        border-color: rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }
</style>
@stop

@section('js')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
$(function () {
    // Gráfico de ventas
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'Ventas 2024',
                data: [2500, 3900, 4200, 3800, 5100, 6800, 7500, 7200, 6900, 8300, 9100, 10500],
                backgroundColor: 'rgba(0, 123, 255, 0.7)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Notificación de bienvenida
    setTimeout(() => {
        toastr.success('Bienvenido al panel de administración', 'Hola {{ Auth::user()->nombre }}!', {
            positionClass: "toast-bottom-right",
            timeOut: 5000,
            closeButton: true,
            progressBar: true
        });
    }, 1000);
});
</script>
@stop