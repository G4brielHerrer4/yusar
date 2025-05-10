@extends('layouts.app')

@section('content')
<!-- Fondo de toda la vista -->
<div class="login-background">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Botón para regresar atrás -->
                <div class="mb-4 mt-4">
                    <a href="/" class="btn btn-back">
                        <i class="fas fa-arrow-left mr-2"></i> Regresar
                    </a>
                </div>
                
                <div class="login-card shadow-lg border-0">
                    <!-- Encabezado con logo -->
                    <div class="card-header text-center py-4">
                        <img src="{{ asset('frontend/assets/img/logo/logosolo.jpeg') }}" alt="YUSAR - Moda con equilibrio" class="mb-2 logo-img">
                        <h3 class="mt-2 mb-0 card-title">YUSAR</h3>
                        <p class="subtitle">Moda con equilibrio</p>
                    </div>

                    <!-- Cuerpo del formulario -->
                    <div class="card-body py-4">
                        <!-- Título del formulario -->
                        <h4 class="form-title text-center mb-4">Iniciar Sesión</h4>
                        
                        <!-- Formulario -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Campo: Correo Electrónico -->
                            <div class="form-group mb-4">
                                <label for="correo_electronico" class="form-label">
                                    <i class="fas fa-at fa-sm mr-1"></i> Correo Electrónico
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input id="correo_electronico" type="email" class="form-control @error('correo_electronico') is-invalid @enderror" 
                                           name="correo_electronico" placeholder="Ingrese su correo electrónico" value="{{ old('correo_electronico') }}" 
                                           required autocomplete="correo_electronico" autofocus>
                                </div>
                                @error('correo_electronico')
                                    <span class="invalid-feedback d-block mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Campo: Clave -->
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-key fa-sm mr-1"></i> Contraseña
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" placeholder="Ingrese su contraseña" required autocomplete="current-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Recordar Sesión y Olvidó Contraseña -->
                            <div class="form-group d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        <i class="fas fa-clock fa-sm mr-1"></i> Recordarme
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="forgot-link" href="{{ route('password.request') }}">
                                        <i class="fas fa-question-circle fa-sm mr-1"></i> ¿Olvidó su contraseña?
                                    </a>
                                @endif
                            </div>

                            <!-- Botón de Iniciar Sesión -->
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-login btn-block">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                                </button>
                            </div>
                            
                            <!-- Enlace para registrarse -->
                            <div class="text-center mt-4">
                                <span>¿No tiene una cuenta?</span>
                                <a href="{{ route('register') }}" class="register-link">
                                    <i class="fas fa-user-plus fa-sm mr-1"></i> Registrarse aquí
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Importar Font Awesome (CDN) - AÑADIR ESTO EN EL HEAD O EN TU ARCHIVO DE LAYOUT -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<!-- Script para mostrar/ocultar contraseña -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', function() {
        // Cambiar el tipo de input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Cambiar el icono
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
</script>

