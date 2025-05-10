<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.asignacion_material.store') }}" method="POST" id="formAsignacion">
                @csrf
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalCreateLabel">Nueva Asignación</h5>
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
                                    <option value="">Seleccione responsable</option>
                                    @foreach($responsables as $user)
                                        <option value="{{ $user->id }}">{{ $user->nombre }} {{ $user->apellido }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confeccionista *</label>
                                <select name="confeccionista_id" class="form-control" required>
                                    <option value="">Seleccione confeccionista</option>
                                    @foreach($confeccionistas->where('estado', true) as $conf)
                                        <option value="{{ $conf->id }}">
                                            {{ $conf->nombre }} {{ $conf->apellido }} ({{ $conf->celular }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Solo se muestran confeccionistas activos</small>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                            <span>Materiales</span>
                            <button type="button" id="btn-add-material" class="btn btn-sm btn-light">
                                <i class="fas fa-plus"></i> Agregar Material
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="materiales-container">
                                <div class="row material-row mb-3">
                                    <div class="col-md-6">
                                        <select name="materiales[0][material_id]" class="form-control material-select" required>
                                            <option value="">Seleccione material</option>
                                            @foreach($materiales as $material)
                                                <option value="{{ $material->id }}" 
                                                    data-stock="{{ $material->stock_actual }}"
                                                    @if($material->stock_actual <= 0) disabled @endif>
                                                    {{ $material->material->nombre }} (Stock: {{ $material->stock_actual }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" step="0.01" min="0.1" 
                                               name="materiales[0][cantidad]" 
                                               class="form-control material-cantidad" 
                                               placeholder="Cantidad" 
                                               required
                                               @if($material->stock_actual <= 0) disabled @endif>
                                        <div class="invalid-feedback" id="error-0"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-block btn-remove-material" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Prendas Esperadas *</label>
                                <input type="number" name="prendas_esperadas" class="form-control" min="1" required>
                            </div>
                        </div>
        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Entrega *</label>
                                <input type="date" name="fecha_entrega_estimada" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones') }}</textarea>
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

<!-- Incluir Toastr para notificaciones -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let materialCounter = 1;
    const container = document.getElementById('materiales-container');
    const addButton = document.getElementById('btn-add-material');
    
    // Agregar nuevo campo de material
    function addMaterialField() {
        const newRow = document.createElement('div');
        newRow.className = 'row material-row mb-3';
        newRow.innerHTML = `
            <div class="col-md-6">
                <select name="materiales[${materialCounter}][material_id]" class="form-control material-select" required>
                    <option value="">Seleccione material</option>
                    @foreach($materiales as $material)
                        <option value="{{ $material->id }}" 
                            data-stock="{{ $material->stock_actual }}"
                            @if($material->stock_actual <= 0) disabled @endif>
                            {{ $material->material->nombre }} (Stock: {{ $material->stock_actual }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" step="0.01" min="0.1" 
                       name="materiales[${materialCounter}][cantidad]" 
                       class="form-control material-cantidad" 
                       placeholder="Cantidad" 
                       required
                       @if($material->stock_actual <= 0) disabled @endif>
                <div class="invalid-feedback" id="error-${materialCounter}"></div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-block btn-remove-material">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        container.appendChild(newRow);
        
        // Agregar eventos al nuevo material
        const newSelect = newRow.querySelector('.material-select');
        const newInput = newRow.querySelector('.material-cantidad');
        
        newSelect.addEventListener('change', function() {
            const stock = parseFloat(this.options[this.selectedIndex].dataset.stock) || 0;
            newInput.disabled = stock <= 0;
            
            if (stock <= 0) {
                newInput.value = '';
            }
        });
        
        newInput.addEventListener('input', function() {
            const stock = parseFloat(newSelect.options[newSelect.selectedIndex].dataset.stock) || 0;
            const cantidad = parseFloat(this.value) || 0;
            const errorElement = this.nextElementSibling;
            
            if (cantidad > stock) {
                this.classList.add('is-invalid');
                errorElement.textContent = `Stock insuficiente. Máximo disponible: ${stock}`;
                errorElement.style.display = 'block';
            } else if (cantidad <= 0) {
                this.classList.add('is-invalid');
                errorElement.textContent = 'La cantidad debe ser mayor a 0';
                errorElement.style.display = 'block';
            } else {
                this.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        });
        
        materialCounter++;
        updateRemoveButtons();
    }
    
    // Actualizar botones de eliminar
    function updateRemoveButtons() {
        const buttons = document.querySelectorAll('.btn-remove-material');
        buttons.forEach(button => {
            button.disabled = buttons.length <= 1;
        });
    }
    
    // Evento para agregar material
    addButton.addEventListener('click', addMaterialField);
    
    // Evento para eliminar material
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-material') || 
            e.target.closest('.btn-remove-material')) {
            const button = e.target.classList.contains('btn-remove-material') ? 
                e.target : e.target.closest('.btn-remove-material');
            const row = button.closest('.material-row');
            
            if (document.querySelectorAll('.material-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });
    
    // Validación inicial para el primer material
    const firstSelect = document.querySelector('.material-select');
    const firstInput = document.querySelector('.material-cantidad');
    
    if (firstSelect && firstInput) {
        firstSelect.addEventListener('change', function() {
            const stock = parseFloat(this.options[this.selectedIndex].dataset.stock) || 0;
            firstInput.disabled = stock <= 0;
            
            if (stock <= 0) {
                firstInput.value = '';
            }
        });
        
        firstInput.addEventListener('input', function() {
            const stock = parseFloat(firstSelect.options[firstSelect.selectedIndex].dataset.stock) || 0;
            const cantidad = parseFloat(this.value) || 0;
            const errorElement = this.nextElementSibling;
            
            if (cantidad > stock) {
                this.classList.add('is-invalid');
                errorElement.textContent = `Stock insuficiente. Máximo disponible: ${stock}`;
                errorElement.style.display = 'block';
            } else if (cantidad <= 0) {
                this.classList.add('is-invalid');
                errorElement.textContent = 'La cantidad debe ser mayor a 0';
                errorElement.style.display = 'block';
            } else {
                this.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        });
    }
    
    // Validación antes de enviar el formulario
    document.getElementById('formAsignacion').addEventListener('submit', function(e) {
        let isValid = true;
        const materialRows = document.querySelectorAll('.material-row');
        
        materialRows.forEach((row, index) => {
            const select = row.querySelector('.material-select');
            const input = row.querySelector('.material-cantidad');
            const stock = parseFloat(select.options[select.selectedIndex].dataset.stock) || 0;
            const cantidad = parseFloat(input.value) || 0;
            const errorElement = row.querySelector('.invalid-feedback');
            
            // Validar que se seleccionó un material
            if (!select.value) {
                select.classList.add('is-invalid');
                isValid = false;
            } else {
                select.classList.remove('is-invalid');
            }
            
            // Validar cantidad vs stock
            if (cantidad > stock) {
                input.classList.add('is-invalid');
                errorElement.textContent = `Stock insuficiente. Máximo disponible: ${stock}`;
                errorElement.style.display = 'block';
                isValid = false;
            } else if (cantidad <= 0) {
                input.classList.add('is-invalid');
                errorElement.textContent = 'La cantidad debe ser mayor a 0';
                errorElement.style.display = 'block';
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            toastr.error('Por favor corrige los errores en el formulario', 'Error de Validación', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-center',
                timeOut: 5000
            });
            
            // Desplazarse al primer error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
</script>

<style>
    .is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        display: none;
    }
    .toast-top-center {
        top: 12px;
        left: 50%;
        transform: translateX(-50%);
    }
</style>