<div class="modal fade" id="modalAsignacionCreate" tabindex="-1" role="dialog" aria-labelledby="modalAsignacionCreateLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-purple">
                <h5 class="modal-title text-white" id="modalAsignacionCreateLabel">
                    <i class="fas fa-paper-plane mr-2"></i>Asignar Material
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.gestion_material.asignaciones.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inventario_material_id">Material</label>
                                <select class="form-control" id="inventario_material_id" name="inventario_material_id" required>
                                    @foreach($inventario as $item)
                                        @if($item->stock_actual > 0 && $item->material)
                                            <option value="{{ $item->id }}" 
                                                    data-stock="{{ $item->stock_actual }}" 
                                                    data-unidad="{{ $item->material->unidad_medida ?? 'N/A' }}">
                                                {{ $item->material->nombre }} (Stock: {{ $item->stock_actual }} {{ $item->material->unidad_medida ?? 'N/A' }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id">Confeccionista</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad a Asignar</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" id="cantidad" name="cantidad" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="unidad-medida"></span>
                            </div>
                        </div>
                        <small class="form-text text-muted" id="stock-disponible"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Asignar Material</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar unidad de medida y stock disponible cuando cambia el material
    $('#inventario_material_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const stock = selectedOption.data('stock');
        const unidad = selectedOption.data('unidad');
        
        $('#unidad-medida').text(unidad);
        $('#stock-disponible').text(`Stock disponible: ${stock} ${unidad}`);
        $('#cantidad').attr('max', stock);
    });

    // Inicializar valores al cargar la página
    $('#inventario_material_id').trigger('change');
    
    // Validar que no se asigne más del stock disponible
    $('#modalAsignacionCreate form').submit(function(e) {
        const cantidad = parseFloat($('#cantidad').val());
        const stock = parseFloat($('#inventario_material_id option:selected').data('stock'));
        
        if (cantidad > stock) {
            e.preventDefault();
            alert('No puede asignar más cantidad del stock disponible');
        }
    });
});
</script>