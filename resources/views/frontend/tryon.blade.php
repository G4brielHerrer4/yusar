@extends('layouts.master')

@section('title', 'Virtual Try-On | YUSAR')

@section('content')
    <!-- Banner -->
    <div class="slider-area">
        <div class="single-slider slider-height2 d-flex align-items-center" 
             style="background-image: url('{{ asset('frontend/assets/img/hero/category.jpg') }}')">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Virtual TRY ON</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Área de Try-On -->
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Prueba Virtual (Try-On Diffusion API)</h4>
                    </div>
                    <div class="card-body">
                        <!-- Paso 1: Subir imágenes -->
                        <div class="row mb-4">
                            <div class="col-md-6 text-center">
                                <h5>Tu foto (pose)</h5>
                                <div class="image-upload-box border rounded p-3 mb-3" id="humanBox">
                                    <img id="humanPreview" src="#" alt="Previsualización pose" style="display: none; max-width: 100%; max-height: 300px;">
                                    <p class="text-muted mt-2">Arrastra o haz clic para subir</p>
                                    <input type="file" id="humanInput" accept="image/*" class="d-none">
                                </div>
                                <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('humanInput').click()">Elegir imagen</button>
                                <div class="mt-2">
                                    <small class="text-muted">Recomendado: Foto frontal, buena iluminación</small>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <h5>Prenda de vestir</h5>
                                <div class="image-upload-box border rounded p-3 mb-3" id="garmentBox">
                                    <img id="garmentPreview" src="#" alt="Previsualización prenda" style="display: none; max-width: 100%; max-height: 300px;">
                                    <p class="text-muted mt-2">Arrastra o haz clic para subir</p>
                                    <input type="file" id="garmentInput" accept="image/*" class="d-none">
                                </div>
                                <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('garmentInput').click()">Elegir imagen</button>
                                <div class="mt-2">
                                    <small class="text-muted">Recomendado: Prenda en maniquí o persona</small>
                                </div>
                            </div>
                        </div>

                        <!-- Opciones avanzadas -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="accordion" id="advancedOptions">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                    Opciones avanzadas
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#advancedOptions">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="avatarSex">Género del avatar</label>
                                                    <select class="form-control" id="avatarSex">
                                                        <option value="">Auto-detectar</option>
                                                        <option value="female">Femenino</option>
                                                        <option value="male">Masculino</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="backgroundPrompt">Descripción del fondo</label>
                                                    <input type="text" class="form-control" id="backgroundPrompt" placeholder="Ej: en una playa al atardecer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 2: Botón de procesamiento -->
                        <div class="text-center mb-4">
                            <button id="processBtn" class="btn btn-primary btn-lg" disabled>
                                <span id="btnText">Generar Try-On</span>
                                <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </div>

                        <!-- Paso 3: Resultado -->
                        <div class="text-center" id="resultSection" style="display: none;">
                            <h5 class="mb-3">Resultado</h5>
                            <div class="border rounded p-3 bg-light">
                                <img id="resultImage" src="#" alt="Resultado Try-On" style="max-width: 100%; max-height: 500px; display: none;">
                                <div id="loadingText" class="text-muted">
                                    <p>Procesando tu imagen...</p>
                                    <div class="progress">
                                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div id="errorText" class="text-danger" style="display: none;"></div>
                            </div>
                            <button id="downloadBtn" class="btn btn-success mt-3" style="display: none;">
                                <i class="fas fa-download"></i> Descargar Resultado
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Configuración de la API
    const RAPIDAPI_KEY = '06cd964e8amshc59c399d57b931ap18f4ddjsna6ebbbba7f89';
    const API_HOST = 'try-on-diffusion.p.rapidapi.com';
    const API_URL = 'https://try-on-diffusion.p.rapidapi.com/try-on-file';

    // Variables globales
    let humanFile = null;
    let garmentFile = null;

    // ===== [1] Previsualización de imágenes =====
    document.getElementById('humanInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            humanFile = file;
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('humanPreview').src = event.target.result;
                document.getElementById('humanPreview').style.display = 'block';
                document.querySelector('#humanBox p').style.display = 'none';
                checkReady();
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('garmentInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            garmentFile = file;
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('garmentPreview').src = event.target.result;
                document.getElementById('garmentPreview').style.display = 'block';
                document.querySelector('#garmentBox p').style.display = 'none';
                checkReady();
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag & Drop
    ['humanBox', 'garmentBox'].forEach(id => {
        const box = document.getElementById(id);
        box.addEventListener('dragover', (e) => {
            e.preventDefault();
            box.classList.add('border-primary');
        });
        box.addEventListener('dragleave', () => {
            box.classList.remove('border-primary');
        });
        box.addEventListener('drop', (e) => {
            e.preventDefault();
            box.classList.remove('border-primary');
            const inputId = id === 'humanBox' ? 'humanInput' : 'garmentInput';
            document.getElementById(inputId).files = e.dataTransfer.files;
            const event = new Event('change');
            document.getElementById(inputId).dispatchEvent(event);
        });
    });

    // ===== [2] Habilitar botón cuando ambas imágenes estén listas =====
    function checkReady() {
        const btn = document.getElementById('processBtn');
        if (humanFile && garmentFile) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }

    // ===== [3] Procesamiento con la API de Try-On Diffusion =====
    document.getElementById('processBtn').addEventListener('click', async function() {
        const btn = this;
        const btnText = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');
        const resultSection = document.getElementById('resultSection');
        const resultImage = document.getElementById('resultImage');
        const loadingText = document.getElementById('loadingText');
        const errorText = document.getElementById('errorText');
        const progressBar = document.getElementById('progressBar');
        const downloadBtn = document.getElementById('downloadBtn');

        // Resetear la sección de resultados
        errorText.style.display = 'none';
        errorText.textContent = '';
        resultImage.style.display = 'none';
        downloadBtn.style.display = 'none';
        resultSection.style.display = 'block';
        loadingText.style.display = 'block';
        progressBar.style.width = '0%';

        // Mostrar spinner y deshabilitar botón
        btn.disabled = true;
        btnText.textContent = 'Procesando...';
        spinner.classList.remove('d-none');

        try {
            // Crear FormData para enviar las imágenes
            const formData = new FormData();
            formData.append('avatar_image', humanFile);
            formData.append('clothing_image', garmentFile);
            
            // Añadir opciones avanzadas si están configuradas
            const avatarSex = document.getElementById('avatarSex').value;
            const backgroundPrompt = document.getElementById('backgroundPrompt').value;
            
            if (avatarSex) {
                formData.append('avatar_sex', avatarSex);
            }
            
            if (backgroundPrompt) {
                formData.append('background_prompt', backgroundPrompt);
            }

            // Simular progreso (actualizaremos esto con eventos reales si la API los soporta)
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += 5;
                progressBar.style.width = `${Math.min(progress, 90)}%`;
                if (progress >= 90) clearInterval(progressInterval);
            }, 300);

            // Llamar a la API de Try-On Diffusion
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'X-RapidAPI-Key': RAPIDAPI_KEY,
                    'X-RapidAPI-Host': API_HOST
                },
                body: formData
            });

            clearInterval(progressInterval);
            progressBar.style.width = '100%';

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.detail || 'Error en la generación');
            }

            // Procesar la respuesta (debe ser una imagen)
            const imageBlob = await response.blob();
            const imageUrl = URL.createObjectURL(imageBlob);
            
            resultImage.src = imageUrl;
            resultImage.style.display = 'block';
            loadingText.style.display = 'none';
            
            // Habilitar botón de descarga
            downloadBtn.style.display = 'inline-block';
            downloadBtn.onclick = () => {
                const a = document.createElement('a');
                a.href = imageUrl;
                a.download = 'virtual-try-on-result.jpg';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            };

        } catch (error) {
            console.error('Error:', error);
            errorText.textContent = `Error: ${error.message}`;
            errorText.style.display = 'block';
            loadingText.style.display = 'none';
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Generar Try-On';
            spinner.classList.add('d-none');
        }
    });

    // Validar tamaño de imágenes antes de subir
    ['humanInput', 'garmentInput'].forEach(id => {
        document.getElementById(id).addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.size > 12 * 1024 * 1024) { // 12 MB
                alert('La imagen es demasiado grande. El tamaño máximo permitido es 12MB.');
                e.target.value = '';
                
                if (id === 'humanInput') {
                    humanFile = null;
                    document.getElementById('humanPreview').style.display = 'none';
                    document.querySelector('#humanBox p').style.display = 'block';
                } else {
                    garmentFile = null;
                    document.getElementById('garmentPreview').style.display = 'none';
                    document.querySelector('#garmentBox p').style.display = 'block';
                }
                
                checkReady();
            }
        });
    });
</script>

<style>
    .image-upload-box {
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: border 0.3s;
        background-color: #f8f9fa;
    }
    .image-upload-box:hover {
        border-color: #007bff !important;
        background-color: #e9ecef;
    }
    #resultImage {
        max-height: 70vh;
    }
    .progress {
        height: 20px;
        margin-top: 10px;
    }
</style>
@endsection