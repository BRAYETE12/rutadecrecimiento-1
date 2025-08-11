@extends('website.layouts.main')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card auth-card">
                    <div class="card-header text-white text-center">
                        <h4 class="mb-0">
                            <i class="fas fa-key me-2"></i>
                            Recuperar Contraseña
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
                            Ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                        </p>

                        <form method="POST" action="{{ route('password.email') }}" id="passwordResetForm" class="auth-form">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Correo Electrónico
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="tu@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Enviar Enlace de Recuperación
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
    const form = document.getElementById('passwordResetForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Deshabilitar botón y mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
        
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
                    title: '¡Enlace Enviado!',
                    text: data.message || 'Hemos enviado un enlace de recuperación a tu correo electrónico.',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#28a745',
                    background: '#fff',
                    backdrop: 'rgba(0,0,0,0.4)'
                });
                
                // Limpiar formulario
                form.reset();
            } else {
                // Mostrar errores
                let errorMessage = 'Ha ocurrido un error.';
                if (data.errors && data.errors.email) {
                    errorMessage = data.errors.email[0];
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
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Enlace de Recuperación';
        });
    });
});
</script>
@endsection
