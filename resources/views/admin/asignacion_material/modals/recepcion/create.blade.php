<div class="modal fade" id="modalRecepcionCreate{{ $asignacion->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.recepcion_prendas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="asignacion_id" value="{{ $asignacion->id }}">
                
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">Nueva Recepción para Asignación #{{ $asignacion->id }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confeccionista</label>
                                <input type="text" class="form-control" value="{{ $asignacion->nombre_confeccionista }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prendas Esperadas</label>
                                <input type="text" class="form-control" value="{{ $asignacion->prendas_esperadas }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Prenda *</label>
                                <select name="tipo_prenda" class="form-control" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Gabardina">Gabardina</option>
                                    <option value="Abrigo">Abrigo</option>
                                    <option value="Blusa">Blusa</option>
                                    <option value="Quimono">Quimono</option>
                                    <option value="Saco">Saco</option>
                                    <option value="Camisa">Camisa</option>
                                    <option value="Chaqueta">Chaqueta</option>
                                    <option value="Chompa">Chompa</option>
                                    <option value="Bufanda">Bufanda</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nombre de la Prenda *</label>
                                <input type="text" name="prenda_nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Código (Opcional)</label>
                                <input type="text" name="codigo" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Talla *</label>
                                <select name="talla" class="form-control" required>
                                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $talla)
                                        <option value="{{ $talla }}">{{ $talla }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Color *</label>
                                <input type="text" name="color" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cantidad *</label>
                                <input type="number" name="cantidad" class="form-control cantidad" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Costo Unitario de la Confeccion (Bs/) *</label>
                                <input type="number" step="0.01" name="costo_confeccion_unitario" 
                                       class="form-control costo-unitario" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total (Bs)</label>
                                <input type="text" class="form-control total" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recibido por *</label>
                                <select name="recibido_por" class="form-control" required>
                                    @foreach($responsables as $user)
                                        <option value="{{ $user->id }}">{{ $user->nombre }} {{ $user->apellido }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha Recepción *</label>
                                <input type="date" name="fecha_recepcion" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Estado *</label>
                        <select name="estado" class="form-control" required>
                            <option value="en_revision">En Revisión</option>
                            <option value="aprobado">Aprobado</option>
                            <option value="devuelto">Devuelto</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observacion" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Recepción</button>
                </div>
            </form>
        </div>
    </div>
</div>