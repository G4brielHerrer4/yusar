<div class="modal fade" id="modalPrendaEdit{{ $prenda->id }}" tabindex="-1" role="dialog" aria-labelledby="modalPrendaEditLabel{{ $prenda->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white">
                    <i class="fas fa-edit mr-2"></i>Editar Prenda: {{ $prenda->recepcion->prenda_nombre }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.inventario_prenda.update', $prenda->id) }}" enctype="multipart/form-data" id="formEditarPrenda{{ $prenda->id }}">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna Izquierda - Datos Principales -->
                        <div class="col-lg-6">
                            <div class="card card-body border-0 shadow-sm mb-4">
                                <h6 class="font-weight-bold text-primary mb-3">
                                    <i class="fas fa-info-circle mr-2"></i>Información Básica
                                </h6>
                                
                                <!-- Precio -->
                                <div class="form-group">
                                    <label class="font-weight-bold">Precio Oficial <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light">Bs.</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control" 
                                               name="precio_oficial" 
                                               value="{{ number_format($prenda->precio_venta, 2, '.', '') }}" 
                                               required min="0">
                                    </div>
                                    <small class="form-text text-muted">Precio de venta al público</small>
                                </div>
                                
                                <!-- Selector Elegante: Categoría o Colección -->
                                <div class="form-group">
                                    <label class="font-weight-bold">Clasificación <span class="text-danger">*</span></label>
                                    
                                    <div class="nav-tabs-boxed">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link {{ $prenda->categoria_id ? 'active' : '' }}" 
                                                   data-toggle="tab" 
                                                   href="#categoriaTab{{ $prenda->id }}" 
                                                   role="tab">
                                                    <i class="fas fa-tag mr-1"></i> Categoría
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ $prenda->coleccion_id ? 'active' : '' }}" 
                                                   data-toggle="tab" 
                                                   href="#coleccionTab{{ $prenda->id }}" 
                                                   role="tab">
                                                    <i class="fas fa-layer-group mr-1"></i> Colección
                                                </a>
                                            </li>
                                        </ul>
                                        
                                        <div class="tab-content pt-3">
                                            <!-- Pestaña Categoría -->
                                            <div class="tab-pane {{ $prenda->categoria_id ? 'active' : '' }}" 
                                                 id="categoriaTab{{ $prenda->id }}" 
                                                 role="tabpanel">
                                                <select name="categoria_id" class="form-control select2-categoria">
                                                    <option value="">Seleccione una categoría</option>
                                                    @foreach($categorias->where('estado', 1) as $categoria)
                                                        <option value="{{ $categoria->id }}" 
                                                            {{ $prenda->categoria_id == $categoria->id ? 'selected' : '' }}>
                                                            {{ $categoria->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="tipo_clasificacion" value="categoria">
                                            </div>
                                            
                                            <!-- Pestaña Colección -->
                                            <div class="tab-pane {{ $prenda->coleccion_id ? 'active' : '' }}" 
                                                 id="coleccionTab{{ $prenda->id }}" 
                                                 role="tabpanel">
                                                <select name="coleccion_id" class="form-control select2-coleccion">
                                                    <option value="">Seleccione una colección</option>
                                                    @foreach($colecciones->where('estado', 1) as $coleccion)
                                                        <option value="{{ $coleccion->id }}" 
                                                            {{ $prenda->coleccion_id == $coleccion->id ? 'selected' : '' }}>
                                                            {{ $coleccion->nombre }} ({{ $coleccion->fecha_inicio->format('d/m/Y') }} - {{ $coleccion->fecha_fin->format('d/m/Y') }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="tipo_clasificacion" value="coleccion">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Columna Derecha - Imágenes -->
                        <div class="col-lg-6">
                            <!-- Imagen Principal -->
                            <div class="card card-body border-0 shadow-sm mb-4">
                                <h6 class="font-weight-bold text-primary mb-3">
                                    <i class="fas fa-image mr-2"></i>Imagen Principal
                                </h6>
                                
                                <div class="text-center mb-3">
                                    <div class="image-preview-container">
                                        <img id="imagenPrincipalPreview{{ $prenda->id }}" 
                                             src="{{ $prenda->imagen_principal ? asset('storage/'.$prenda->imagen_principal) : asset('img/default-placeholder.png') }}" 
                                             class="img-fluid rounded shadow hover-zoom" 
                                             style="max-height: 200px; object-fit: contain; cursor: pointer;"
                                             onclick="openImageModal('{{ $prenda->imagen_principal ? asset('storage/'.$prenda->imagen_principal) : asset('img/default-placeholder.png') }}')">
                                    </div>
                                </div>
                                
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" 
                                           id="imagenPrincipal{{ $prenda->id }}" 
                                           name="imagen_principal"
                                           onchange="previewImage(this, 'imagenPrincipalPreview{{ $prenda->id }}')">
                                    <label class="custom-file-label" for="imagenPrincipal{{ $prenda->id }}">
                                        {{ $prenda->imagen_principal ? 'Cambiar imagen' : 'Seleccionar imagen' }}
                                    </label>
                                </div>
                                
                                @if($prenda->imagen_principal)
                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" 
                                           id="eliminarImagenPrincipal{{ $prenda->id }}" 
                                           name="eliminar_imagen_principal">
                                    <label class="form-check-label text-danger" for="eliminarImagenPrincipal{{ $prenda->id }}">
                                        <i class="fas fa-trash-alt mr-1"></i> Eliminar imagen actual
                                    </label>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Imágenes Secundarias -->
                            <div class="card card-body border-0 shadow-sm">
                                <h6 class="font-weight-bold text-primary mb-3">
                                    <i class="fas fa-images mr-2"></i>Galería de Imágenes
                                </h6>
                                
                                <!-- Galería existente -->
                                <div id="galeriaPrenda{{ $prenda->id }}" class="row gallery-grid">
                                    @php
                                        // Ya no necesitamos json_decode porque el cast en el modelo ya lo convierte en array
                                        $imagenesSecundarias = $prenda->imagenes_secundarias ?? [];
                                    @endphp
                                    
                                    @if(count($imagenesSecundarias) > 0)
                                        @foreach($imagenesSecundarias as $imagen)
                                        <div class="col-4 col-md-3 col-lg-2 mb-3">
                                            <div class="gallery-thumbnail">
                                                <img src="{{ asset('storage/'.$imagen) }}" 
                                                     class="img-fluid rounded shadow-sm"
                                                     style="cursor: pointer;"
                                                     onclick="openImageModal('{{ asset('storage/'.$imagen) }}')">
                                                
                                                <button type="button" 
                                                        class="btn btn-danger btn-remove-image"
                                                        onclick="removeImage(this, '{{ $imagen }}', '{{ $prenda->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                
                                                <input type="hidden" name="imagenes_secundarias_existentes[]" value="{{ $imagen }}">
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <p class="text-muted text-center mb-0">No hay imágenes secundarias</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Nuevas imágenes (previsualización) -->
                                <div id="nuevasImagenesContainer{{ $prenda->id }}" class="row gallery-grid mb-3"></div>
                                
                                <!-- Contador de imágenes -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <span id="contadorImagenes{{ $prenda->id }}">0</span>/10 imágenes seleccionadas
                                    </small>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            id="limpiarImagenes{{ $prenda->id }}" 
                                            style="display: none;"
                                            onclick="clearSecondaryImages({{ $prenda->id }})">
                                        <i class="fas fa-times mr-1"></i> Limpiar
                                    </button>
                                </div>
                                
                                <!-- Botón de carga -->
                                <div class="file-upload-wrapper">
                                    <label class="btn btn-outline-primary btn-block">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i> Añadir imágenes secundarias
                                        <input type="file" 
                                               id="imagenesSecundarias{{ $prenda->id }}" 
                                               name="imagenes_secundarias[]" 
                                               multiple
                                               accept="image/*"
                                               class="d-none"
                                               onchange="handleSecondaryImages(this, {{ $prenda->id }})">
                                    </label>
                                    <small class="form-text text-muted text-center">
                                        Formatos: JPG, PNG | Máx. 5MB por imagen
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para vista ampliada -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-body p-0 text-center">
                <img id="modalImage" src="" class="img-fluid" style="max-height: 80vh;">
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar Select2
        $('.select2-categoria, .select2-coleccion').select2({
            width: '100%',
            dropdownParent: $('#modalPrendaEdit{{ $prenda->id }}')
        });

        // Manejar cambio de pestañas
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            const target = $(e.target).attr("href");
            if(target.includes('categoriaTab')) {
                $('#formEditarPrenda{{ $prenda->id }} input[name="tipo_clasificacion"]').val('categoria');
            } else if(target.includes('coleccionTab')) {
                $('#formEditarPrenda{{ $prenda->id }} input[name="tipo_clasificacion"]').val('coleccion');
            }
        });

        // Validación del formulario
        $('#formEditarPrenda{{ $prenda->id }}').submit(function(e) {
            const tipo = $('input[name="tipo_clasificacion"]').val();
            let isValid = true;
            
            if(tipo === 'categoria' && !$('select[name="categoria_id"]').val()) {
                toastr.error('Debe seleccionar una categoría');
                isValid = false;
            } else if(tipo === 'coleccion' && !$('select[name="coleccion_id"]').val()) {
                toastr.error('Debe seleccionar una colección');
                isValid = false;
            }
            
            if(!isValid) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Función para abrir imagen en modal
    function openImageModal(src) {
        $('#modalImage').attr('src', src);
        $('#imageModal').modal('show');
    }

    // Vista previa de imagen principal
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.onclick = function() { openImageModal(e.target.result); };
            };
            reader.readAsDataURL(file);
            
            $(input).next('.custom-file-label').text(file.name);
            
            if($('#eliminarImagenPrincipal{{ $prenda->id }}').length) {
                $('#eliminarImagenPrincipal{{ $prenda->id }}').prop('checked', false);
            }
        }
    }

    // Manejo de imágenes secundarias
    function handleSecondaryImages(input, prendaId) {
        const files = input.files;
        const container = $('#nuevasImagenesContainer' + prendaId);
        const contador = $('#contadorImagenes' + prendaId);
        const limpiarBtn = $('#limpiarImagenes' + prendaId);
        
        container.empty();
        
        if (files && files.length > 0) {
            // Validar número máximo de imágenes
            if (files.length > 10) {
                toastr.error('Máximo 10 imágenes permitidas');
                input.value = '';
                return;
            }
            
            // Validar tamaño y tipo
            Array.from(files).forEach((file, index) => {
                if (!file.type.match('image.*')) {
                    toastr.error(`El archivo ${file.name} no es una imagen válida`);
                    return;
                }
                
                if (file.size > 5 * 1024 * 1024) {
                    toastr.error(`La imagen ${file.name} excede el tamaño máximo de 5MB`);
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = $('<div class="col-4 col-md-3 col-lg-2 mb-3"></div>');
                    const thumb = $(`
                        <div class="gallery-thumbnail">
                            <img src="${e.target.result}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="cursor: pointer;"
                                 onclick="openImageModal('${e.target.result}')">
                            <button type="button" class="btn btn-danger btn-remove-image"
                                    onclick="removeNewImage(this, ${prendaId}, ${index})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `);
                    
                    col.append(thumb);
                    container.append(col);
                };
                reader.readAsDataURL(file);
            });
            
            contador.text(files.length);
            limpiarBtn.show();
        } else {
            contador.text('0');
            limpiarBtn.hide();
        }
    }

    // Eliminar imagen existente
    function removeImage(button, imagen, prendaId) {
        $(button).closest('.col-4').after(
            '<input type="hidden" name="imagenes_secundarias_eliminar[]" value="' + imagen + '">'
        );
        $(button).closest('.col-4').remove();
        toastr.warning('Imagen marcada para eliminación. Guarda los cambios para confirmar.');
    }

    // Eliminar imagen nueva
    function removeNewImage(button, prendaId, index) {
        const input = $('#imagenesSecundarias' + prendaId)[0];
        const files = Array.from(input.files);
        files.splice(index, 1);
        
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
        
        $(button).closest('.col-4').remove();
        $('#contadorImagenes' + prendaId).text(files.length);
        
        if (files.length === 0) {
            $('#limpiarImagenes' + prendaId).hide();
        }
    }

    // Limpiar todas las imágenes nuevas
    function clearSecondaryImages(prendaId) {
        $('#imagenesSecundarias' + prendaId).val('');
        $('#nuevasImagenesContainer' + prendaId).empty();
        $('#contadorImagenes' + prendaId).text('0');
        $('#limpiarImagenes' + prendaId).hide();
    }
</script>
@endpush

@push('styles')
<style>
    /* Galería */
    .gallery-grid {
        margin: -0.5rem;
    }
    .gallery-thumbnail {
        position: relative;
        overflow: hidden;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
    }
    .gallery-thumbnail:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .gallery-thumbnail img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        display: block;
    }
    .btn-remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 25px;
        height: 25px;
        padding: 0;
        border-radius: 50%;
        font-size: 10px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .gallery-thumbnail:hover .btn-remove-image {
        opacity: 1;
    }

    /* Hover zoom */
    .hover-zoom {
        transition: transform 0.3s;
    }
    .hover-zoom:hover {
        transform: scale(1.05);
    }

    /* Modal ajustes */
    .modal-xl .modal-body {
        padding: 1.5rem;
    }
    
    /* Custom file input */
    .custom-file-label::after {
        content: "Examinar";
    }
</style>
@endpush