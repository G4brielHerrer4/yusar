@extends('adminlte::page')

@section('title', 'Gestión de Clientes')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-user-friends mr-2"></i>Gestión de Clientes</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="breadcrumb-item active">Clientes</li>
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
                <i class="fas fa-address-book mr-2"></i>Listado de Clientes Registrados
            </h3>
            <div class="card-tools">
                <a href="{{ route('cliente.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus-circle mr-1"></i> Nuevo Cliente
                </a>
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

            <table id="clientes-table" class="table table-striped table-hover nowrap" style="width:100%">
                <thead class="bg-gradient-aqua">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Foto</th>
                        <th>Nombre Completo</th>
                        <th>Usuario</th>
                        <th>Contacto</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                    <tr>
                        <td class="text-center">{{ $cliente->id }}</td>
                        <td class="text-center">
                            @if($cliente->foto)
                                <img src="{{ asset('storage/' . $cliente->foto) }}" 
                                     class="img-circle elevation-2" 
                                     alt="Foto de cliente"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($cliente->nombre.' '.$cliente->apellido) }}&background=random&color=fff" 
                                     class="img-circle elevation-2" 
                                     alt="Foto de cliente"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @endif
                        </td>
                        <td>
                            <strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong>
                        </td>
                        <td>{{ $cliente->nombre_usuario }}</td>
                        <td>
                            <i class="fas fa-envelope mr-1 text-primary"></i> {{ $cliente->correo }}<br>
                            <i class="fas fa-phone-alt mr-1 text-success"></i> {{ $cliente->celular }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('cliente.show', $cliente->id) }}" class="btn btn-sm btn-info" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-sm btn-warning" 
                                   title="Editar cliente" style="background-color: #ffaa33; border-color: #ffaa33;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('¿Está seguro de eliminar este cliente?')"
                                        title="Eliminar cliente">
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
    #clientes-table tbody tr {
        transition: all 0.2s ease;
    }
    #clientes-table tbody tr:hover {
        background-color: rgba(0, 210, 255, 0.05);
    }
    .btn-group .btn {
        margin-right: 2px;
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
    // Configuración común para DataTables
    const configDataTable = {
        responsive: true,
        autoWidth: false,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        dom: '<"top"lf>rt<"bottom"ip><"clear">', // Estructura del control de paginación
        pageLength: 7, // 7 registros por defecto
        lengthMenu: [[7, 10, 25, 50, 100], [7, 10, 25, 50, 100]], // Menú de longitud
        initComplete: function() {
            $('.dataTables_filter input').attr('placeholder', 'Buscar cliente...');
        }
    };

    $('#clientes-table').DataTable({
        ...configDataTable,
        columnDefs: [
            { responsivePriority: 1, targets: 2 },
            { responsivePriority: 2, targets: -1 },
            { orderable: false, targets: [1, -1] }
        ]
    });

    // Notificación Toastr en lugar de alert
    @if(session('success'))
    toastr.success('{{ session('success') }}', 'Éxito', {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 5000
    });
    @endif
});
</script>
@stop