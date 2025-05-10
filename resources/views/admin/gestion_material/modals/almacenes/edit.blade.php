<div class="modal fade" id="modalEditarAlmacen{{ $almacen->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarAlmacenLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.gestion_material.modals.almacenes.update', $almacen->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="modalEditarAlmacenLabel">Editar Almacén</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nombre">Nombre *</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" value="{{ $almacen->nombre }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_ubicacion">Ubicación *</label>
                        <input type="text" class="form-control" id="edit_ubicacion" name="ubicacion" value="{{ $almacen->ubicacion }}" required>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" class="form-check-input" id="edit_activo" name="activo" value="1" {{ $almacen->activo ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_activo">Almacén activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>