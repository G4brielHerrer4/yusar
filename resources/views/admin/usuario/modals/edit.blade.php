<div class="modal fade" id="editUsuarioModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="editUsuarioModalLabel{{ $usuario->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="editUsuarioModalLabel{{ $usuario->id }}">Editar Usuario: {{ $usuario->nombre }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" name="apellido" id="apellido" class="form-control" value="{{ $usuario->apellido }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ci">Cédula de Identidad:</label>
                                <input type="text" name="ci" id="ci" class="form-control" value="{{ $usuario->ci }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="genero">Género:</label>
                                <select name="genero" id="genero" class="form-control" required>
                                    <option value="Masculino" {{ $usuario->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ $usuario->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Otro" {{ $usuario->genero == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celular">Celular:</label>
                                <input type="text" name="celular" id="celular" class="form-control" value="{{ $usuario->celular }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="correo_electronico">Correo Electrónico:</label>
                                <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" value="{{ $usuario->correo_electronico }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clave">Nueva Contraseña:</label>
                                <input type="password" name="clave" id="clave" class="form-control">
                                <small class="text-muted">Dejar en blanco para mantener la actual</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="clave_confirmation">Confirmar Contraseña:</label>
                                <input type="password" name="clave_confirmation" id="clave_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rol_id">Rol:</label>
                                <select name="rol_id" id="rol_id" class="form-control">
                                    <option value="">Seleccione un rol</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}" {{ $usuario->rol_id == $rol->id ? 'selected' : '' }}>{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto:</label>
                                <input type="file" name="foto" id="foto" class="form-control-file">
                                @if($usuario->foto)
                                    <div class="mt-2">
                                        <img src="{{ asset($usuario->foto) }}" width="100" class="img-thumbnail">
                                        <p class="text-muted">Foto actual</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>