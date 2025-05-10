@extends('adminlte::page')

@section('title', 'Gestión de Materiales')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                <i class="fas fa-boxes mr-2 text-primary"></i>Gestión de Materiales
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Materiales</li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Notificaciones -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check-circle"></i> ¡Éxito!</h5>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any()))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-circle"></i> Error!</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Primera Fila -->
    <div class="row">
        <!-- Materiales -->
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header border-0 bg-gradient-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0 text-white">
                            <i class="fas fa-box-open mr-2"></i>Materiales
                        </h3>
                        <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm" data-toggle="modal" data-target="#modalCrearMaterial" title="Agregar material">
                            <i class="fas fa-plus text-primary"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tablaMateriales" class="table table-hover table-sm w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th class="bg-gradient-primary text-white">Nombre</th>
                                    <th class="bg-gradient-primary text-white" width="100">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materiales as $material)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($material->imagen)
                                            <img src="{{ asset('storage/' . $material->imagen) }}" 
                                                class="img-circle mr-2" width="30" height="30" 
                                                alt="{{ $material->nombre }}">
                                            @else
                                            <div class="img-circle mr-2 bg-primary d-flex align-items-center justify-content-center" 
                                                style="width:30px;height:30px;">
                                                <i class="fas fa-box text-white"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>{{ $material->nombre }}</strong>
                                                <div class="text-muted small d-flex align-items-center">
                                                    @if($material->color)
                                                    <span class="color-badge mr-2" 
                                                        style="background-color: {{ $material->color }}"></span>
                                                    @endif
                                                    {{ $material->unidad_medida }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-warning" data-toggle="modal" 
                                                    data-target="#modalEditarMaterial{{ $material->id }}"
                                                    title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.gestion_material.materiales.modals.destroy', $material->id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" 
                                                        onclick="return confirm('¿Eliminar este material?')"
                                                        title="Eliminar">
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
        </div>

        <!-- Proveedores -->
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header border-0 bg-gradient-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0 text-white">
                            <i class="fas fa-truck mr-2"></i>Proveedores
                        </h3>
                        <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm" data-toggle="modal" data-target="#modalCrearProveedor" title="Agregar proveedor">
                            <i class="fas fa-plus text-success"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tablaProveedores" class="table table-hover table-sm w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th class="bg-gradient-green text-white">Nombre</th>
                                    <th class="bg-gradient-green text-white" width="100">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proveedores as $proveedor)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <i class="fas fa-building text-muted"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $proveedor->nombre }}</strong>
                                                <div class="text-muted small">
                                                    {{ $proveedor->contacto }}
                                                    {{ $proveedor->ci ? ' | CI: '.$proveedor->ci : '' }}
                                                    <span class="badge badge-{{ $proveedor->activo ? 'success' : 'danger' }}">
                                                        {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-warning" data-toggle="modal" 
                                                    data-target="#modalEditarProveedor{{ $proveedor->id }}"
                                                    title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.gestion_material.modals.proveedores.destroy', $proveedor->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" 
                                                        onclick="return confirm('¿Eliminar este proveedor?')"
                                                        title="Eliminar">
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
        </div>

        <!-- Almacenes -->
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header border-0 bg-gradient-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0 text-white">
                            <i class="fas fa-warehouse mr-2"></i>Almacenes
                        </h3>
                        <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm" data-toggle="modal" data-target="#modalCrearAlmacen" title="Agregar almacén">
                            <i class="fas fa-plus text-info"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tablaAlmacenes" class="table table-hover table-sm w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th class="bg-gradient-info text-white">Nombre</th>
                                    <th class="bg-gradient-info text-white" width="100">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($almacenes as $almacen)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <i class="fas fa-warehouse text-muted"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $almacen->nombre }}</strong>
                                                <div class="text-muted small">
                                                    {{ $almacen->ubicacion }}
                                                    <span class="badge badge-{{ $almacen->activo ? 'success' : 'danger' }}">
                                                        {{ $almacen->activo ? 'Activo' : 'Inactivo' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-warning" data-toggle="modal" 
                                                    data-target="#modalEditarAlmacen{{ $almacen->id }}"
                                                    title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.gestion_material.modals.almacenes.destroy', $almacen->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" 
                                                        onclick="return confirm('¿Eliminar este almacén?')"
                                                        title="Eliminar">
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
        </div>
    </div>

    <!-- Segunda Fila: Compras -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-purple">
                <div class="card-header border-0 bg-gradient-purple">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title m-0 text-white">
                            <i class="fas fa-shopping-cart mr-2"></i>Compras
                        </h3>
                        <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm" data-toggle="modal" data-target="#modalCrearCompra" title="Nueva compra">
                            <i class="fas fa-plus text-purple"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="tablaCompras" class="table table-hover table-sm w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th class="bg-gradient-purple text-white" width="50">ID</th>
                                    <th class="bg-gradient-purple text-white">Proveedor</th>
                                    <th class="bg-gradient-purple text-white">Materiales</th>
                                    <th class="bg-gradient-purple text-white" width="100">Total</th>
                                    <th class="bg-gradient-purple text-white" width="100">Estado</th>
                                    <th class="bg-gradient-purple text-white" width="120">Fecha</th>
                                    <th class="bg-gradient-purple text-white" width="140">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compras as $compra)
                                <tr>
                                    <td>{{ $compra->id }}</td>
                                    <td>
                                        <strong>{{ $compra->proveedor->nombre }}</strong>
                                        <small class="text-muted d-block">{{ $compra->user->name }}</small>
                                    </td>
                                    <td>
                                        @foreach ($compra->detalles as $detalle)
                                        <span class="badge badge-info mb-1">
                                            {{ $detalle->material->nombre }} ({{ $detalle->cantidad }} {{ $detalle->material->unidad_medida }})
                                        </span>
                                        @endforeach
                                    </td>
                                    <td class="text-nowrap">{{ number_format($compra->detalles->sum('precio_total')) }} Bs</td>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $compra->estado == 'recibido' ? 'success' : 
                                            ($compra->estado == 'cancelado' ? 'danger' : 'warning') 
                                        }}">
                                            {{ ucfirst($compra->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <small>{{ $compra->fecha_entrega_estimada->timezone('America/La_Paz')->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($compra->estado == 'recibido')
                                            <a href="{{ route('compras.download', $compra->id) }}" class="btn btn-outline-danger" title="Descargar PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            @endif
                                            
                                            @if($compra->estado == 'pendiente')
                                            <button class="btn btn-outline-success" data-toggle="modal" 
                                                    data-target="#modalRecibirCompra{{ $compra->id }}"
                                                    title="Recibir">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                            @endif
                                            
                                            <button class="btn btn-outline-info" data-toggle="modal" 
                                                    data-target="#modalShowCompra{{ $compra->id }}"
                                                    title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals  -->
@include('admin.gestion_material.modals.materiales.create')
@include('admin.gestion_material.modals.proveedores.create')
@include('admin.gestion_material.modals.almacenes.create')
@include('admin.gestion_material.modals.compras.create')


@foreach ($materiales as $material)
    @include('admin.gestion_material.modals.materiales.edit', ['material' => $material])
@endforeach

@foreach ($proveedores as $proveedor)
    @include('admin.gestion_material.modals.proveedores.edit', ['proveedor' => $proveedor])
@endforeach

@foreach ($almacenes as $almacen)
    @include('admin.gestion_material.modals.almacenes.edit', ['almacen' => $almacen])
@endforeach

@foreach ($compras->where('estado', 'pendiente') as $compra)
    @include('admin.gestion_material.modals.compras.recibir', ['compra' => $compra])
@endforeach

@foreach($compras as $compra)
    @include('admin.gestion_material.modals.compras.show', ['compra' => $compra])
@endforeach

@stop

@section('css')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

<style>
    /* Estilos mejorados para la barra de búsqueda */
    .dataTables_filter {
        padding: 15px 15px 5px 15px;
        background: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
    }
    
    .dataTables_filter input {
        border-radius: 0.35rem;
        border: 1px solid #d1d3e2;
        padding: 0.375rem 0.75rem;
    }
    
    /* Icono por defecto para materiales */
    .img-circle.bg-primary {
        background-color: #4e73df !important;
    }
    
    /* Espaciado mejorado en tablas */
    .table-sm td, .table-sm th {
        padding: 0.75rem;
    }
    
    /* Efecto hover para botones PDF */
    .btn-outline-danger:hover {
        background-color: #e74a3b;
        color: white !important;
    }
    
    /* Resto de estilos previos se mantienen */
    :root {
        --purple: #6f42c1;
        --light-purple: #e2d9f3;
    }
    
    body {
        background-color: #f8f9fc;
    }
    
    .card {
        border-radius: 0.5rem;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .card-header {
        padding: 0.75rem 1.25rem;
        border-bottom: none;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
    }
    
    .bg-gradient-purple {
        background: linear-gradient(135deg, var(--purple) 0%, #59359a 100%);
    }
    
    .btn-light {
        background-color: white;
        border-color: white;
    }
    
    .rounded-circle {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .table-responsive {
        border-radius: 0 0 0.5rem 0.5rem;
    }
    
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.5em;
    }
    
    @media (max-width: 768px) {
        .row > div {
            margin-bottom: 1.5rem;
        }
    }
    
    /* Animación para botones */
    .btn-light:hover {
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    
    /* Estilo para las tablas */
    .table-sm td, .table-sm th {
        padding: 0.75rem;
        font-size: 0.85rem;
    }
    
    /* Color para los iconos de acciones */
    .btn-outline-warning {
        color: #f6c23e;
        border-color: #f6c23e;
    }
    
    .btn-outline-danger {
        color: #e74a3b;
        border-color: #e74a3b;
    }
    
    .btn-outline-info {
        color: #36b9cc;
        border-color: #36b9cc;
    }
    
    .btn-outline-success {
        color: #1cc88a;
        border-color: #1cc88a;
    }

</style>
@stop

@section('js')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"></script>

<script>
$(document).ready(function() {
    // Configuración DataTables con mejor espaciado
    const configDataTable = {
        responsive: true,
        autoWidth: false,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        pageLength: 4,
        lengthMenu: [4, 10, 25, 50, 100],
        order: [[0, 'asc']],
        initComplete: function() {
            // Añadir clase al input de búsqueda
            $('.dataTables_filter input').addClass('form-control-sm');
        }
    };

    // Inicializar DataTables
    $('#tablaMateriales, #tablaProveedores, #tablaAlmacenes').DataTable(configDataTable);
    
    $('#tablaCompras').DataTable({
        ...configDataTable,
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[5, 'asc']]
    });

    // Tooltips
    $('[title]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
});
</script>
@stop