<div class="modal fade" id="modalRecibirCompra{{ $compra->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('compras.recibir', $compra->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Recibir Compra #{{ $compra->id }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Almacén de destino</label>
                                <select name="almacen_id" class="form-control" required>
                                    @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confeccionista (Opcional)</label>
                                <select name="user_id" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nombre }} {{ $user->apellido }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h6>Materiales recibidos:</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th width="120">Cantidad Comprada</th>
                                <th width="120">Cantidad Recibida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compra->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->material->nombre }}</td>
                                <td>{{ $detalle->cantidad }} {{ $detalle->material->unidad_medida }}</td>
                                <td>
                                    <input type="hidden" name="materiales[{{ $detalle->id }}][id]" value="{{ $detalle->id }}">
                                    <input type="number" name="materiales[{{ $detalle->id }}][cantidad_recibida]" 
                                           class="form-control form-control-sm" 
                                           value="{{ $detalle->cantidad }}" 
                                           min="0.01" step="0.01" required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Recepción</button>
                </div>
            </form>
        </div>
    </div>
</div>