<!-- resources/views/admin/gestion_material/modals/compras/show.blade.php -->
<div class="modal fade" id="modalShowCompra{{ $compra->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">
                    <i class="fas fa-file-invoice mr-2"></i>Detalles de Compra #{{ $compra->id }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <!-- Encabezado con información general -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-info"><i class="fas fa-truck"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Proveedor</span>
                                <span class="info-box-number">{{ $compra->proveedor->nombre }}</span>
                                <span>{{ $compra->proveedor->contacto }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-purple"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Registrado por</span>
                                <span class="info-box-number">{{ $compra->user->nombre }} {{ $compra->user->apellido }}</span>
                                <span>{{ $compra->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado y resumen -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="small-box bg-{{ 
                            $compra->estado == 'recibido' ? 'success' : 
                            ($compra->estado == 'cancelado' ? 'danger' : 'warning') 
                        }}">
                            <div class="inner">
                                <h3>{{ ucfirst($compra->estado) }}</h3>
                                <p>Estado de la compra</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-{{ 
                                    $compra->estado == 'recibido' ? 'check-circle' : 
                                    ($compra->estado == 'cancelado' ? 'times-circle' : 'clock') 
                                }}"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $compra->detalles->sum('cantidad') }}</h3>
                                <p>Total de unidades</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-cubes"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ number_format($compra->detalles->sum('precio_total'), 2) }}Bs</h3>
                                <p>Monto total</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de materiales -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Materiales comprados</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-light">
                                    <th>Material</th>
                                    <th class="text-center">Unidad</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-right">P. Unitario</th>
                                    <th class="text-right">Total</th>
                                    @if($compra->estado == 'recibido')
                                    <th class="text-center">Disponible</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($compra->detalles as $detalle)
                                <tr>
                                    <td>
                                        {{ $detalle->material->nombre }}
                                        @if($detalle->material->color)
                                        <span class="badge" style="background-color: {{ $detalle->material->color }}">&nbsp;</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $detalle->material->unidad_medida }}</td>
                                    <td class="text-center">{{ number_format($detalle->cantidad, 2) }}</td>
                                    <td class="text-right">{{ number_format($detalle->precio_unitario, 2) }}Bs</td>
                                    <td class="text-right">{{ number_format($detalle->precio_total, 2) }}Bs</td>
                                    @if($compra->estado == 'recibido')
                                    <td class="text-center">
                                        <span class="badge badge-{{ $detalle->inventarios->sum('stock_actual') > 0 ? 'success' : 'danger' }}">
                                            {{ $detalle->inventarios->sum('stock_actual') }}
                                        </span>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Detalle de almacenes (solo para compras recibidas) -->
                @if($compra->estado == 'recibido')
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-warehouse mr-2"></i>Distribución en almacenes</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>Material</th>
                                    <th>Almacén</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Fecha recepción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($compra->detalles as $detalle)
                                    @foreach($detalle->inventarios as $inventario)
                                    <tr>
                                        <td>{{ $detalle->material->nombre }}</td>
                                        <td>{{ $inventario->almacen->nombre }}</td>
                                        <td class="text-center">{{ $inventario->stock_actual }}</td>
                                        <td class="text-center">{{ $inventario->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Cerrar
                </button>
                
                @if($compra->estado == 'pendiente')
                <button type="button" class="btn btn-success" 
                        data-dismiss="modal"
                        data-toggle="modal" 
                        data-target="#modalRecibirCompra{{ $compra->id }}">
                    <i class="fas fa-check-circle mr-2"></i>Recibir compra
                </button>
                
                <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Cancelar esta compra?')">
                        <i class="fas fa-ban mr-2"></i>Cancelar compra
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>