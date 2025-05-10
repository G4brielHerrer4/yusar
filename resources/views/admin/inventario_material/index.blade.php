@extends('adminlte::page')

@section('title', 'Inventario CEP - Confecciones')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">
        <i class="fas fa-tshirt"></i> Inventario de Materiales con CEP
    </h1>
    <button class="btn btn-dark" data-toggle="modal" data-target="#modalHelpCEP">
        <i class="fas fa-question-circle"></i> Ayuda CEP
    </button>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-warning card-outline">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-boxes mr-2"></i>Materiales para Confección
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="tabla-inventario" class="table table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Material</th>
                                <th class="text-center">Stock Actual</th>
                                <th class="text-center">Almacén</th>
                                <th class="text-center">Configuración CEP</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventario as $item)
                            @php
                                $cep = $item->configuracionCep;
                                $alertaStock = $cep && $item->stock_actual <= $cep->punto_reorden;
                                $nivelAdvertencia = $cep && $item->stock_actual <= ($cep->punto_reorden * 1.2) && $item->stock_actual >= $cep->punto_reorden;
                                $igualPuntoReorden = $cep && $item->stock_actual == $cep->punto_reorden;
                                $porcentajeStock = $cep ? ($item->stock_actual/$cep->punto_reorden)*100 : 0;
                            @endphp
                            <tr class="@if($alertaStock) table-danger alert-blink @elseif($igualPuntoReorden || $nivelAdvertencia) table-warning @endif">
                                <!-- Material -->
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative mr-3">
                                            @if($item->material->imagen)
                                            <img src="{{ asset('storage/'.$item->material->imagen) }}" 
                                                 class="img-circle elevation-2" width="40" height="40">
                                            @else
                                            <div class="img-circle bg-gradient-dark elevation-2 d-flex align-items-center justify-content-center" 
                                                 style="width:40px;height:40px;">
                                                <i class="fas fa-cut text-light"></i>
                                            </div>
                                            @endif
                                            {{-- @if($alertaStock || $igualPuntoReorden)
                                            <span class="position-absolute top-0 start-100 translate-middle p-1 @if($alertaStock) bg-danger @else bg-warning @endif border border-light rounded-circle pulse-alert">
                                                <span class="visually-hidden">Alerta</span>
                                            </span>
                                            @endif --}}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $item->material->nombre }}</h6>
                                            <small class="text-muted d-flex align-items-center">
                                                @if($item->material->color)
                                                <span class="color-badge mr-2" 
                                                      style="background-color: {{ $item->material->color }}"
                                                      title="Color: {{ $item->material->color }}"></span>
                                                @else
                                                <span class="color-badge mr-2 bg-secondary"
                                                      title="Sin color definido"></span>
                                                @endif
                                                {{ $item->material->unidad_medida }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Stock -->
                                <td class="text-center align-middle">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="badge badge-pill @if($alertaStock) badge-danger pulse @elseif($igualPuntoReorden || $nivelAdvertencia) badge-warning @else badge-success @endif mb-1" 
                                              style="font-size: 0.9em; min-width: 70px;">
                                            {{ number_format($item->stock_actual, 2) }}
                                        </span>
                                        @if($cep)
                                        <div class="progress w-100" style="height: 6px;">
                                            <div class="progress-bar @if($alertaStock) bg-danger @elseif($igualPuntoReorden || $nivelAdvertencia) bg-warning @else bg-success @endif" 
                                                 style="width: {{ min(100, $porcentajeStock) }}%"
                                                 role="progressbar">
                                            </div>
                                        </div>
                                        <small class="text-muted mt-1">
                                            {{ round($porcentajeStock) }}% del mínimo
                                        </small>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Almacén -->
                                <td class="text-center align-middle">
                                    <span class="badge badge-light border shadow-sm">
                                        <i class="fas fa-warehouse text-primary mr-1"></i>
                                        {{ Str::limit($item->almacen->nombre, 15) }}
                                    </span>
                                </td>
                                
                                <!-- Configuración CEP -->
                                <td class="text-center align-middle">
                                    @if($cep)
                                    <div class="d-flex justify-content-around">
                                        <div class="text-center px-1">
                                            <div class="cep-badge badge-info-light border border-info text-info p-2 rounded-lg" 
                                                 data-toggle="tooltip" title="Cantidad Económica de Pedido">
                                                <i class="fas fa-cube d-block mb-1"></i>
                                                <small>{{ round($cep->cantidad_economica) }}</small>
                                            </div>
                                        </div>
                                        <div class="text-center px-1">
                                            <div class="cep-badge badge-warning-light border border-warning text-orange p-2 rounded-lg" 
                                                 data-toggle="tooltip" title="Punto de Reorden">
                                                <i class="fas fa-exclamation-triangle d-block mb-1"></i>
                                                <small>{{ round($cep->punto_reorden) }}</small>
                                            </div>
                                        </div>
                                        <div class="text-center px-1">
                                            <div class="cep-badge badge-primary-light border border-primary text-primary p-2 rounded-lg" 
                                                 data-toggle="tooltip" title="Frecuencia de Pedido">
                                                <i class="fas fa-calendar-alt d-block mb-1"></i>
                                                <small>{{ $cep->frecuencia_dias }}d</small>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <button class="btn btn-sm btn-outline-info rounded-pill py-1 px-3" 
                                            data-toggle="modal" 
                                            data-target="#modalConfigCEP{{ $item->id }}">
                                        <i class="fas fa-cog mr-1"></i> Configurar
                                    </button>
                                    @endif
                                </td>
                                
                                <!-- Estado -->
                                <td class="text-center align-middle">
                                    @if($cep)
                                    <div class="d-flex flex-column align-items-center">
                                        @if($alertaStock)
                                        <span class="badge badge-danger badge-pill mb-1 pulse">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> CRÍTICO
                                        </span>
                                        <small class="text-danger">¡Necesita reorden urgente!</small>
                                        @elseif($igualPuntoReorden)
                                        <span class="badge badge-warning badge-pill mb-1 pulse">
                                            <i class="fas fa-exclamation-circle mr-1"></i> ALERTA
                                        </span>
                                        <small class="text-warning">Stock en punto de reorden</small>
                                        @elseif($nivelAdvertencia)
                                        <span class="badge badge-warning badge-pill mb-1">
                                            <i class="fas fa-exclamation-circle mr-1"></i> ALERTA
                                        </span>
                                        <small class="text-warning">Próximo a reorden</small>
                                        @else
                                        <span class="badge badge-success badge-pill mb-1">
                                            <i class="fas fa-check-circle mr-1"></i> NORMAL
                                        </span>
                                        <small class="text-success">Stock suficiente</small>
                                        @endif
                                    </div>
                                    @else
                                    <span class="badge badge-secondary badge-pill">
                                        <i class="fas fa-question-circle mr-1"></i> SIN CEP
                                    </span>
                                    @endif
                                </td>
                                
                                <!-- Acciones -->
                                <td class="text-center align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-info rounded-circle mr-1" 
                                                data-toggle="modal" 
                                                data-target="#modalConfigCEP{{ $item->id }}"
                                                title="{{ $cep ? 'Editar' : 'Configurar' }} CEP">
                                            <i class="fas {{ $cep ? 'fa-edit' : 'fa-cog' }}"></i>
                                        </button>
                                        
                                        @if($cep && ($alertaStock || $igualPuntoReorden))
                                        <button class="btn btn-danger rounded-circle pulse" 
                                                onclick="generarOrdenCompra({{ $item->id }})"
                                                title="Generar orden de compra urgente">
                                            <i class="fas fa-bolt"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="badge badge-danger badge-pill mr-2 pulse">CRÍTICO</span>
                        <span class="badge badge-warning badge-pill mr-2">ALERTA</span>
                        <span class="badge badge-success badge-pill">NORMAL</span>
                    </div>
                    <div class="text-right">
                        <small class="text-muted">Actualizado: {{ now()->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes para los modals -->
@foreach ($inventario as $item)
    @if($item->configuracionCep)
        @include('admin.inventario_material.modals.configuracion_cep.edit', ['item' => $item])
    @else
        @include('admin.inventario_material.modals.configuracion_cep.create', ['item' => $item])
    @endif
@endforeach

<!-- Modal Ayuda CEP -->
<div class="modal fade" id="modalHelpCEP" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h5 class="modal-title">
                    <i class="fas fa-calculator mr-2"></i>Teoría CEP para Confección
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb mr-2"></i>¿Qué es el CEP?</h6>
                    <p class="mb-2">La Cantidad Económica de Pedido optimiza tus costos de inventario para materiales de confección.</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-gradient-light shadow">
                            <span class="info-box-icon bg-info"><i class="fas fa-cube"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">CEP</span>
                                <span class="info-box-number">√(2DS/H)</span>
                                <div class="progress">
                                    <div class="progress-bar bg-info" style="width: 100%"></div>
                                </div>
                                <small>D: Demanda anual<br>S: Costo pedido<br>H: Costo almacenamiento</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-gradient-light shadow">
                            <span class="info-box-icon bg-warning"><i class="fas fa-exclamation"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Punto Reorden</span>
                                <span class="info-box-number">d × L</span>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 100%"></div>
                                </div>
                                <small>d: Demanda diaria<br>L: Tiempo entrega</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* Efectos de alerta */
    .alert-blink {
        animation: blinkAlert 2s infinite;
    }
    
    @keyframes blinkAlert {
        0% { background-color: rgba(220, 53, 69, 0.1); }
        50% { background-color: rgba(220, 53, 69, 0.3); }
        100% { background-color: rgba(220, 53, 69, 0.1); }
    }
    
    .pulse {
        animation: pulse 1.5s infinite;
    }
    
    .pulse-alert {
        animation: pulse 0.8s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    /* Efecto hover para iconos CEP */
    .cep-badge {
        transition: all 0.2s ease;
        transform-origin: center;
    }
    
    .cep-badge:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Estilos para badges */
    .badge-info-light {
        background-color: rgba(23, 162, 184, 0.1);
    }
    .badge-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .badge-primary-light {
        background-color: rgba(0, 123, 255, 0.1);
    }
    
    /* Mejoras visuales */
    .rounded-lg {
        border-radius: 10px !important;
    }
    
    .table-danger td {
        border-left: 3px solid #dc3545;
    }
    
    .table-warning td {
        border-left: 3px solid #ffc107;
    }
    
    .progress {
        border-radius: 3px;
        background-color: #f0f0f0;
    }
    
    .img-circle {
        border-radius: 50%;
        object-fit: cover;
    }
    
    /* Efecto hover para filas */
    .table-hover tbody tr:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }
    .color-badge {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 1px solid #dee2e6;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        flex-shrink: 0; /* Evita que se encoja en dispositivos pequeños */
        cursor: help; /* Cambia el cursor para indicar que tiene tooltip */
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Inicializar DataTable con configuración en español
    $('#tabla-inventario').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
        "responsive": true,
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        "order": [[4, 'asc'], [1, 'asc']], // Ordenar por estado y stock
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "initComplete": function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    // Función mejorada para generar orden de compra
    window.generarOrdenCompra = function(inventarioId) {
        Swal.fire({
            title: '¿Generar orden de compra urgente?',
            html: `<div class="alert alert-danger">
                      <i class="fas fa-exclamation-triangle mr-2"></i>
                      Esta acción creará una solicitud automática para reponer el stock crítico
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-bolt"></i> Generar Urgente',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`/admin/inventario_material/${inventarioId}/generar-orden`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Error: ${error}`
                    )
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '¡Orden Generada!',
                    html: `<div class="alert alert-success">
                              <i class="fas fa-check-circle mr-2"></i>
                              La solicitud de compra urgente ha sido creada
                           </div>`,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    location.reload();
                });
            }
        });
    };
});
</script>
@stop