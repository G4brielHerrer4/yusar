<div class="modal fade" id="modalInventarioCreate" tabindex="-1" role="dialog" aria-labelledby="modalInventarioCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalInventarioCreateLabel">
                    <i class="fas fa-boxes mr-2"></i> Nuevo Registro de Inventario
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.gestion_material.inventario.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_id">Material *</label>
                                <select class="form-control" id="material_id" name="material_id" required>
                                    <option value="">Seleccionar material</option>
                                    @foreach($materiales as $material)
                                        <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="almacen_id">Almacén *</label>
                                <select class="form-control" id="almacen_id" name="almacen_id" required>
                                    <option value="">Seleccionar almacén</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock_actual">Cantidad *</label>
                        <input type="number" class="form-control" id="stock_actual" name="stock_actual" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Registrar Inventario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>