<!-- resources/views/admin/inventario_material/modals/configuracion_cep/create.blade.php -->
<div class="modal fade" id="modalConfigCEP{{ $item->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-calculator mr-2"></i>
                    Configurar CEP para {{ $item->material->nombre }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.inventario_material.modals.configuracion_cep.store', $item->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Demanda Anual ({{ $item->material->unidad_medida }})</label>
                                <input type="number" name="demanda_anual" class="form-control" required step="0.01" min="1">
                                <small class="text-muted">Consumo anual estimado</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Costo por Pedido ($)</label>
                                <input type="number" name="costo_orden" class="form-control" required step="0.01" min="0.01">
                                <small class="text-muted">Costo logístico por orden</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Costo Mantenimiento ($/{{ $item->material->unidad_medida }}/año)</label>
                                <input type="number" name="costo_mantenimiento" class="form-control" required step="0.01" min="0.01">
                                <small class="text-muted">Costo de almacenamiento anual</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tiempo de Entrega (días)</label>
                                <input type="number" name="tiempo_entrega" class="form-control" required min="1">
                                <small class="text-muted">Días para recibir el pedido</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>