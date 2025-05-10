<div class="modal fade" id="modalCrearProveedor" tabindex="-1" role="dialog" aria-labelledby="modalCrearProveedorLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.gestion_material.modals.proveedores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="modalCrearProveedorLabel">Nuevo Proveedor</h5>
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
                        <label for="ci">Cédula de Identidad</label>
                        <input type="text" class="form-control" id="ci" name="ci">
                    </div>
                    <div class="form-group">
                        <label for="contacto">Contacto *</label>
                        <input type="text" class="form-control" id="contacto" name="contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen (Opcional)</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" data-preview="previewImagenProveedor">
                        <img id="previewImagenProveedor" src="#" alt="Previsualización" style="max-width: 100px; display: none; margin-top: 10px;">
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="activo" value="0"> <!-- Campo oculto para valor por defecto -->
                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" checked>
                        <label class="form-check-label" for="activo">Proveedor activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>