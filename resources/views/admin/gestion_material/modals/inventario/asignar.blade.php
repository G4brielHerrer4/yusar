<!-- resources/views/admin/gestion_material/modals/inventario/asignar.blade.php -->
<div class="modal fade" id="modalAsignarConfeccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('inventario.asignar') }}" method="POST" id="formAsignacion">
                @csrf
                <div class="modal-header bg-gradient-warning text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-tshirt mr-2"></i>Asignación de Material
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Material -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Material</label>
                                <select name="inventario_material_id" id="selectMaterial" class="form-control select2" style="width: 100%" required>
                                    <option value="">Seleccione un material</option>
                                    @foreach($inventario as $item)
                                        <option 
                                            value="{{ $item->id }}" 
                                            data-stock="{{ $item->stock_actual }}"
                                            data-unidad="{{ $item->material->unidad_medida }}"
                                            data-material="{{ $item->material->nombre }}"
                                            data-almacen="{{ $item->almacen->nombre }}">
                                            {{ $item->material->nombre }} ({{ $item->stock_actual }} {{ $item->material->unidad_medida }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Almacén:</small>
                                    <small id="infoAlmacen" class="font-weight-bold">-</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Disponible:</small>
                                    <small id="infoStock" class="font-weight-bold text-success">0.00</small>
                                </div>
                            </div>
                        </div>

                        <!-- Confeccionista -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Confeccionista</label>
                                <select name="user_id" class="form-control select2" style="width: 100%" required>
                                    <option value="">Seleccione un confeccionista</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->nombre }} {{ $user->apellido }} ({{ $user->ci }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Cantidad -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Cantidad</label>
                                <div class="input-group">
                                    <input type="number" name="cantidad" id="cantidadAsignar" 
                                           class="form-control" step="0.01" min="0.01" 
                                           placeholder="Ej: 10.50" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white font-weight-bold" id="unidadMedida">-</span>
                                    </div>
                                </div>
                                <small class="text-muted">Máximo: <span id="maxDisponible">0.00</span></small>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="font-weight-bold text-muted">Estado</label>
                                <select name="estado" class="form-control">
                                    <option value="pendiente">Pendiente</option>
                                    <option value="en_proceso">En Proceso</option>
                                    <option value="terminado">Terminado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-check-circle mr-2"></i>Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function() {
    // Inicializar select2
    $('.select2').select2({
        dropdownParent: $('#modalAsignarConfeccion'),
        placeholder: 'Seleccione una opción'
    });

    // Cuando se selecciona un material
    $('#selectMaterial').change(function() {
        const selectedOption = $(this).find('option:selected');
        const stock = parseFloat(selectedOption.data('stock')) || 0;
        const unidad = selectedOption.data('unidad') || '';
        
        // Actualizar información
        $('#unidadMedida').text(unidad);
        $('#infoStock').text(stock.toFixed(2) + ' ' + unidad);
        $('#infoAlmacen').text(selectedOption.data('almacen') || '-');
        $('#maxDisponible').text(stock.toFixed(2) + ' ' + unidad);
    });

    // Validar cantidad no exceda stock
    $('#formAsignacion').submit(function(e) {
        const cantidad = parseFloat($('#cantidadAsignar').val()) || 0;
        const stock = parseFloat($('#selectMaterial').find('option:selected').data('stock')) || 0;
        
        if (cantidad > stock) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La cantidad no puede ser mayor al stock disponible',
                confirmButtonText: 'Entendido'
            });
        }
    });
});
</script>
@endpush

@push('css')
<style>
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #e4a836 100%);
    }
    .select2-container .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        border: 1px solid #ddd;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    .modal-content {
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .form-control, .select2-container .select2-selection--single {
        border-radius: 0.375rem;
    }
    .input-group-text {
        border-left: 0;
    }
    #cantidadAsignar {
        border-right: 0;
    }
</style>
@endpush