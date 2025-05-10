<!-- resources/views/admin/inventario_material/modals/configuracion_cep/edit.blade.php -->
<div class="modal fade" id="modalConfigCEP{{ $item->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit mr-2"></i>
                    Editar CEP para {{ $item->material->nombre }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('admin.inventario_material.modals.configuracion_cep.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-calculator mr-2"></i>Valores Calculados Automáticamente</h6>
                        <div class="row text-center">
                            <div class="col-md-4 border-right">
                                <div class="font-weight-bold text-primary">CEP</div>
                                <div class="h5">{{ number_format($item->configuracionCep->cantidad_economica, 2) }} {{ $item->material->unidad_medida }}</div>
                                <small class="text-muted">Cantidad Óptima</small>
                            </div>
                            <div class="col-md-4 border-right">
                                <div class="font-weight-bold text-warning">
                                    <i class="fas fa-exclamation-triangle"></i> P. Reorden
                                </div>
                                <div class="h5">{{ number_format($item->configuracionCep->punto_reorden, 2) }} {{ $item->material->unidad_medida }}</div>
                                <small class="text-muted">Stock Mínimo</small>
                            </div>
                            <div class="col-md-4">
                                <div class="font-weight-bold text-success">Frecuencia</div>
                                <div class="h5">{{ $item->configuracionCep->frecuencia_dias }} días</div>
                                <small class="text-muted">Entre Pedidos</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Demanda Anual ({{ $item->material->unidad_medida }})</label>
                                <input type="number" name="demanda_anual" class="form-control" 
                                       value="{{ old('demanda_anual', $item->configuracionCep->demanda_anual) }}" 
                                       required step="0.01" min="1">
                                <small class="form-text text-muted">Consumo anual estimado</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold">Costo por Pedido ($)</label>
                                <input type="number" name="costo_orden" class="form-control" 
                                       value="{{ old('costo_orden', $item->configuracionCep->costo_orden) }}" 
                                       required step="0.01" min="0.01">
                                <small class="form-text text-muted">Costo logístico por orden</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Costo Mantenimiento ($/{{ $item->material->unidad_medida }}/año)</label>
                                <input type="number" name="costo_mantenimiento" class="form-control" 
                                       value="{{ old('costo_mantenimiento', $item->configuracionCep->costo_mantenimiento) }}" 
                                       required step="0.01" min="0.01">
                                <small class="form-text text-muted">Costo de almacenamiento anual</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="font-weight-bold">Tiempo de Entrega (días)</label>
                                <input type="number" name="tiempo_entrega" class="form-control" 
                                       value="{{ old('tiempo_entrega', $item->configuracionCep->tiempo_entrega) }}" 
                                       required min="1">
                                <small class="form-text text-muted">Días para recibir el pedido</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-sync-alt mr-1"></i> Actualizar CEP
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>