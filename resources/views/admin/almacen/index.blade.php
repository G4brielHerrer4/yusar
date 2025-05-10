@extends('adminlte::page')

@section('title', 'Gestión de Almacén')

@section('content_header')
    <h1 class="m-0 text-dark">
        <i class="fas fa-warehouse"></i> Inventario en Almacén
    </h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Prendas Disponibles</h3>
    </div>
    <div class="card-body">
        <table id="almacenTable" class="table table-bordered table-hover table-striped">
            <thead class="bg-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Prenda</th>
                    <th>Detalles</th>
                    <th>Stock</th>
                    <th>Ubicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prendas as $prenda)
                <tr>
                    <td>{{ $prenda->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @php
                                // Manejo seguro de la imagen principal
                                $imagenPrincipal = $prenda->inventario->imagen_principal 
                                    ? (Str::startsWith($prenda->inventario->imagen_principal, 'storage/')
                                        ? $prenda->inventario->imagen_principal
                                        : 'storage/'.$prenda->inventario->imagen_principal)
                                    : 'https://via.placeholder.com/60?text=Sin+imagen';
                            @endphp
                            
                            <img src="{{ asset($imagenPrincipal) }}" 
                                 class="img-thumbnail mr-3" 
                                 width="60"
                                 onerror="this.src='https://via.placeholder.com/60?text=Error+imagen'">
                            
                            <div>
                                <strong>{{ $prenda->inventario->recepcion->prenda_nombre ?? 'Nombre no disponible' }}</strong><br>
                                {{-- <small class="text-muted">
                                    {{ $prenda->inventario->recepcion->tipo_prenda ?? 'Tipo no especificado' }}
                                </small> --}}
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $prenda->inventario->talla }}
                        </span>
                        <span class="badge" style="background: {{ $prenda->inventario->color }}; color: dark;">
                            {{ $prenda->inventario->color }}
                        </span><br>
                        <small>
                            <i class="fas fa-tag"></i> {{ $prenda->inventario->categoria->nombre ?? 'N/A' }}<br>
                            <i class="fas fa-palette"></i> {{ $prenda->inventario->coleccion->nombre ?? 'N/A' }}
                        </small>
                    </td>
                    <td>
                        <span class="font-weight-bold">{{ $prenda->cantidad }}</span> / 
                        <small>{{ $prenda->inventario->cantidad_total }} total</small>
                    </td>
                    <td>
                        @if($prenda->ubicacion)
                            <span class="badge bg-success">
                                <i class="fas fa-map-marker-alt"></i> {{ $prenda->ubicacion }}
                            </span>
                        @else
                            <span class="text-muted">Sin ubicación</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary transfer-btn"
                                data-toggle="modal" 
                                data-target="#transferModal"
                                data-id="{{ $prenda->id }}"
                                data-max="{{ $prenda->cantidad }}">
                            <i class="fas fa-exchange-alt"></i> Transferir
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para transferencia -->
<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="transferModalLabel">Transferir al Catálogo</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="transferForm" action="{{ route('admin.almacen.transferir') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="prenda_id" id="prenda_id">
                    <div class="form-group">
                        <label for="quantity">Cantidad a transferir</label>
                        <input type="number" class="form-control" 
                               id="quantity" name="quantity" 
                               min="1" value="1" required>
                        <small id="maxHelp" class="form-text text-muted"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .img-thumbnail {
            border-radius: 8px;
            object-fit: cover;
        }
        .badge {
            font-size: 0.9em;
            margin-right: 5px;
        }
        #almacenTable_wrapper .row:first-child {
            padding: 0.5rem;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Configuración de DataTable en español
    $('#almacenTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
        },
        "responsive": true,
        "autoWidth": false
    });

    // Configuración del modal
    $('#transferModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var prendaId = button.data('id');
        var maxQuantity = button.data('max');
        
        var modal = $(this);
        modal.find('#prenda_id').val(prendaId);
        modal.find('#quantity').attr('max', maxQuantity);
        modal.find('#maxHelp').text('Máximo disponible: ' + maxQuantity);
    });

    // Manejo del formulario
    $('#transferForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#transferModal').modal('hide');
                toastr.success(response.message);
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.message);
            }
        });
    });

    // Mostrar notificaciones de sesión
    @if(session('success'))
        toastr.success('{{ session('success') }}');
    @endif
    @if(session('error'))
        toastr.error('{{ session('error') }}');
    @endif
});
</script>
@stop