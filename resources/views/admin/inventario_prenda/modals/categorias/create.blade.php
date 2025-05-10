<div class="modal fade" id="modalCategoriaCreate" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalCategoriaCreateLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Nueva Categoría
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.inventario_prenda.categorias.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" name="descripcion" rows="2">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="imagen">Imagen *</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" 
                                           id="imagen" name="imagen" accept="image/*" required>
                                    <label class="custom-file-label" for="imagen">Seleccionar archivo</label>
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Formatos: jpeg, png, jpg | Máx: 2MB</small>
                                <div class="mt-2 text-center">
                                    <img id="imagenPreview" src="#" alt="Vista previa" 
                                         class="img-fluid rounded" style="max-height: 150px; display: none;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Estado *</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="estado" name="estado" value="1" checked>
                                    <label class="custom-control-label" for="estado">Activo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Vista previa de la imagen
    document.getElementById('imagen').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagenPreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
            document.querySelector('.custom-file-label').textContent = file.name;
        }
    });
</script>
@endpush