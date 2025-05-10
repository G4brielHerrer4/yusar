@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-users mr-2"></i>Gestión de Usuarios</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header bg-gradient-orange">
            <h3 class="card-title">
                <i class="fas fa-user-friends mr-2"></i>Listado de Usuarios Registrados
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#createUsuarioModal">
                    <i class="fas fa-plus-circle mr-1"></i> Nuevo Usuario
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="icon fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            <table id="usuarios-table" class="table table-striped table-hover nowrap" style="width:100%">
                <thead class="bg-gradient-aqua">
                    <tr>
                        <th class="text-center">Foto</th>
                        <th>Nombre Completo</th>
                        <th>CI</th>
                        <th>Contacto</th>
                        <th>Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td class="text-center">
                            @php
                                $fotoUrl = $usuario->foto && Storage::disk('public')->exists($usuario->foto) 
                                    ? asset('storage/'.$usuario->foto)
                                    : 'https://ui-avatars.com/api/?name='.urlencode($usuario->nombre.' '.$usuario->apellido).'&background=random&color=fff';
                            @endphp
                            <img src="{{ $fotoUrl }}" 
                                 class="img-circle elevation-2" 
                                 alt="Foto de usuario"
                                 style="width: 40px; height: 40px; object-fit: cover;"
                                 onerror="this.src='https://ui-avatars.com/api/?name=U&background=dddddd&color=777777'">
                        </td>
                        <td>
                            <strong>{{ $usuario->nombre }} {{ $usuario->apellido }}</strong><br>
                            <small class="text-muted">{{ $usuario->correo_electronico }}</small>
                        </td>
                        <td>{{ $usuario->ci }}</td>
                        <td>
                            <i class="fas fa-phone-alt mr-1 text-success"></i> {{ $usuario->celular }}<br>
                            <i class="fas fa-envelope mr-1 text-primary"></i> {{ $usuario->correo_electronico }}
                        </td>
                        <td>
                            <span class="badge badge-pill" style="background-color: {{ $usuario->rol ? '#20c997' : '#6c757d' }}; color: white;">
                                {{ $usuario->rol->nombre ?? 'Sin rol asignado' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editUsuarioModal{{ $usuario->id }}"
                                    title="Editar usuario" style="background-color: #ffaa33; border-color: #ffaa33;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('¿Está seguro de eliminar este usuario?')"
                                        title="Eliminar usuario">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de creación -->
@include('admin.usuario.modals.create')

<!-- Modals de edición para cada usuario -->
@foreach($usuarios as $usuario)
    @include('admin.usuario.modals.edit', ['usuario' => $usuario])
@endforeach
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .bg-gradient-orange {
        background: linear-gradient(135deg, #ffb347, #ffcc33);
        color: white;
    }
    .bg-gradient-aqua {
        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
        color: white;
    }
    .img-circle {
        border-radius: 50%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .img-circle:hover {
        transform: scale(1.1);
    }
    .table thead th {
        vertical-align: middle;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    .card-header {
        border-bottom: none;
    }
    .btn-light {
        background-color: rgba(255,255,255,0.2);
        color: white;
        border: none;
    }
    .btn-light:hover {
        background-color: rgba(255,255,255,0.3);
    }
    #usuarios-table tbody tr {
        transition: all 0.2s ease;
    }
    #usuarios-table tbody tr:hover {
        background-color: rgba(0, 210, 255, 0.05);
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#usuarios-table').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar ascendente",
                "sortDescending": ": Activar para ordenar descendente"
            }
        },
        columnDefs: [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: -1 },
            { orderable: false, targets: -1 }
        ],
        initComplete: function() {
            $('.dataTables_filter input').attr('placeholder', 'Buscar usuario...');
        }
    });
    
    // Notificación de éxito con temporizador
    @if(session('success'))
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
    @endif
});
</script>
@stop