<div class="modal fade" id="modalCategoriaEdit{{ $categoria->id }}" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaEdit{{ $categoria->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalCategoriaEdit{{ $categoria->id }}Label">
                    <i class="fas fa-edit mr-2"></i>Editar Categoría
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.inventario_prenda.categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_edit{{ $categoria->id }}">Nombre *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre_edit{{ $categoria->id }}" name="nombre" 
                                       value="{{ old('nombre', $categoria->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado *</label>
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="estado" value="0">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="estado_edit{{ $categoria->id }}" name="estado" 
                                           value="1" {{ old('estado', $categoria->estado) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="estado_edit{{ $categoria->id }}">Activo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion_edit{{ $categoria->id }}">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion_edit{{ $categoria->id }}" name="descripcion" 
                                  rows="2">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Imagen Actual</label>
                        <div class="text-center mb-2">
                            <img src="{{ asset('storage/'.$categoria->imagen) }}" 
                                 alt="{{ $categoria->nombre }}" 
                                 class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                        <label for="imagen_edit{{ $categoria->id }}">Cambiar Imagen</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" 
                                   id="imagen_edit{{ $categoria->id }}" name="imagen" accept="image/*">
                            <label class="custom-file-label" for="imagen_edit{{ $categoria->id }}">Seleccionar archivo</label>
                            @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Dejar en blanco para mantener la actual</small>
                        <div class="mt-2 text-center">
                            <img id="imagen_edit{{ $categoria->id }}Preview" src="#" alt="Vista previa" 
                                 class="img-fluid rounded" style="max-height: 150px; display: none;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>