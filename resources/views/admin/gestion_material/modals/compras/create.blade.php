<div class="modal fade" id="modalCrearCompra" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('compras.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-purple">
                    <h5 class="modal-title">Nueva Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Proveedor *</label>
                        <select name="proveedor_id" class="form-control" required>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Materiales *</label>
                        <div id="materiales-container">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <select name="materiales[0][material_id]" class="form-control" required>
                                        @foreach($materiales as $material)
                                            <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="materiales[0][cantidad]" class="form-control" placeholder="Cantidad" step="0.01" min="0.01" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="materiales[0][precio_unitario]" class="form-control" placeholder="Precio Unitario" step="0.01" min="0.01" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="agregar-material" class="btn btn-sm btn-info">
                            <i class="fas fa-plus"></i> Añadir Material
                        </button>
                    </div>
                    
                    <div class="form-group">
                        <label>Fecha Estimada de Entrega *</label>
                        <input type="date" name="fecha_entrega" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-purple">Guardar Compra</button>
                </div>
            </form>
        </div>
    </div>
</div>