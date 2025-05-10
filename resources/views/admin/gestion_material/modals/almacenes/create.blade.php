<div class="modal fade" id="modalCrearAlmacen" tabindex="-1" role="dialog" aria-labelledby="modalCrearAlmacenLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.gestion_material.modals.almacenes.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="modalCrearAlmacenLabel">Nuevo Almacén</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación *</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" checked>
                        <label class="form-check-label" for="activo">Almacén activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>