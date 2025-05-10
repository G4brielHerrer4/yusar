<div class="modal fade" id="modalConfeccionistaCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-indigo">
                <h5 class="modal-title text-white">
                    <i class="fas fa-user-plus mr-2"></i>Nuevo Confeccionista
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('confeccionistas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido:</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Celular:</label>
                        <input type="text" name="celular" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Celular Referencia:</label>
                        <input type="text" name="celular_referencia" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <textarea name="direccion" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="estado" class="custom-control-input" id="switchEstado" checked>
                            <label class="custom-control-label" for="switchEstado">Activo</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>