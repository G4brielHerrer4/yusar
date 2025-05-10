@extends('adminlte::page')

@section('title', 'Crear Banner')

@section('content')
<div class="card shadow-sm" style="border-top: 3px solid #1da2c1;">
    <div class="card-header" style="background: linear-gradient(135deg, #121929 0%, #123e51 100%); color: white;">
        <h3 class="card-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i>Crear Banner</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="titulo" class="font-weight-bold">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" 
                       value="{{ old('titulo') }}" required
                       style="border: 1px solid #146a85; border-radius: 5px;">
                @error('titulo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="descripcion" class="font-weight-bold">Descripción</label>
                <!-- Toolbar del editor -->
                <div class="btn-toolbar mb-2" role="toolbar">
                    <div class="btn-group btn-group-sm mr-2">
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('bold')" title="Negrita">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('italic')" title="Cursiva">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('underline')" title="Subrayado">
                            <i class="fas fa-underline"></i>
                        </button>
                    </div>
                    <div class="btn-group btn-group-sm mr-2">
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('insertUnorderedList')" title="Lista">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="formatText('insertOrderedList')" title="Lista numerada">
                            <i class="fas fa-list-ol"></i>
                        </button>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <select class="form-control form-control-sm" onchange="formatText('fontSize', this.value)" title="Tamaño de letra">
                            <option value="">Tamaño</option>
                            <option value="1">Pequeño</option>
                            <option value="3" selected>Normal</option>
                            <option value="5">Grande</option>
                            <option value="7">Muy grande</option>
                        </select>
                    </div>
                </div>
                
                <!-- Área de texto editable -->
                <div id="descripcion" class="form-control" 
                     style="min-height: 150px; border: 1px solid #146a85; border-radius: 5px;"
                     contenteditable="true">{{ old('descripcion') }}</div>
                <textarea name="descripcion" id="descripcion-hidden" style="display:none;"></textarea>
                @error('descripcion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="imagen" class="font-weight-bold">Imagen</label>
                <div class="custom-file">
                    <input type="file" name="imagen" id="imagen" class="custom-file-input" required
                           style="border: 1px solid #146a85; border-radius: 5px;">
                    <label class="custom-file-label" for="imagen">Seleccionar archivo...</label>
                </div>
                @error('imagen')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="estado" class="font-weight-bold">Estado</label>
                <select name="estado" id="estado" class="form-control" required
                        style="border: 1px solid #146a85; border-radius: 5px;">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                @error('estado')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group text-right">
                <a href="{{ route('banner.index') }}" class="btn btn-outline-secondary mr-2"
                   style="border-color: #146a85; color: #146a85;">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
                <button type="submit" class="btn btn-primary" 
                        style="background-color: #20dbd8; border-color: #1da2c1; min-width: 120px;">
                    <i class="fas fa-save mr-2"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    // Función para formatear el texto
    function formatText(command, value = null) {
        const descripcion = document.getElementById('descripcion');
        document.execCommand(command, false, value);
        descripcion.focus();
    }
    
    // Actualizar el textarea oculto antes de enviar el formulario
    document.querySelector('form').addEventListener('submit', function() {
        const descripcion = document.getElementById('descripcion');
        const hiddenField = document.getElementById('descripcion-hidden');
        hiddenField.value = descripcion.innerHTML;
    });
    
    // Mostrar nombre del archivo seleccionado
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0].name;
        const label = e.target.nextElementSibling;
        label.innerText = fileName;
    });
    
    // Inicializar el contenido si hay un valor antiguo
    document.addEventListener('DOMContentLoaded', function() {
        const oldDescripcion = "{{ old('descripcion') }}";
        if(oldDescripcion) {
            document.getElementById('descripcion').innerHTML = oldDescripcion;
        }
    });
</script>

<style>
    #descripcion:focus {
        border-color: #1da2c1 !important;
        box-shadow: 0 0 0 0.2rem rgba(29, 162, 193, 0.25);
    }
    
    .btn-outline-secondary {
        border-color: #146a85;
        color: #146a85;
    }
    
    .btn-outline-secondary:hover {
        background-color: #1da2c1;
        color: white;
    }
    
    .custom-file-label::after {
        background-color: #1da2c1;
        color: white;
        border-left: 1px solid #146a85;
    }
</style>
@endsection