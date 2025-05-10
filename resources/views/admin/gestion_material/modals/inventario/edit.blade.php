<div class="modal fade" id="modalInventarioEdit" tabindex="-1" role="dialog" aria-labelledby="modalInventarioEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalInventarioEditLabel">
                    <i class="fas fa-edit mr-2"></i> Ajustar Inventario
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editInventarioForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Material</label>
                                <input type="text" class="form-control" id="edit_material_nombre" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Almacén</label>
                                <input type="text" class="form-control" id="edit_almacen_nombre" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_stock_actual">Nueva Cantidad *</label>
                        <input type="number" class="form-control" id="edit_stock_actual" name="stock_actual" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Actualizar Inventario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#modalInventarioEdit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        var inventarioId = button.data('id');
        var materialNombre = button.data('material');
        var almacenNombre = button.data('almacen');
        var stockActual = button.data('stock');
        
        // Setear valores en el formulario
        modal.find('#edit_material_nombre').val(materialNombre);
        modal.find('#edit_almacen_nombre').val(almacenNombre);
        modal.find('#edit_stock_actual').val(stockActual);
        
        // Actualizar acción del formulario
        modal.find('form').attr('action', '/admin/inventario/' + inventarioId);
    });
});
</script>