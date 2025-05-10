<div class="modal fade" id="modalInventarioDetalle" tabindex="-1" role="dialog" aria-labelledby="modalInventarioDetalleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="modalInventarioDetalleLabel">
                    <i class="fas fa-info-circle mr-2"></i> Detalle de Inventario
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Información del Material</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Nombre:</span>
                                <span id="detalle_material_nombre" class="font-weight-bold"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Unidad de Medida:</span>
                                <span id="detalle_material_unidad" class="font-weight-bold"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Información de Almacenamiento</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Almacén:</span>
                                <span id="detalle_almacen_nombre" class="font-weight-bold"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Ubicación:</span>
                                <span id="detalle_almacen_ubicacion" class="font-weight-bold"></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Stock Actual:</span>
                                <span id="detalle_stock_actual" class="badge badge-primary badge-pill"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-3" id="cepSection">
                    <h6 class="font-weight-bold">Configuración CEP</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Demanda Anual</th>
                                    <th>Costo Pedido</th>
                                    <th>Tasa Mantenimiento</th>
                                    <th>Cantidad Económica</th>
                                    <th>Punto Reorden</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="cep_demanda"></td>
                                    <td id="cep_costo_pedido"></td>
                                    <td id="cep_tasa"></td>
                                    <td id="cep_cantidad"></td>
                                    <td id="cep_reorden"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#modalInventarioDetalle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        
        // Setear valores de material
        modal.find('#detalle_material_nombre').text(button.data('material-nombre'));
        modal.find('#detalle_material_unidad').text(button.data('material-unidad'));
        
        // Setear valores de almacén
        modal.find('#detalle_almacen_nombre').text(button.data('almacen-nombre'));
        modal.find('#detalle_almacen_ubicacion').text(button.data('almacen-ubicacion'));
        modal.find('#detalle_stock_actual').text(button.data('stock'));
        
        // Mostrar/ocultar sección CEP
        if(button.data('cep-demanda')) {
            modal.find('#cepSection').show();
            modal.find('#cep_demanda').text(button.data('cep-demanda'));
            modal.find('#cep_costo_pedido').text('$' + button.data('cep-costo'));
            modal.find('#cep_tasa').text((button.data('cep-tasa') * 100) + '%');
            modal.find('#cep_cantidad').text(button.data('cep-cantidad'));
            modal.find('#cep_reorden').text(button.data('cep-reorden'));
        } else {
            modal.find('#cepSection').hide();
        }
    });
});
</script>