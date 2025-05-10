@foreach($prendas as $prenda)
<div class="modal fade" id="modalPrendaDestino{{ $prenda->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-indigo">
                <h5 class="modal-title text-white">
                    <i class="fas fa-project-diagram mr-2"></i> Destino de Prenda: {{ $prenda->recepcion->prenda_nombre }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.inventario_prenda.asignar-destino', $prenda->id) }}" id="formDestino{{ $prenda->id }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i> 
                        <strong>Inventario Total:</strong> {{ $prenda->cantidad_total }} unidades
                        @if($prenda->almacen || $prenda->catalogo)
                            <div class="mt-2">
                                @if($prenda->almacen)
                                    <span class="badge bg-primary mr-2">
                                        <i class="fas fa-warehouse"></i> Almacén: {{ $prenda->almacen->cantidad }}
                                    </span>
                                @endif
                                @if($prenda->catalogo)
                                    <span class="badge bg-success">
                                        <i class="fas fa-store"></i> Catálogo: {{ $prenda->catalogo->cantidad }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <div class="row">
                        <!-- Almacén -->
                        <div class="col-md-6">
                            <div class="card card-outline card-primary h-100">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-warehouse mr-2"></i> Almacén
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Cantidad a almacén</label>
                                        <input type="number" 
                                               name="cantidad_almacen" 
                                               class="form-control" 
                                               min="0" 
                                               max="{{ $prenda->cantidad_total }}"
                                               value="{{ $prenda->almacen ? $prenda->almacen->cantidad : 0 }}"
                                               oninput="validarAsignacion(this, {{ $prenda->id }}, 'almacen')"
                                               onchange="actualizarTotal({{ $prenda->id }})">
                                        <small class="text-muted">Máximo disponible: {{ $prenda->cantidad_total }}</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Ubicación (opcional)</label>
                                        <input type="text" 
                                               name="ubicacion" 
                                               class="form-control" 
                                               placeholder="Ej: Estante A-2"
                                               value="{{ $prenda->almacen ? $prenda->almacen->ubicacion : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Catálogo -->
                        <div class="col-md-6">
                            <div class="card card-outline card-success h-100">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-store mr-2"></i> Catálogo
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Cantidad a catálogo</label>
                                        <input type="number" 
                                               name="cantidad_catalogo" 
                                               class="form-control" 
                                               min="0" 
                                               max="{{ $prenda->cantidad_total }}"
                                               value="{{ $prenda->catalogo ? $prenda->catalogo->cantidad : 0 }}"
                                               oninput="validarAsignacion(this, {{ $prenda->id }}, 'catalogo')"
                                               onchange="actualizarTotal({{ $prenda->id }})">
                                        <small class="text-muted">Máximo disponible: {{ $prenda->cantidad_total }}</small>
                                    </div>
                                    {{-- <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" 
                                                   class="custom-control-input" 
                                                   id="publicadoSwitch{{ $prenda->id }}" 
                                                   name="publicado"
                                                   {{ $prenda->catalogo && $prenda->catalogo->publicado ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="publicadoSwitch{{ $prenda->id }}">Publicar en tienda</label>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Resumen -->
                    <div class="alert alert-warning mt-3" id="resumenDestino{{ $prenda->id }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calculator mr-2"></i>
                                <span id="textoResumen{{ $prenda->id }}">
                                    @php
                                        $totalAsignado = ($prenda->almacen ? $prenda->almacen->cantidad : 0) + ($prenda->catalogo ? $prenda->catalogo->cantidad : 0);
                                        $restante = $prenda->cantidad_total - $totalAsignado;
                                    @endphp
                                    Asignadas: <strong>{{ $totalAsignado }}</strong> | 
                                    Restantes: <strong>{{ $restante }}</strong>
                                </span>
                            </div>
                            <div id="errorContainer{{ $prenda->id }}" class="text-danger font-weight-bold" style="display: none;">
                                <i class="fas fa-exclamation-triangle"></i> 
                                <span id="errorText{{ $prenda->id }}"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn{{ $prenda->id }}">
                        <i class="fas fa-save mr-1"></i> Guardar Destino
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    // Validación en tiempo real por campo
    function validarAsignacion(input, prendaId, tipo) {
        const max = parseInt('{{ $prenda->cantidad_total }}');
        let value = parseInt(input.value) || 0;
        
        if (value > max) {
            mostrarError(prendaId, `No puedes asignar más de ${max} unidades a ${tipo}`);
            input.value = max;
            value = max;
        } else if (value < 0) {
            input.value = 0;
            value = 0;
        } else {
            ocultarError(prendaId);
        }
        
        actualizarTotal(prendaId);
        return value;
    }

    // Actualizar el resumen total
    function actualizarTotal(prendaId) {
        const cantidadAlmacen = parseInt($(`#modalPrendaDestino${prendaId} input[name="cantidad_almacen"]`).val()) || 0;
        const cantidadCatalogo = parseInt($(`#modalPrendaDestino${prendaId} input[name="cantidad_catalogo"]`).val()) || 0;
        const totalDisponible = parseInt('{{ $prenda->cantidad_total }}');
        
        const totalAsignado = cantidadAlmacen + cantidadCatalogo;
        const restante = totalDisponible - totalAsignado;
        
        // Actualizar el resumen
        $(`#textoResumen${prendaId}`).html(
            `Asignadas: <strong>${totalAsignado}</strong> | Restantes: <strong>${restante}</strong>`
        );
        
        // Cambiar color según el estado
        const resumen = $(`#resumenDestino${prendaId}`);
        resumen.removeClass('alert-success alert-warning alert-danger');
        
        if (restante < 0) {
            resumen.addClass('alert-danger');
            mostrarError(prendaId, `La suma supera el inventario disponible en ${Math.abs(restante)} unidades`);
            $(`#submitBtn${prendaId}`).prop('disabled', true);
        } else if (restante > 0) {
            resumen.addClass('alert-warning');
            ocultarError(prendaId);
            $(`#submitBtn${prendaId}`).prop('disabled', false);
        } else {
            resumen.addClass('alert-success');
            ocultarError(prendaId);
            $(`#submitBtn${prendaId}`).prop('disabled', false);
        }
        
        // Validar si no hay nada asignado
        if (totalAsignado === 0) {
            mostrarError(prendaId, 'Debes asignar al menos una unidad');
            $(`#submitBtn${prendaId}`).prop('disabled', true);
        }
    }

    // Mostrar mensaje de error
    function mostrarError(prendaId, mensaje) {
        $(`#errorContainer${prendaId}`).show();
        $(`#errorText${prendaId}`).text(mensaje);
    }

    // Ocultar mensaje de error
    function ocultarError(prendaId) {
        $(`#errorContainer${prendaId}`).hide();
    }

    // Validación al enviar el formulario
    $(document).ready(function() {
        @foreach($prendas as $prenda)
        $(`#formDestino{{ $prenda->id }}`).submit(function(e) {
            const totalDisponible = parseInt('{{ $prenda->cantidad_total }}');
            const cantidadAlmacen = parseInt($(this).find('input[name="cantidad_almacen"]').val()) || 0;
            const cantidadCatalogo = parseInt($(this).find('input[name="cantidad_catalogo"]').val()) || 0;
            const totalAsignado = cantidadAlmacen + cantidadCatalogo;
            
            if (totalAsignado > totalDisponible) {
                e.preventDefault();
                toastr.error(`Error: La suma total (${totalAsignado}) supera el inventario disponible (${totalDisponible})`);
                return false;
            }
            
            if (totalAsignado === 0) {
                e.preventDefault();
                toastr.error('Debes asignar al menos una unidad a almacén o catálogo');
                return false;
            }
            
            return true;
        });
        @endforeach
    });
</script>
@endpush

@push('styles')
<style>
    .bg-gradient-indigo {
        background: linear-gradient(135deg, #6610f2 0%, #3d0b91 100%);
    }
    .card-outline {
        border-top: 3px solid;
    }
    .card-outline.card-primary {
        border-top-color: #007bff;
    }
    .card-outline.card-success {
        border-top-color: #28a745;
    }
    .custom-switch .custom-control-label::before {
        height: 1.25rem;
        width: 2.5rem;
    }
    .custom-switch .custom-control-label::after {
        height: calc(1.25rem - 4px);
        width: calc(1.25rem - 4px);
    }
    #errorContainer {
        transition: all 0.3s ease;
    }
</style>
@endpush