<div class="modal fade" id="modalConfeccionistaEdit{{ $confeccionista->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-indigo">
                <h5 class="modal-title text-white">
                    <i class="fas fa-edit mr-2"></i>Editar Confeccionista
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('confeccionistas.update', $confeccionista->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $confeccionista->nombre }}" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido:</label>
                        <input type="text" name="apellido" class="form-control" value="{{ $confeccionista->apellido }}" required>
                    </div>
                    <div class="form-group">
                        <label>Celular:</label>
                        <input type="text" name="celular" class="form-control" value="{{ $confeccionista->celular }}" required>
                    </div>
                    <div class="form-group">
                        <label>Celular Referencia:</label>
                        <input type="text" name="celular_referencia" class="form-control" value="{{ $confeccionista->celular_referencia }}">
                    </div>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <textarea name="direccion" class="form-control" rows="2">{{ $confeccionista->direccion }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="estado" class="custom-control-input" id="switchEstadoEdit{{ $confeccionista->id }}" 
                                   {{ $confeccionista->estado ? 'checked' : '' }}>
                            <label class="custom-control-label" for="switchEstadoEdit{{ $confeccionista->id }}">
                                {{ $confeccionista->estado ? 'Activo' : 'Inactivo' }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>