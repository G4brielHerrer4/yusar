<div class="modal fade" id="modalEdit{{ $asignacion->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.asignacion_material.update', $asignacion->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Editar Asignación #{{ $asignacion->id }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Responsable *</label>
                                <select name="responsable_id" class="form-control" required>
                                    @foreach($responsables as $user)
                                        <option value="{{ $user->id }}" {{ $asignacion->responsable_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->nombre }} {{ $user->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confeccionista *</label>
                                <select name="confeccionista_id" class="form-control" required>
                                    @foreach($confeccionistas as $conf)
                                        <option value="{{ $conf->id }}" 
                                            {{ $asignacion->confeccionista_id == $conf->id ? 'selected' : '' }}
                                            {{ $conf->estado ? '' : 'disabled' }}>
                                            {{ $conf->nombre }} {{ $conf->apellido }}
                                            {{ $conf->estado ? '' : ' (INACTIVO)' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(!$asignacion->confeccionista->estado)
                                    <div class="alert alert-warning mt-2 p-2">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> 
                                        Este confeccionista está actualmente INACTIVO
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header bg-secondary text-white">
                            Materiales Asignados (No editables)
                        </div>
                        <div class="card-body">
                            @foreach($asignacion->materiales_asignados as $material)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" 
                                           value="{{ $material['nombre'] }} ({{ $material['cantidad'] }})" readonly>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Stock actual: {{ $material['stock_actual'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Prendas Esperadas *</label>
                                <input type="number" name="prendas_esperadas" class="form-control" 
                                       value="{{ $asignacion->prendas_esperadas }}" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Entrega *</label>
                                <input type="date" name="fecha_entrega_estimada" class="form-control" 
                                       value="{{ $asignacion->fecha_entrega_estimada->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Estado *</label>
                                <select name="estado" class="form-control" required>
                                    @foreach(App\Models\AsignacionMaterial::ESTADOS as $key => $value)
                                        <option value="{{ $key }}" {{ $asignacion->estado == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="2">{{ $asignacion->observaciones }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación para evitar cambiar a confeccionistas inactivos
    const editConfeccionistaSelect = document.querySelector('#modalEdit{{ $asignacion->id }} select[name="confeccionista_id"]');
    
    if (editConfeccionistaSelect) {
        editConfeccionistaSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.disabled) {
                this.value = '{{ $asignacion->confeccionista_id }}'; // Restaurar valor original
                toastr.error('No puede asignar a un confeccionista inactivo', 'Error', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000,
                    positionClass: 'toast-top-center'
                });
            }
        });
    }
});
</script>