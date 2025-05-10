@extends('layouts.app')

@section('content')
<div class="login-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Botón para regresar -->
                <div class="mb-3 mt-3">
                    <a href="/" class="btn btn-back">
                        <i class="fas fa-arrow-left mr-2"></i> Regresar
                    </a>
                </div>
                
                <div class="login-card shadow">
                    <!-- Encabezado con logo -->
                    <div class="card-header text-center py-3">
                        <img src="{{ asset('frontend/assets/img/logo/logosolo.jpeg') }}" alt="YUSAR - Moda con equilibrio" class="logo-img">
                        <h4 class="mt-2 mb-0">YUSAR</h4>
                        <p class="subtitle">Moda con equilibrio</p>
                    </div>

                    <!-- Cuerpo del formulario -->
                    <div class="card-body">
                        <h5 class="form-title text-center mb-4">Registro de Usuario</h5>
                        
                        <!-- Formulario -->
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Columna izquierda -->
                                <div class="col-md-6">
                                    <!-- Nombre -->
                                    <div class="form-group mb-3">
                                        <label for="nombre">
                                            <i class="fas fa-user text-primary"></i> Nombre
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                                name="nombre" placeholder="Ingrese su nombre" value="{{ old('nombre') }}" required>
                                        </div>
                                        @error('nombre')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- CI -->
                                    <div class="form-group mb-3">
                                        <label for="ci">
                                            <i class="fas fa-id-card text-primary"></i> Cédula de Identidad
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            </div>
                                            <input id="ci" type="text" class="form-control @error('ci') is-invalid @enderror" 
                                                name="ci" placeholder="Ingrese su cédula" value="{{ old('ci') }}" required>
                                        </div>
                                        @error('ci')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Celular -->
                                    <div class="form-group mb-3">
                                        <label for="celular">
                                            <i class="fas fa-mobile-alt text-primary"></i> Celular
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                            </div>
                                            <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" 
                                                name="celular" placeholder="Ingrese su número de celular" value="{{ old('celular') }}" required>
                                        </div>
                                        @error('celular')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Columna derecha -->
                                <div class="col-md-6">
                                    <!-- Apellido -->
                                    <div class="form-group mb-3">
                                        <label for="apellido">
                                            <i class="fas fa-user-tag text-primary"></i> Apellido
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                            </div>
                                            <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" 
                                                name="apellido" placeholder="Ingrese su apellido" value="{{ old('apellido') }}" required>
                                        </div>
                                        @error('apellido')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Género -->
                                    <div class="form-group mb-3">
                                        <label for="genero">
                                            <i class="fas fa-venus-mars text-primary"></i> Género
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            </div>
                                            <select id="genero" class="form-control @error('genero') is-invalid @enderror" name="genero" required>
                                                <option value="" disabled selected>Seleccione su género</option>
                                                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                                <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            </select>
                                        </div>
                                        @error('genero')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Correo Electrónico -->
                                    <div class="form-group mb-3">
                                        <label for="correo_electronico">
                                            <i class="fas fa-envelope text-primary"></i> Correo Electrónico
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input id="correo_electronico" type="email" class="form-control @error('correo_electronico') is-invalid @enderror" 
                                                name="correo_electronico" placeholder="Ingrese su correo electrónico" value="{{ old('correo_electronico') }}" required>
                                        </div>
                                        @error('correo_electronico')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="form-group mb-3">
                                <label for="clave">
                                    <i class="fas fa-lock text-primary"></i> Contraseña
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input id="clave" type="password" class="form-control @error('clave') is-invalid @enderror" 
                                        name="clave" placeholder="Ingrese su contraseña" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('clave')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="form-group mb-3">
                                <label for="clave_confirmation">
                                    <i class="fas fa-key text-primary"></i> Confirmar Contraseña
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="clave_confirmation" type="password" class="form-control" 
                                        name="clave_confirmation" placeholder="Confirme su contraseña" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-confirm-password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Foto (opcional) -->
                            <div class="form-group mb-3">
                                <label for="foto">
                                    <i class="fas fa-camera text-primary"></i> Foto de Perfil (Opcional)
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-camera"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" id="foto" name="foto">
                                        <label class="custom-file-label" for="foto">Seleccionar archivo</label>
                                    </div>
                                </div>
                                @error('foto')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Botón de Registro -->
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-user-plus mr-2"></i> Crear Cuenta
                                </button>
                            </div>
                            
                            <!-- Enlace para iniciar sesión -->
                            <div class="text-center mt-3">
                                <span>¿Ya tiene una cuenta?</span>
                                <a href="{{ route('login') }}" class="login-link">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar sesión aquí
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Script para mostrar/ocultar contraseña -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle para contraseña
    document.querySelector('.toggle-password').addEventListener('click', function() {
        const password = document.querySelector('#clave');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    // Toggle para confirmar contraseña
    document.querySelector('.toggle-confirm-password').addEventListener('click', function() {
        const confirmPassword = document.querySelector('#clave_confirmation');
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });

    // Mostrar nombre del archivo seleccionado
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar archivo';
        const nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
});
</script>