<!-- Estilos adicionales específicos -->
<style>
    /* Variables de colores corporativos */
    :root {
        --color-turquesa: #40B3B8;
        --color-turquesa-claro: #7FCED2;
        --color-naranja: #FF7F50;
        --color-naranja-claro: #FFAB8C;
        --color-negro: #333333;
        --color-gris: #777777;
        --color-blanco: #FFFFFF;
    }
    
    /* Estilos globales */
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Nunito', sans-serif;
    }
    
    #app, main {
        height: 100%;
    }
    
    /* Fondo de toda la página */
    .login-background {
        background: linear-gradient(135deg, rgba(255, 127, 80, 0.2), rgba(64, 179, 184, 0.3)), 
                    url('{{ asset('frontend/assets/img/logo/login.jpg') }}') no-repeat center center;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 40px 0;
        position: relative;
    }
    
    /* Efecto de partículas (opcional) */
    .login-background:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjZmZmIj48L3JlY3Q+CjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiNjY2MiPjwvcmVjdD4KPC9zdmc+');
        opacity: 0.03;
        pointer-events: none;
    }
    
    /* Estilo del card */
    .login-card {
        border-radius: 15px;
        overflow: hidden;
        background-color: var(--color-blanco);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(0);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2) !important;
    }
    
    /* Encabezado del card */
    .card-header {
        background: linear-gradient(135deg, var(--color-naranja), var(--color-turquesa));
        border: none;
        padding: 25px 15px;
        position: relative;
    }
    
    .card-header:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1NiIgaGVpZ2h0PSIxMDAiPgo8cGF0aCBkPSJNMjggNjZMMCA1MEwwIDE2TDI4IDBMNTYgMTZMNTYgNTBMMjggNjZMMjggMTAwIiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmYiIHN0cm9rZS1vcGFjaXR5PSIwLjA1IiBzdHJva2Utd2lkdGg9IjIiPjwvcGF0aD4KPHBhdGggZD0iTTI4IDBMMjggMzRMMAk1MEwyOCA2NkwyOCAxMDBMNTYgNTBMMjggMzQiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2ZmZiIgc3Ryb2tlLW9wYWNpdHk9IjAuMDUiIHN0cm9rZS13aWR0aD0iMiI+PC9wYXRoPgo8L3N2Zz4=');
        opacity: 0.1;
    }
    
    .logo-img {
        max-height: 80px;
        border-radius: 50%;
        border: 3px solid var(--color-blanco);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }
    
    .logo-img:hover {
        transform: scale(1.05);
    }
    
    .card-title {
        color: var(--color-blanco);
        font-weight: 700;
        letter-spacing: 2px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        margin-bottom: 0;
    }
    
    .subtitle {
        color: var(--color-blanco);
        font-size: 0.9rem;
        opacity: 0.9;
        margin-top: 5px;
    }
    
    /* Cuerpo del card */
    .card-body {
        background-color: var(--color-blanco);
        padding: 30px 25px;
    }
    
    .form-title {
        color: var(--color-negro);
        font-weight: 600;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .form-title:after {
        content: '';
        position: absolute;
        display: block;
        width: 60px;
        height: 3px;
        background: linear-gradient(to right, var(--color-naranja), var(--color-turquesa));
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    
    /* Etiquetas de formulario */
    .form-label {
        color: var(--color-gris);
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    
    .form-label i {
        margin-right: 5px;
        color: var(--color-turquesa);
    }
    
    /* Campos de formulario */
    .input-group-text {
        background: linear-gradient(to right, var(--color-naranja), var(--color-naranja-claro));
        border: none;
        color: var(--color-blanco);
        width: 50px;
        height: 48px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .toggle-password .fa {
        color: var(--color-blanco);
    }
    
    .input-group-append .input-group-text {
        background: linear-gradient(to left, var(--color-turquesa), var(--color-turquesa-claro));
    }
    
    .form-control {
        height: 48px;
        border: 1px solid #eee;
        border-radius: 0 4px 4px 0;
        transition: all 0.3s;
        padding-left: 15px;
        font-size: 0.95rem;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
    }
    
    .form-control:focus {
        border-color: var(--color-turquesa);
        box-shadow: 0 0 0 0.2rem rgba(64, 179, 184, 0.25);
    }
    
    .form-control::placeholder {
        color: #bbb;
        font-size: 0.9rem;
    }
    
    /* Feedback en campos de entrada */
    .form-control:focus + .input-group-append .input-group-text,
    .input-group-prepend .input-group-text + .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(64, 179, 184, 0.25);
    }
    
    /* Botones */
    .btn-login {
        background: linear-gradient(45deg, var(--color-turquesa), var(--color-turquesa-claro));
        color: var(--color-blanco);
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        border-radius: 30px;
        letter-spacing: 1px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        z-index: 1;
        height: 48px;
        text-transform: uppercase;
        font-size: 0.95rem;
        box-shadow: 0 5px 15px rgba(64, 179, 184, 0.3);
    }
    
    .btn-login:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background: linear-gradient(45deg, var(--color-naranja-claro), var(--color-naranja));
        transition: all 0.5s ease;
        z-index: -1;
    }
    
    .btn-login:hover:before {
        width: 100%;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 15px rgba(255, 127, 80, 0.4);
    }
    
    .btn-login:active {
        transform: translateY(1px);
    }
    
    .btn-back {
        background-color: rgba(255, 255, 255, 0.9);
        color: var(--color-naranja);
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }
    
    .btn-back:hover {
        background-color: var(--color-blanco);
        transform: translateX(-5px);
        color: var(--color-turquesa);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    
    /* Enlaces */
    .forgot-link, .register-link {
        color: var(--color-turquesa);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        position: relative;
    }
    
    .forgot-link:after, .register-link:after {
        content: '';
        position: absolute;
        width: 0;
        height: 1px;
        bottom: -2px;
        left: 0;
        background-color: var(--color-naranja);
        transition: width 0.3s ease;
    }
    
    .forgot-link:hover:after, .register-link:hover:after {
        width: 100%;
    }
    
    .forgot-link:hover, .register-link:hover {
        color: var(--color-naranja);
        text-decoration: none;
    }
    
    /* Estilos para checkbox */
    .form-check-input {
        margin-top: 0.3rem;
        width: 18px;
        height: 18px;
        border-radius: 3px;
        cursor: pointer;
        accent-color: var(--color-turquesa);
    }
    
    .form-check-label {
        color: var(--color-gris);
        margin-left: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    
    .form-check-label i {
        color: var(--color-turquesa);
        margin-right: 5px;
    }
    
    /* Footer */
    .copyright {
        color: var(--color-blanco);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        font-size: 0.85rem;
    }
    
    .copyright-link {
        color: var(--color-blanco);
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .copyright-link:hover {
        color: var(--color-naranja-claro);
        text-decoration: none;
    }
    
    /* Mensaje de error */
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 5px;
        background-color: rgba(220, 53, 69, 0.05);
        padding: 5px 10px;
        border-radius: 4px;
        border-left: 2px solid #dc3545;
    }
    
    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .login-card {
        animation: fadeIn 0.6s ease-out;
    }
    
    @keyframes pulseButton {
        0% { box-shadow: 0 0 0 0 rgba(64, 179, 184, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(64, 179, 184, 0); }
        100% { box-shadow: 0 0 0 0 rgba(64, 179, 184, 0); }
    }
    
    .btn-login {
        animation: pulseButton 2s infinite;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .login-card {
            margin: 0 15px;
        }
        
        .logo-img {
            max-height: 60px;
        }
        
        .card-body {
            padding: 25px 15px;
        }
    }
    
    @media (max-width: 576px) {
        .btn-login {
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .forgot-link, .register-link {
            font-size: 0.85rem;
        }
    }
</style>
@endsection