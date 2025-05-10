<div class="modal fade" id="modalRecepcionEdit{{ $recepcion->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.recepcion_prendas.update', $recepcion->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Editar Recepción #{{ $recepcion->id }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <!-- Sección de información de asignación -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asignación #</label>
                                <input type="text" class="form-control" value="{{ $recepcion->asignacion_id }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confeccionista</label>
                                <input type="text" class="form-control" 
                                       value="{{ $recepcion->asignacion->nombre_confeccionista }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de datos de la prenda -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre de la Prenda *</label>
                                <input type="text" name="prenda_nombre" class="form-control" 
                                       value="{{ $recepcion->prenda_nombre }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Código (Opcional)</label>
                                <input type="text" name="codigo" class="form-control" value="{{ $recepcion->codigo }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Talla *</label>
                                <select name="talla" class="form-control" required>
                                    @foreach(App\Models\RecepcionPrenda::TALLAS as $talla)
                                        <option value="{{ $talla }}" {{ $recepcion->talla == $talla ? 'selected' : '' }}>
                                            {{ $talla }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Color *</label>
                                <input type="text" name="color" class="form-control" 
                                       value="{{ $recepcion->color }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cantidad *</label>
                                <input type="number" name="cantidad" class="form-control cantidad" 
                                       min="1" value="{{ $recepcion->cantidad }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Costo Unitario (Bs.) *</label>
                                <input type="number" step="0.01" name="costo_confeccion_unitario" 
                                       class="form-control costo-unitario" min="0" 
                                       value="{{ $recepcion->costo_confeccion_unitario }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total (Bs.)</label>
                                <input type="text" class="form-control total" 
                                       value="{{ number_format($recepcion->total, 2) }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recibido por *</label>
                                <select name="recibido_por" class="form-control" required>
                                    @foreach($responsables as $user)
                                        <option value="{{ $user->id }}" {{ $recepcion->recibido_por == $user->id ? 'selected' : '' }}>
                                            {{ $user->nombre }} {{ $user->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de Recepción *</label>
                                <input type="date" name="fecha_recepcion" class="form-control" 
                                       value="{{ $recepcion->fecha_recepcion->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Estado *</label>
                        <select name="estado" class="form-control" required>
                            @foreach(App\Models\RecepcionPrenda::ESTADOS as $key => $value)
                                <option value="{{ $key }}" {{ $recepcion->estado == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mostrar información del inventario si existe -->
                    @if($recepcion->inventario)
                    <div class="alert alert-info mt-3">
                        <h6><i class="fas fa-info-circle"></i> Información del Inventario</h6>
                        <p class="mb-1">Esta prenda está registrada en el inventario.</p>
                        <p class="mb-1">Precio de venta: Bs. {{ number_format($recepcion->inventario->precio_venta, 2) }}</p>
                        <p class="mb-0">Destino: {{ ucfirst($recepcion->inventario->destino) }}</p>
                    </div>
                    @endif

                    <div class="form-group mt-3">
                        <label>Observaciones</label>
                        <textarea name="observacion" class="form-control" rows="3">{{ $recepcion->observacion }}</textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Recepción</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Calcular total automáticamente
    function calcularTotal() {
        const cantidad = parseFloat($('.cantidad').val()) || 0;
        const costoUnitario = parseFloat($('.costo-unitario').val()) || 0;
        const total = cantidad * costoUnitario;
        $('.total').val(total.toFixed(2));
    }

    $('.cantidad, .costo-unitario').on('input', calcularTotal);
    
    // Inicializar el cálculo al cargar
    calcularTotal();
});
</script>
@endpush