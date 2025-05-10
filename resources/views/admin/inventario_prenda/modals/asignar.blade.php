<div class="modal fade" id="modalAsignarPrenda{{ $prenda->id }}" tabindex="-1" role="dialog" aria-labelledby="modalAsignarPrendaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalAsignarPrendaLabel">
                    Asignar Categoría/Colección a: {{ $prenda->recepcion->prenda_nombre }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="asignarTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="categoria-tab" data-toggle="tab" href="#categoria{{ $prenda->id }}" role="tab">
                            <i class="fas fa-tag"></i> Asignar Categoría
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="coleccion-tab" data-toggle="tab" href="#coleccion{{ $prenda->id }}" role="tab">
                            <i class="fas fa-layer-group"></i> Asignar Colección
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="precio-tab" data-toggle="tab" href="#precio{{ $prenda->id }}" role="tab">
                            <i class="fas fa-tag"></i> Actualizar Precio
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content p-3 border border-top-0" id="asignarTabContent">
                    <!-- Pestaña Categoría -->
                    <div class="tab-pane fade show active" id="categoria{{ $prenda->id }}" role="tabpanel">
                        <form action="{{ route('admin.inventario.asignar-categoria', $prenda->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="categoria_id">Seleccionar Categoría</label>
                                <select class="form-control select2" name="categoria_id" required>
                                    <option value="">-- Seleccione una categoría --</option>
                                    @foreach($categorias->where('estado', true) as $categoria)
                                        <option value="{{ $categoria->id }}" 
                                            {{ $prenda->categoria_id == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Categoría
                            </button>
                        </form>
                    </div>
                    
                    <!-- Pestaña Colección -->
                    <div class="tab-pane fade" id="coleccion{{ $prenda->id }}" role="tabpanel">
                        <form action="{{ route('admin.inventario.asignar-coleccion', $prenda->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="coleccion_id">Seleccionar Colección</label>
                                <select class="form-control select2" name="coleccion_id" required>
                                    <option value="">-- Seleccione una colección --</option>
                                    @foreach($colecciones->where('estado', true) as $coleccion)
                                        <option value="{{ $coleccion->id }}" 
                                            {{ $prenda->coleccion_id == $coleccion->id ? 'selected' : '' }}>
                                            {{ $coleccion->nombre }} 
                                            ({{ $coleccion->fecha_inicio->format('d/m/Y') }} - {{ $coleccion->fecha_fin->format('d/m/Y') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-save"></i> Guardar Colección
                            </button>
                        </form>
                    </div>
                    
                    <!-- Pestaña Precio -->
                    <div class="tab-pane fade" id="precio{{ $prenda->id }}" role="tabpanel">
                        <form action="{{ route('admin.inventario.update-precio', $prenda->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="precio_venta">Precio de Venta (Bs.)</label>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control" name="precio_venta" 
                                       value="{{ $prenda->precio_venta }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Actualizar Precio
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>