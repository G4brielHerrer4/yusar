@foreach($materiales as $material)
<div class="modal fade" id="modalEditarMaterial{{ $material->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('admin.gestion_material.materiales.modals.update', $material->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-2"></i> Editar Material
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold text-primary">
                            <i class="fas fa-tag mr-1"></i> Nombre *
                        </label>
                        <input type="text" class="form-control" name="nombre" value="{{ $material->nombre }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold text-primary">
                            <i class="fas fa-palette mr-1"></i> Color
                        </label>
                        <div class="d-flex align-items-center color-selector-container">
                            <input type="text" class="form-control color-hex-input" name="color" 
                                   id="colorInputEdit{{ $material->id }}" 
                                   value="{{ $material->color ?? '' }}"
                                   placeholder="Selecciona un color" readonly>
                            <div class="color-preview-circle ml-2" 
                                 id="colorPreviewCircleEdit{{ $material->id }}"
                                 style="{{ $material->color ? 'background-color: '.$material->color : '' }}">
                                @if(!$material->color)
                                <i class="fas fa-plus text-muted"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold text-primary">
                            <i class="fas fa-ruler-combined mr-1"></i> Unidad de Medida *
                        </label>
                        <select class="form-control" name="unidad_medida" required>
                            <option value="unidades" {{ $material->unidad_medida == 'unidades' ? 'selected' : '' }}>Unidades</option>
                            <option value="metros" {{ $material->unidad_medida == 'metros' ? 'selected' : '' }}>Metros</option>
                            <option value="rollos" {{ $material->unidad_medida == 'rollos' ? 'selected' : '' }}>Rollos</option>
                            <option value="cajas" {{ $material->unidad_medida == 'cajas' ? 'selected' : '' }}>Cajas</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold text-primary">
                            <i class="fas fa-image mr-1"></i> Imagen
                        </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imagenEdit{{ $material->id }}" name="imagen">
                            <label class="custom-file-label" for="imagenEdit{{ $material->id }}">
                                {{ $material->imagen ? basename($material->imagen) : 'Cambiar imagen...' }}
                            </label>
                        </div>
                        <div class="image-preview mt-2">
                            @if($material->imagen)
                            <img id="imagePreviewEdit{{ $material->id }}" 
                                 src="{{ asset('storage/'.$material->imagen) }}" 
                                 alt="Vista previa" style="max-width: 100px;">
                            @else
                            <img id="imagePreviewEdit{{ $material->id }}" 
                                 src="#" alt="Vista previa" 
                                 style="max-width: 100px; display: none;">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Incluir Pickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css">

<style>
.color-preview-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid #dee2e6;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.color-preview-circle:hover {
    transform: scale(1.05);
}

.color-hex-input {
    cursor: pointer;
    background-color: #f8f9fa;
}

/* Asegurar que el color picker aparezca sobre el modal */
.pickr-container {
    z-index: 1060 !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<!-- Incluir dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($materiales as $material)
    // Inicializar Pickr para cada modal de edición
    const pickrEdit{{ $material->id }} = Pickr.create({
        el: '#colorPreviewCircleEdit{{ $material->id }}',
        theme: 'classic',
        default: '{{ $material->color ?? '' }}',
        swatches: [
            '#FF0000', '#00FF00', '#0000FF', '#FFFF00', 
            '#FF00FF', '#00FFFF', '#000000', '#FFFFFF',
            '#FFA500', '#800080', '#A52A2A', '#008000',
            '#000080', '#FFC0CB', '#808080', '#FF4500'
        ],
        components: {
            preview: true,
            opacity: false,
            hue: true,
            interaction: {
                hex: true,
                input: true,
                save: true
            }
        }
    });

    // Actualizar el input y preview cuando se selecciona un color
    pickrEdit{{ $material->id }}.on('change', (color) => {
        const hexColor = color ? color.toHEXA().toString() : '';
        document.getElementById('colorInputEdit{{ $material->id }}').value = hexColor;
        const previewCircle = document.getElementById('colorPreviewCircleEdit{{ $material->id }}');
        previewCircle.style.backgroundColor = hexColor;
        previewCircle.innerHTML = hexColor ? '' : '<i class="fas fa-plus text-muted"></i>';
    });

    // Previsualización de imagen para edición
    document.getElementById('imagenEdit{{ $material->id }}').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.querySelector(`label[for="imagenEdit{{ $material->id }}"]`).textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreviewEdit{{ $material->id }}');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
    @endforeach
});
</script>