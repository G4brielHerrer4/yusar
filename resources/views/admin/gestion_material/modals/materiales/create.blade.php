<div class="modal fade" id="modalCrearMaterial" tabindex="-1" role="dialog" aria-labelledby="modalCrearMaterialLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.gestion_material.materiales.modals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Nuevo Material</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre *</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Color</label>
                        <div class="color-picker-container">
                            <input type="text" class="form-control color-value" name="color" id="colorInput" placeholder="Haz clic para seleccionar" readonly>
                            <div id="colorPickerTrigger" class="color-preview" style="background-color: transparent; border: 1px dashed #ccc;">
                                <i class="fas fa-palette" style="color: #6c757d; display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Unidad de Medida *</label>
                        <select class="form-control" name="unidad_medida" required>
                            <option value="unidades">Unidades</option>
                            <option value="metros">Metros</option>
                            <option value="rollos">Rollos</option>
                            <option value="cajas">Cajas</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Imagen (Opcional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imagen" name="imagen">
                            <label class="custom-file-label" for="imagen">Seleccionar archivo</label>
                        </div>
                        <div class="image-preview mt-2">
                            <img id="imagePreview" src="#" alt="Vista previa" style="max-width: 100%; display: none;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluir Pickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css">

<style>
.color-picker-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.color-preview {
    width: 40px;
    height: 40px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.color-preview:hover {
    border-color: #6c757d;
}

.color-value {
    flex-grow: 1;
    background-color: #f8f9fa;
    cursor: pointer;
}

/* Asegurar que el color picker aparezca sobre el modal */
.pickr-container {
    z-index: 1060 !important;
}
</style>

<!-- Incluir dependencias -->
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Pickr sin color por defecto
    const pickr = Pickr.create({
        el: '#colorPickerTrigger',
        theme: 'classic',
        default: null, // Sin color por defecto
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

    // Elementos del DOM
    const colorInput = document.getElementById('colorInput');
    const colorPreview = document.getElementById('colorPickerTrigger');
    const imageInput = document.getElementById('imagen');
    const imagePreview = document.getElementById('imagePreview');
    const fileLabel = document.querySelector('.custom-file-label');

    // Actualizar el input cuando se selecciona un color
    pickr.on('change', (color) => {
        if (color) {
            const hexColor = color.toHEXA().toString();
            colorInput.value = hexColor;
            colorPreview.style.backgroundColor = hexColor;
            colorPreview.innerHTML = ''; // Elimina el icono al seleccionar color
        }
    });

    // Resetear al cancelar
    pickr.on('cancel', () => {
        pickr.setColor(null);
    });

    // Previsualización de imagen
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            fileLabel.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Cerrar el color picker cuando se cierra el modal
    $('#modalCrearMaterial').on('hidden.bs.modal', function() {
        pickr.hide();
    });
});
</script>