<!-- Estilos mejorados -->
<style>
:root {
    --color-turquesa: #40B3B8;
    --color-turquesa-claro: #7FCED2;
    --color-turquesa-oscuro: #308F94;
    --color-naranja: #FF7F50;
    --color-naranja-claro: #FFAB8C;
    --color-naranja-oscuro: #E66C40;
    --color-texto: #333333;
    --color-borde: #E1E1E1;
    --color-fondo: #F8F9FA;
    --sombra-suave: 0 5px 15px rgba(0, 0, 0, 0.05);
    --sombra-media: 0 8px 20px rgba(0, 0, 0, 0.1);
    --transicion: all 0.3s ease;
}

body {
    font-family: 'Roboto', 'Segoe UI', sans-serif;
    color: var(--color-texto);
}

.login-background {
    background: linear-gradient(135deg, rgba(255, 127, 80, 0.2), rgba(64, 179, 184, 0.3)), 
                url('{{ asset('frontend/assets/img/logo/login.jpg') }}') no-repeat center center;
    background-size: cover;
    min-height: 100vh;
    padding: 40px 0;
    display: flex;
    align-items: center;
}

.login-card {
    border-radius: 15px;
    overflow: hidden;
    background-color: white;
    margin-bottom: 30px;
    box-shadow: var(--sombra-media);
    border: none;
}

.card-header {
    background: linear-gradient(135deg, var(--color-naranja), var(--color-turquesa));
    border: none;
    color: white;
    padding: 25px 15px;
}

.logo-img {
    max-height: 80px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

.subtitle {
    font-size: 14px;
    opacity: 0.9;
    letter-spacing: 0.5px;
}

.btn-back {
    background-color: white;
    color: var(--color-naranja);
    border-radius: 30px;
    padding: 8px 18px;
    font-weight: 500;
    box-shadow: var(--sombra-suave);
    transition: var(--transicion);
    border: none;
}

.btn-back:hover {
    background-color: var(--color-naranja-claro);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 127, 80, 0.3);
}

.form-title {
    font-weight: 600;
    color: var(--color-texto);
    position: relative;
    padding-bottom: 15px;
}

.form-title:after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: linear-gradient(to right, var(--color-naranja), var(--color-turquesa));
    margin: 10px auto 0;
    border-radius: 2px;
}

.card-body {
    padding: 30px;
}

label {
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 8px;
    color: var(--color-texto);
}

label i {
    color: var(--color-turquesa);
    margin-right: 6px;
}

.form-control {
    border-radius: 0 5px 5px 0;
    height: 45px;
    border-color: var(--color-borde);
    font-size: 15px;
}

.input-group-text {
    background-color: var(--color-fondo);
    color: var(--color-turquesa);
    border-color: var(--color-borde);
    border-right: none;
    border-radius: 5px 0 0 5px;
    width: 45px;
    height: 45px;
    justify-content: center;
}

.toggle-password,
.toggle-confirm-password {
    background-color: var(--color-fondo);
    color: var(--color-turquesa);
    border-color: var(--color-borde);
    border-left: none;
    cursor: pointer;
}

.form-control:focus {
    border-color: var(--color-turquesa);
    box-shadow: 0 0 0 0.2rem rgba(64, 179, 184, 0.25);
}

.input-group-prepend .input-group-text {
    border-right: none;
}

.input-group-append .input-group-text {
    border-left: none;
}

.btn-primary {
    background: linear-gradient(45deg, var(--color-turquesa), var(--color-turquesa-claro));
    border: none;
    border-radius: 30px;
    padding: 12px 20px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: var(--transicion);
    box-shadow: 0 4px 12px rgba(64, 179, 184, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(45deg, var(--color-naranja), var(--color-naranja-claro));
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(255, 127, 80, 0.4);
}

.btn-primary:active {
    transform: translateY(-1px);
}

a {
    color: var(--color-turquesa);
    font-weight: 500;
    transition: var(--transicion);
}

a:hover {
    color: var(--color-naranja);
    text-decoration: none;
}

.login-link {
    display: inline-block;
    margin-left: 5px;
    padding: 5px 10px;
    border-radius: 15px;
    transition: var(--transicion);
}

.login-link:hover {
    background-color: rgba(64, 179, 184, 0.1);
}

.custom-file-label {
    height: 45px;
    padding-top: 10px;
    border-radius: 0 5px 5px 0;
    border-color: var(--color-borde);
    border-left: none;
}

.custom-file-label::after {
    background-color: var(--color-turquesa);
    color: white;
    height: 43px;
    padding-top: 10px;
    border-radius: 0 4px 4px 0;
}

.invalid-feedback {
    font-size: 12px;
    margin-top: 5px;
}

/* Mejoras para dispositivos móviles */
@media (max-width: 768px) {
    .login-card {
        margin: 0 10px 30px;
    }
    
    .card-body {
        padding: 20px 15px;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
}

/* Animación al cargar el formulario */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-card {
    animation: fadeIn 0.6s ease-out;
}
</style>
@endsection