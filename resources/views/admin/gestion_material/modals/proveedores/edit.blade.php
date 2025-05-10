<div class="modal fade" id="modalEditarProveedor{{ $proveedor->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarProveedorLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.gestion_material.modals.proveedores.update', $proveedor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="modalEditarProveedorLabel">Editar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nombre">Nombre *</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" value="{{ $proveedor->nombre }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_ci">Cédula de Identidad</label>
                        <input type="text" class="form-control" id="edit_ci" name="ci" value="{{ $proveedor->ci }}">
                    </div>
                    <div class="form-group">
                        <label for="edit_contacto">Contacto *</label>
                        <input type="text" class="form-control" id="edit_contacto" name="contacto" value="{{ $proveedor->contacto }}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_imagen">Imagen (Opcional)</label>
                        <input type="file" class="form-control-file" id="edit_imagen" name="imagen" data-preview="previewEditImagenProveedor">
                        @if($proveedor->imagen)
                            <img id="previewEditImagenProveedor" src="{{ asset('storage/' . $proveedor->imagen) }}" alt="Imagen actual" style="max-width: 100px; margin-top: 10px;">
                        @else
                            <img id="previewEditImagenProveedor" src="#" alt="Previsualización" style="max-width: 100px; display: none; margin-top: 10px;">
                        @endif
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" class="form-check-input" id="edit_activo" name="activo" value="1" {{ $proveedor->activo ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_activo">Proveedor activo</label>
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