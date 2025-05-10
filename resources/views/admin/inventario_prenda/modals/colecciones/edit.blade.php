<div class="modal fade" id="modalColeccionEdit{{ $coleccion->id }}" tabindex="-1" role="dialog" aria-labelledby="modalColeccionEdit{{ $coleccion->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalColeccionEdit{{ $coleccion->id }}Label">
                    <i class="fas fa-edit mr-2"></i>Editar Colección
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.inventario_prenda.colecciones.update', $coleccion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_edit{{ $coleccion->id }}">Nombre *</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre_edit{{ $coleccion->id }}" name="nombre" 
                                       value="{{ old('nombre', $coleccion->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fecha_inicio_edit{{ $coleccion->id }}">Fecha Inicio *</label>
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                       id="fecha_inicio_edit{{ $coleccion->id }}" name="fecha_inicio" 
                                       value="{{ old('fecha_inicio', $coleccion->fecha_inicio->format('Y-m-d')) }}" required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_fin_edit{{ $coleccion->id }}">Fecha Fin *</label>
                                <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" 
                                       id="fecha_fin_edit{{ $coleccion->id }}" name="fecha_fin" 
                                       value="{{ old('fecha_fin', $coleccion->fecha_fin->format('Y-m-d')) }}" required>
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Estado *</label>
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="estado" value="0">
                                    <input type="checkbox" class="custom-control-input" 
                                           id="estado_edit{{ $coleccion->id }}" name="estado" 
                                           value="1" {{ old('estado', $coleccion->estado) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="estado_edit{{ $coleccion->id }}">Activo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Imagen Actual</label>
                        <div class="text-center mb-2">
                            <img src="{{ asset('storage/'.$coleccion->imagen) }}" 
                                 alt="{{ $coleccion->nombre }}" 
                                 class="img-fluid rounded" style="max-height: 150px;">
                        </div>
                        <label for="imagen_edit{{ $coleccion->id }}">Cambiar Imagen</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('imagen') is-invalid @enderror" 
                                   id="imagen_edit{{ $coleccion->id }}" name="imagen" accept="image/*">
                            <label class="custom-file-label" for="imagen_edit{{ $coleccion->id }}">Seleccionar archivo</label>
                            @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Dejar en blanco para mantener la actual</small>
                        <div class="mt-2 text-center">
                            <img id="imagen_edit{{ $coleccion->id }}Preview" src="#" alt="Vista previa" 
                                 class="img-fluid rounded" style="max-height: 150px; display: none;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion_edit{{ $coleccion->id }}">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion_edit{{ $coleccion->id }}" name="descripcion" 
                                  rows="2">{{ old('descripcion', $coleccion->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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