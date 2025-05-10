@extends('adminlte::page')

@section('title', 'Gestión de Confecciones')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-tshirt mr-2"></i>Gestión de Confecciones</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Inicio</a></li>
                <li class="breadcrumb-item active">Confecciones</li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Fila 1: Confeccionistas + Asignaciones -->
    <div class="row">
        <!-- Sección Confeccionistas -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header bg-gradient-wine">
                    <h3 class="card-title">
                        <i class="fas fa-user-secret mr-2"></i>Confeccionistas
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-light btn-sm rounded-circle" data-toggle="modal" 
                                data-target="#modalConfeccionistaCreate" title="Nuevo confeccionista">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="confeccionistas-table" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr class="bg-gradient-wine">
                                    <th>Nombre</th>
                                    <th width="100" class="text-center">Estado</th>
                                    <th width="80" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($confeccionistas as $confeccionista)
                                <tr>
                                    <td>
                                        <strong>{{ $confeccionista->nombre }} {{ $confeccionista->apellido }}</strong><br>
                                        <small class="text-muted">{{ $confeccionista->celular }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $confeccionista->estado ? 'success' : 'danger' }}">
                                            {{ $confeccionista->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="#" class="text-warning mr-2" data-toggle="modal" 
                                               data-target="#modalConfeccionistaEdit{{ $confeccionista->id }}" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('confeccionistas.destroy', $confeccionista->id) }}" 
                                                  method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger border-0 bg-transparent" 
                                                        onclick="return confirm('¿Eliminar confeccionista?')" 
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

        <!-- Sección Asignaciones -->
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header bg-gradient-orange">
                    <h3 class="card-title">
                        <i class="fas fa-box-open mr-2"></i>Asignaciones de Materiales
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-light btn-sm rounded-circle" data-toggle="modal" 
                                data-target="#modalCreate" title="Nueva asignación">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <script>
                        toastr.success('{{ session('success') }}', 'Éxito', {
                            closeButton: true,
                            progressBar: true,
                            positionClass: 'toast-top-right'
                        });
                    </script>
                    @endif

                    <div class="table-responsive">
                        <table id="asignaciones-table" class="table table-striped table-hover" style="width:100%">
                            <thead class="bg-gradient-orange">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Confeccionista</th>
                                    <th>Responsable</th>
                                    <th>Materiales</th>
                                    <th>Fecha Entrega</th>
                                    <th>Estado</th>
                                    <th width="100" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asignaciones as $asignacion)
                                <tr>
                                    <td class="text-center">{{ $asignacion->id }}</td>
                                    <td>
                                        <strong>{{ $asignacion->confeccionista->nombre }} {{ $asignacion->confeccionista->apellido }}</strong>
                                        @if(!$asignacion->confeccionista->estado)
                                            <span class="badge badge-danger ml-2">INACTIVO</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($asignacion->responsable)->nombre }} {{ ($asignacion->responsable)->apellido }}</td>
                                    <td>
                                        @foreach($asignacion->materiales_asignados as $material)
                                            <span class="badge badge-pill badge-light mb-1">
                                                {{ $material['nombre'] }} <strong>({{ $material['cantidad'] }})</strong>
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-alt text-info mr-1"></i>
                                        {{ $asignacion->fecha_entrega_estimada->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-{{ $asignacion->estado_color }}">
                                            {{ ucfirst($asignacion->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="#" class="text-warning mr-2" data-toggle="modal" 
                                               data-target="#modalEdit{{ $asignacion->id }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($asignacion->estado == 'completado')
                                            <a href="#" class="text-success" data-toggle="modal" 
                                               data-target="#modalRecepcionCreate{{ $asignacion->id }}" title="Recepción">
                                                <i class="fas fa-tshirt"></i>
                                            </a>
                                            @endif
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

    <!-- Fila 2: Recepción de Prendas -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header bg-gradient-teal">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-check mr-2"></i>Recepción de Prendas
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-light btn-sm rounded-circle" data-toggle="modal" 
                                data-target="#modalSeleccionAsignacion" title="Nueva recepción">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="recepciones-table" class="table table-striped table-hover" style="width:100%">
                            <thead class="bg-gradient-teal">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Prenda</th>
                                    <th>Asignación</th>
                                    <th>Recepcionado por</th>
                                    <th>Talla/Color</th>
                                    <th class="text-center">Cantidad</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th width="100" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recepciones as $recepcion)
                                <tr>
                                    <td class="text-center">{{ $recepcion->id }}</td>
                                    <td><strong>{{ $recepcion->prenda_nombre }}</strong></td>
                                    <td><span class="badge badge-pill badge-secondary">#{{ $recepcion->asignacion_id }}</span></td>
                                    <td>{{ optional($recepcion->recibidoPor)->nombre }} {{ ($recepcion->recibidoPor)->apellido }}</td>
                                    <td>
                                        <span class="badge badge-pill badge-info">{{ $recepcion->talla }}</span>
                                        <span class="badge badge-pill" style="background-color: {{ $recepcion->color }}; color: dark;">
                                            {{ $recepcion->color }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $recepcion->cantidad }}</td>
                                    <td><strong>{{ number_format($recepcion->total, 2) }} Bs</strong></td>
                                    <td>
                                        <span class="badge badge-pill badge-{{ $recepcion->estado == 'aprobado' ? 'success' : ($recepcion->estado == 'devuelto' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($recepcion->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="#" class="text-warning mr-2" data-toggle="modal" 
                                               data-target="#modalRecepcionEdit{{ $recepcion->id }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.recepcion_prendas.destroy', $recepcion->id) }}" 
                                                  method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger border-0 bg-transparent" 
                                                        onclick="return confirm('¿Eliminar recepción?')" 
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
</div>

<!-- Modal para seleccionar asignación completada -->
<div class="modal fade" id="modalSeleccionAsignacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success">
                <h5 class="modal-title text-white">
                    <i class="fas fa-clipboard-list mr-2"></i>Seleccionar Asignación Completada
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Seleccione una asignación:</label>
                    <select class="form-control select2" id="selectAsignacion" style="width: 100%;">
                        <option value="">-- Seleccione --</option>
                        @foreach($asignaciones->where('estado', 'completado') as $asignacion)
                            <option value="{{ $asignacion->id }}">
                                #{{ $asignacion->id }} - 
                                {{ $asignacion->confeccionista->nombre }} {{ $asignacion->confeccionista->apellido }} - 
                                @foreach($asignacion->materiales_asignados as $material)
                                    {{ $material['nombre'] }} ({{ $material['cantidad'] }})
                                    @if(!$loop->last), @endif
                                @endforeach
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="btnContinuarRecepcion">
                    <i class="fas fa-check mr-1"></i>Continuar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('admin.asignacion_material.modals.confeccionista.create')
@foreach($confeccionistas as $confeccionista)
    @include('admin.asignacion_material.modals.confeccionista.edit', ['confeccionista' => $confeccionista])
@endforeach

@include('admin.asignacion_material.modals.asignacion.create')
@foreach($asignaciones as $asignacion)
    @include('admin.asignacion_material.modals.asignacion.edit', ['asignacion' => $asignacion])
    @if($asignacion->estado == 'completado')
        @include('admin.asignacion_material.modals.recepcion.create', ['asignacion' => $asignacion])
    @endif
@endforeach

@foreach($recepciones as $recepcion)
    @include('admin.asignacion_material.modals.recepcion.edit', ['recepcion' => $recepcion])
@endforeach

@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    /* Nuevo gradiente vino/guindo */
    .bg-gradient-wine {
        background: linear-gradient(135deg, #722f37, #4a1c24);
        color: white;
    }
    .bg-gradient-orange {
        background: linear-gradient(135deg, #ffb347, #ffcc33);
        color: white;
    }
    .bg-gradient-aqua {
        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
        color: white;
    }
    .bg-gradient-teal {
        background: linear-gradient(135deg, #11998e, #38ef7d);
        color: white;
    }
    .bg-gradient-dark {
        background: linear-gradient(135deg, #343a40, #212529);
        color: white;
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
    .action-buttons a, .action-buttons button {
        transition: all 0.2s ease;
    }
    .action-buttons a:hover, .action-buttons button:hover {
        transform: scale(1.2);
    }
    .badge-pill {
        padding: 0.35em 0.65em;
        margin: 0.1em;
        font-weight: 500;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .rounded-circle {
        border-radius: 50% !important;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    [title] {
        cursor: pointer;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    // Configuración común para DataTables
    const configDataTable = {
        responsive: true,
        autoWidth: false,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        pageLength: 4, // Mostrar 4 registros por defecto
        lengthMenu: [4, 10, 25, 50, 100],
        initComplete: function() {
            $('.dataTables_filter input').attr('placeholder', 'Buscar...');
        }
    };

    // Tabla de confeccionistas
    $('#confeccionistas-table').DataTable({
        ...configDataTable,
        pageLength: 4, // 4 registros por defecto
        lengthMenu: [4, 10, 25, 50, 100],
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 },
            { orderable: false, targets: -1 }
        ]
    });

    // Tabla de asignaciones
    $('#asignaciones-table').DataTable({
        ...configDataTable,
        pageLength: 4, // 4 registros por defecto
        columnDefs: [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: -1 },
            { orderable: false, targets: -1 }
        ]
    });

    // Tabla de recepciones
    $('#recepciones-table').DataTable({
        ...configDataTable,
        pageLength: 5, // 5 registros por defecto
        lengthMenu: [5, 10, 25, 50, 100],
        columnDefs: [
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: -1 },
            { orderable: false, targets: -1 }
        ]
    });

    // Configuración Toastr
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 5000,
        preventDuplicates: true
    };

    // Mostrar notificación si hay mensaje de sesión
    @if(session('success'))
        toastr.success('{{ session('success') }}', 'Éxito');
    @endif
    @if(session('error'))
        toastr.error('{{ session('error') }}', 'Error');
    @endif
    @if(session('warning'))
        toastr.warning('{{ session('warning') }}', 'Advertencia');
    @endif

    // Tooltips para botones
    $('[title]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
});

// Manejar clic en "Continuar" para abrir el modal de creación correspondiente
$('#btnContinuarRecepcion').click(function() {
        const asignacionId = $('#selectAsignacion').val();
        if (asignacionId) {
            $('#modalSeleccionAsignacion').modal('hide');
            $(`#modalRecepcionCreate${asignacionId}`).modal('show');
        }
    });
</script>
@stop