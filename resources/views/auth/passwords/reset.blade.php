@extends('website.layouts.main')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card auth-card">
                    <div class="card-header text-white text-center">
                        <h4 class="mb-0">
                            <i class="fas fa-lock me-2"></i>
                            Restablecer Contraseña
                        </h4>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <p class="text-muted mb-4 text-center">
                            Ingresa tu nueva contraseña para restablecer tu cuenta.
                        </p>

                        <form method="POST" action="{{ route('password.update') }}" id="passwordUpdateForm" class="auth-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Correo Electrónico
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ $email ?? old('email') }}" 
                                       placeholder="tu@email.com"
                                       readonly>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>
                                    Nueva Contraseña
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Mínimo 8 caracteres"
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        La contraseña debe tener al menos 8 caracteres
                                    </small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-2"></i>
                                    Confirmar Nueva Contraseña
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Repite tu nueva contraseña"
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                        <i class="fas fa-eye" id="eyeIconConfirmation"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-sm" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>
                                    Restablecer Contraseña
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>
                                Volver al inicio de sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('passwordUpdateForm');
    const submitBtn = document.getElementById('submitBtn');
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordField = document.getElementById('password');
    const passwordConfirmationField = document.getElementById('password_confirmation');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');

    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });

    togglePasswordConfirmation.addEventListener('click', function() {
        const type = passwordConfirmationField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmationField.setAttribute('type', type);
        eyeIconConfirmation.classList.toggle('fa-eye');
        eyeIconConfirmation.classList.toggle('fa-eye-slash');
    });

    // Password strength indicator
    passwordField.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        updatePasswordStrengthIndicator(strength);
    });

    function calculatePasswordStrength(password) {
        let score = 0;
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        return score;
    }

    function updatePasswordStrengthIndicator(strength) {
        const feedback = passwordField.parentNode.nextElementSibling;
        let strengthText = '';
        let strengthClass = '';

        switch(strength) {
            case 0:
            case 1:
                strengthText = 'Muy débil';
                strengthClass = 'text-danger';
                break;
            case 2:
                strengthText = 'Débil';
                strengthClass = 'text-warning';
                break;
            case 3:
                strengthText = 'Media';
                strengthClass = 'text-info';
                break;
            case 4:
                strengthText = 'Fuerte';
                strengthClass = 'text-primary';
                break;
            case 5:
                strengthText = 'Muy fuerte';
                strengthClass = 'text-success';
                break;
        }

        feedback.innerHTML = `
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                La contraseña debe tener al menos 8 caracteres
                <span class="ms-2 ${strengthClass}">(${strengthText})</span>
            </small>
        `;
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar que las contraseñas coincidan
        if (passwordField.value !== passwordConfirmationField.value) {
            Swal.fire({
                icon: 'error',
                title: 'Error de Validación',
                text: 'Las contraseñas no coinciden. Por favor, verifica que ambas sean iguales.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#dc3545',
                background: '#fff',
                backdrop: 'rgba(0,0,0,0.4)'
            });
            return;
        }

        // Deshabilitar botón y mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
        
        // Enviar formulario
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Contraseña Actualizada!',
                    text: data.message || 'Tu contraseña ha sido restablecida exitosamente.',
                    confirmButtonText: 'Iniciar Sesión',
                    confirmButtonColor: '#28a745',
                    allowOutsideClick: false,
                    background: '#fff',
                    backdrop: 'rgba(0,0,0,0.4)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
            } else {
                // Mostrar errores
                let errorMessage = 'Ha ocurrido un error.';
                if (data.errors) {
                    if (data.errors.email) {
                        errorMessage = data.errors.email[0];
                    } else if (data.errors.password) {
                        errorMessage = data.errors.password[0];
                    } else if (data.errors.token) {
                        errorMessage = data.errors.token[0];
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#dc3545',
                    background: '#fff',
                    backdrop: 'rgba(0,0,0,0.4)'
                });
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            console.error('Error message:', error.message);
            console.error('Error stack:', error.stack);
            
            Swal.fire({
                icon: 'error',
                title: 'Error de Conexión',
                text: 'No se pudo conectar con el servidor. Por favor, inténtalo de nuevo. Error: ' + error.message,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#dc3545',
                background: '#fff',
                backdrop: 'rgba(0,0,0,0.4)'
            });
        })
        .finally(() => {
            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Restablecer Contraseña';
        });
    });
});
</script>
<style>
/* Estilos personalizados para la vista de reset de contraseña */
.auth-container {
    background-color: #ffffff;
    min-height: 100vh;
    padding-top: 120px; /* Espacio para evitar que se solape con el header */
}

.auth-card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px 12px 0 0;
    padding: 25px 20px;
}

.card-header h4 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}

.card-body {
    padding: 30px;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #e9ecef;
    border-radius: 0 8px 8px 0;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #adb5bd;
    color: #495057;
}

.alert {
    border-radius: 8px;
    border: none;
    padding: 15px 20px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.form-text {
    margin-top: 8px;
}

.text-decoration-none {
    color: #667eea;
    font-weight: 500;
    transition: color 0.3s ease;
}

.text-decoration-none:hover {
    color: #5a6fd8;
    text-decoration: underline !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .auth-container {
        padding-top: 100px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .card-header {
        padding: 20px 15px;
    }
}

@media (max-width: 576px) {
    .auth-container {
        padding-top: 80px;
    }
    
    .col-md-6.col-lg-5 {
        padding: 0 15px;
    }
}
</style>

@endsection
