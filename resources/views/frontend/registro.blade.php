<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - YUSAR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .register-container {
            display: flex;
            width: 100%;
        }
        
        .register-image {
            flex: 1;
            background-image: url('https://images.unsplash.com/photo-1469334031218-e382a71b716b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .register-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }
        
        .register-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 80px;
            background-color: white;
            overflow-y: auto;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            font-size: 28px;
            color: #333;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .logo p {
            color: #777;
            font-size: 14px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        
        .form-group.full-width {
            grid-column: span 2;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
            font-weight: 500;
        }
        
        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            border-color: #a18aff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(161, 138, 255, 0.2);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 38px;
            cursor: pointer;
            color: #777;
        }
        
        .password-toggle:hover {
            color: #333;
        }
        
        .photo-upload {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .photo-preview {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #f0f0f0;
            overflow: hidden;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        
        .photo-preview i {
            color: #777;
            font-size: 20px;
        }
        
        .upload-btn {
            flex: 1;
        }
        
        .upload-btn input[type="file"] {
            display: none;
        }
        
        .upload-btn label {
            display: block;
            padding: 10px 15px;
            background-color: #f0f0f0;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            font-size: 13px;
            color: #555;
            transition: all 0.3s;
        }
        
        .upload-btn label:hover {
            background-color: #e0e0e0;
        }
        
        .terms {
            display: flex;
            align-items: center;
            margin: 20px 0;
            font-size: 13px;
        }
        
        .terms input {
            margin-right: 10px;
        }
        
        .terms a {
            color: #a18aff;
            text-decoration: none;
        }
        
        .register-button {
            width: 100%;
            padding: 12px;
            background-color: #7b5cff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .register-button:hover {
            background-color: #6a4bff;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        
        .login-link a {
            color: #7b5cff;
            text-decoration: none;
            font-weight: 500;
        }
        
        @media (max-width: 992px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-group.full-width {
                grid-column: span 1;
            }
        }
        
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            
            .register-image {
                height: 200px;
            }
            
            .register-form {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-image"></div>
        
        <div class="register-form">
            <div class="logo">
                <h1>YUSAR</h1>
                <p>Crea tu cuenta para comenzar</p>
            </div>
            
            <!-- Cambia el action y añade CSRF -->
            <form action="{{ route('cliente.registro.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <!-- Nombre -->
                    <div class="form-group">
                        <label for="nombre">Nombre*</label>
                        <input type="text" id="nombre" name="nombre" 
                               class="@error('nombre') is-invalid @enderror"
                               value="{{ old('nombre') }}" 
                               placeholder="Ej: Juan" required>
                        @error('nombre')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Apellido -->
                    <div class="form-group">
                        <label for="apellido">Apellido*</label>
                        <input type="text" id="apellido" name="apellido"
                               class="@error('apellido') is-invalid @enderror"
                               value="{{ old('apellido') }}"
                               placeholder="Ej: Pérez" required>
                        @error('apellido')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- CI/NIT -->
                    <div class="form-group">
                        <label for="ci_nit">CI/NIT*</label>
                        <input type="text" id="ci_nit" name="ci_nit"
                               class="@error('ci_nit') is-invalid @enderror"
                               value="{{ old('ci_nit') }}"
                               placeholder="Ej: 1234567" required>
                        @error('ci_nit')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Celular -->
                    <div class="form-group">
                        <label for="celular">Celular*</label>
                        <input type="tel" id="celular" name="celular"
                               class="@error('celular') is-invalid @enderror"
                               value="{{ old('celular') }}"
                               placeholder="Ej: 70012345" required>
                        @error('celular')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Género -->
                    <div class="form-group">
                        <label for="genero">Género*</label>
                        <select id="genero" name="genero"
                                class="@error('genero') is-invalid @enderror" required>
                            <option value="" disabled selected>Seleccione...</option>
                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Foto de perfil -->
                    <div class="form-group full-width">
                        <label>Foto de perfil</label>
                        <div class="photo-upload">
                            <div class="photo-preview">
                                <i class="fas fa-user"></i>
                                <img id="photoPreview" src="#" alt="Previsualización">
                            </div>
                            <div class="upload-btn">
                                <input type="file" id="foto" name="foto" accept="image/*">
                                <label for="foto">Subir imagen</label>
                            </div>
                        </div>
                        @error('foto')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Nombre de usuario -->
                    <div class="form-group">
                        <label for="nombre_usuario">Nombre de usuario*</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario"
                               class="@error('nombre_usuario') is-invalid @enderror"
                               value="{{ old('nombre_usuario') }}"
                               placeholder="Ej: juan123" required>
                        @error('nombre_usuario')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Correo electrónico -->
                    <div class="form-group">
                        <label for="correo">Correo electrónico*</label>
                        <input type="email" id="correo" name="correo"
                               class="@error('correo') is-invalid @enderror"
                               value="{{ old('correo') }}"
                               placeholder="Ej: juan@correo.com" required>
                        @error('correo')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Contraseña -->
                    <div class="form-group">
                        <label for="clave">Contraseña*</label>
                        <input type="password" id="clave" name="clave"
                               class="@error('clave') is-invalid @enderror"
                               placeholder="••••••••" required>
                        <i class="far fa-eye password-toggle" id="togglePassword"></i>
                        @error('clave')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Confirmar contraseña -->
                    <div class="form-group">
                        <label for="confirmar_clave">Confirmar contraseña*</label>
                        <input type="password" id="confirmar_clave" name="clave_confirmation"
                               class="@error('clave') is-invalid @enderror"
                               placeholder="••••••••" required>
                        <i class="far fa-eye password-toggle" id="toggleConfirmPassword"></i>
                    </div>
                </div>
                
                <!-- Términos y condiciones -->
                <div class="terms">
                    <input type="checkbox" id="terms" name="terms"
                           class="@error('terms') is-invalid @enderror"
                           {{ old('terms') ? 'checked' : '' }} required>
                    <label for="terms">Acepto los <a href="#">términos y condiciones</a> y la <a href="#">política de privacidad</a></label>
                    @error('terms')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="register-button">Registrarse</button>
                
                <div class="login-link">
                    ¿Ya tienes una cuenta? <a href="{{ route('cliente.login') }}">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle para mostrar/ocultar contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#clave');
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#confirmar_clave');
        
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        toggleConfirmPassword.addEventListener('click', function () {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        // Preview de la foto de perfil
        const photoInput = document.getElementById('foto');
        const photoPreview = document.getElementById('photoPreview');
        const photoIcon = document.querySelector('.photo-preview i');
        
        photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    photoPreview.src = this.result;
                    photoPreview.style.display = 'block';
                    photoIcon.style.display = 'none';
                });
                
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        // Agrega esto al final de tu script
const passwordInput = document.getElementById('clave');
const passwordStrength = document.createElement('div');
passwordStrength.className = 'password-strength';
passwordInput.parentNode.insertBefore(passwordStrength, passwordInput.nextSibling);

passwordInput.addEventListener('input', function() {
    const password = this.value;
    
    if (password.length === 0) {
        passwordStrength.style.display = 'none';
        return;
    }
    
    passwordStrength.style.display = 'block';
    
    // Hacer una petición AJAX para validar la contraseña
    fetch('{{ route("cliente.registro.submit") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            clave: password,
            _token: '{{ csrf_token() }}'
        })
    })
    .then(response => response.json())
    .then(data => {
        // Mostrar errores si los hay
        if (data.errors && data.errors.length > 0) {
            passwordStrength.innerHTML = '<div class="strength-errors">' + 
                data.errors.map(error => `<span>${error}</span>`).join('') + 
                '</div>';
            passwordStrength.className = 'password-strength weak';
        } else {
            // Mostrar fortaleza de la contraseña
            const strength = data.strength || 0;
            let strengthText = '';
            let strengthClass = '';
            
            if (strength <= 2) {
                strengthText = 'Débil';
                strengthClass = 'weak';
            } else if (strength <= 4) {
                strengthText = 'Moderada';
                strengthClass = 'moderate';
            } else {
                strengthText = 'Fuerte';
                strengthClass = 'strong';
            }
            
            passwordStrength.innerHTML = `
                <div class="strength-meter">
                    <div class="strength-bar" style="width: ${(strength / 6) * 100}%"></div>
                </div>
                <div class="strength-text">Seguridad: ${strengthText}</div>
            `;
            passwordStrength.className = `password-strength ${strengthClass}`;
        }
    });
});
    </script>
    <style></style>
</body>
</html>