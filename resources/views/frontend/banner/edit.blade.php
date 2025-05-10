@extends('adminlte::page')

@section('title', 'Editar Banner')

@section('content')
<div class="card shadow-sm" style="border-top: 3px solid #1da2c1;">
    <div class="card-header" style="background: linear-gradient(135deg, #121929 0%, #123e51 100%); color: white;">
        <h3 class="card-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Editar Banner</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="titulo" class="font-weight-bold">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" 
                       value="{{ old('titulo', $banner->titulo) }}" required
                       style="border: 1px solid #146a85; border-radius: 5px;">
                @error('titulo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="descripcion" class="font-weight-bold">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $banner->descripcion) }}</textarea>
                @error('descripcion')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="imagen" class="font-weight-bold">Imagen</label>
                <div class="custom-file">
                    <input type="file" name="imagen" id="imagen" class="custom-file-input"
                           style="border: 1px solid #146a85; border-radius: 5px;">
                    <label class="custom-file-label" for="imagen">Seleccionar nueva imagen...</label>
                </div>
                @error('imagen')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                
                @if($banner->imagen)
                <div class="mt-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $banner->imagen) }}" 
                             class="img-thumbnail mr-3 img-zoom" 
                             style="max-width: 100px; border-color: #1da2c1;">
                        <div>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="document.getElementById('remove-image').value = '1'; 
                                             this.parentNode.innerHTML = '<span class=\'text-success\'><i class=\'fas fa-check\'></i> Imagen marcada para eliminar</span>';">
                                <i class="fas fa-trash"></i> Eliminar imagen actual
                            </button>
                            <input type="hidden" name="remove_image" id="remove-image" value="0">
                        </div>
                    </div>
                    <small class="form-text text-muted">Imagen actual. Sube una nueva para reemplazarla.</small>
                </div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="estado" class="font-weight-bold">Estado</label>
                <select name="estado" id="estado" class="form-control" required
                        style="border: 1px solid #146a85; border-radius: 5px;">
                    <option value="1" {{ old('estado', $banner->estado) == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('estado', $banner->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
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
                    <i class="fas fa-save mr-2"></i>Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('css')
<style>
    .ck-editor__editable_inline {
        min-height: 250px;
        border: 1px solid #146a85 !important;
        border-radius: 5px !important;
    }
    .ck.ck-toolbar {
        border: 1px solid #146a85 !important;
        border-bottom: none !important;
        border-radius: 5px 5px 0 0 !important;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: #146a85 !important;
    }
    .ck.ck-editor__main>.ck-editor__editable.ck-focused {
        border-color: #1da2c1 !important;
        box-shadow: 0 0 0 1px #1da2c1 !important;
    }
    .img-thumbnail {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .custom-file-label::after {
        background-color: #1da2c1;
        color: white;
        border-left: 1px solid #146a85;
    }
</style>
@endsection

@section('js')
<!-- CKEditor 5 desde CDN con HTTPS -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    // Inicializar CKEditor con más opciones
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                    'link', 'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'alignment', '|',
                    'blockQuote', 'insertTable', '|',
                    'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                    'horizontalLine', 'specialCharacters', '|',
                    'undo', 'redo'
                ],
                shouldNotGroupWhenFull: true
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Párrafo', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Título 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Título 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Título 3', class: 'ck-heading_heading3' }
                ]
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22, 24, 28, 32],
                supportAllValues: true
            },
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            language: 'es',
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
            },
            licenseKey: '',
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Mostrar nombre del archivo seleccionado
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Seleccionar nueva imagen...';
        const label = e.target.nextElementSibling;
        label.innerText = fileName;
    });

    // Efecto zoom en imágenes
    document.querySelectorAll('.img-zoom').forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.8)';
            this.style.zIndex = '1000';
            this.style.position = 'relative';
            this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.zIndex = '';
            this.style.position = '';
            this.style.boxShadow = '';
        });
    });
</script>
@endsection