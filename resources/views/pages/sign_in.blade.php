@extends('layouts.app')

@section('title', 'Sign In')
@section('content')

<style>
    .signin-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        max-width: 480px;
        width: 100%;
    }

    .logo {
        color: white;
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
        font-style: italic;
        letter-spacing: 1px;
    }

    .form-floating {
        margin-bottom: 1.25rem;
    } 

    .form-control {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        padding: 1.1rem 0.75rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafbfc;
    }

    .form-control:focus {   
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
        background: white;
    }

    .form-floating label {
        padding: 1.1rem 0.75rem;
        color: #6c757d;
    }

    form {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .form-floating .form-control {
        height: calc(3.5rem + 2px);
        line-height: 1.25;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        transform: scale(0.85) translateY(-1rem);
        background-color: white;
        padding: 0 0.5rem;
        height: auto;
    }

    .btn-primary {
        width: 100%;
        margin-top: 1rem;
        border: none;
        padding: 1rem;
        font-weight: 600;
        color: white !important;
    }

    .btn-primary span {
        color: white !important;
    }

    .loading {
        display: none;
    }

    .btn-signin.loading .loading {
        display: inline-block !important;
    }

    .btn-signin.loading .spinner-border {
        display: inline-block;
    }

    .btn-signin.loading .btn-text {
        display: none;
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: #dc3545;
        margin-top: 0.5rem;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-valid {
        border-color: #198754;
    }

    .alert {
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: none;
        padding: 1rem;
    }
    
    .alert-danger {
        background: #fff5f5;
        color: #dc3545;
        border-left: 4px solid #dc3545;
    }
    
    .alert-success {
        background: #f0f9ff;
        color: #059669;
        border-left: 4px solid #059669;
    }

    .alert ul {
        margin-bottom: 0;
        padding-left: 1.2rem;
    }
</style>

<body>
    <div class="signin-container" style="margin-top: 120px;">
        <div class="signin-card" style="max-width: 450px; margin: auto; margin-bottom: 30px;">
            <div class="text-center mb-3">
                <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="YourTrip" style="height: 48px;"> -->
                <span style="font-size: 1.3rem; font-weight: 500; color: #2563eb; margin-left: 8px; vertical-align: middle;">Routier+237</span>
            </div>

            <h2 class="text-center" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem;">Welcome back</h2>
            <p class="text-center mb-3" style="color: #444;">Sign in to plan your next adventure</p>

            <!-- Display Success Messages -->
            @if(session('success'))
                <div class="alert alert-success" role="alert" style="margin: 0 1.5rem 1rem;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display General Error Messages -->
            @if($errors->has('sign_in'))
                <div class="alert alert-danger" role="alert" style="margin: 0 1.5rem 1rem;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $errors->first('sign_in') }}
                </div>
            @endif

            @if($errors->has('sign_up'))
                <div class="alert alert-danger" role="alert" style="margin: 0 1.5rem 1rem;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $errors->first('sign_up') }}
                </div>
            @endif

            <!-- Display All Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert" style="margin: 0 1.5rem 1rem;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <ul class="mb-0" style="padding-left: 1.2rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Laravel Blade Form -->
            <form method="POST" action="{{ route('sign_in') }}" novalidate id="signinForm">
                @csrf
                
                <div class="mb-2">
                    <label for="email" class="form-label">Email address *</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="votre@email.com" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-2">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password"
                           placeholder="Password" 
                           required>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size: 0.9rem; color: #6c757d;">
                            Remember me
                        </label>
                    </div>
                    <a href="#" style="font-size: 0.9rem; color: #2563eb; text-decoration: none; margin-left: 125px;">Forgot password?</a>
                </div>
                
                <button class="btn btn-primary w-100" type="submit" id="submitBtn" style="height: 48px; font-weight: 600; font-size: 1.05rem; border-radius: 8px; justify-content: center; background: #2563eb; color: white !important;" >
                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="loadingSpinner"></span>
                    <span id="btnText" style="color: white !important;">Sign In</span>
                </button>
            </form>
            
            <div class="text-center" style="font-size: 0.98rem; margin-bottom: 15px;">
                New to Routier+237? <a href="{{ route('sign_up') }}" style="color: #2563eb; font-weight: 500; text-decoration: underline;">Create an account</a>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; justify-content: center; align-items: center;">
        <div class="text-center">
            <div class="spinner-border text-white" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-3 text-white">Signing you in...</div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signinForm');
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const btnText = document.getElementById('btnText');
            const loadingOverlay = document.getElementById('loadingOverlay');
            
            // Form submission handler
            form.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.disabled = true;
                loadingSpinner.classList.remove('d-none');
                btnText.textContent = 'Signing In...';
                loadingOverlay.style.display = 'flex';
                
                // Basic client-side validation
                const email = document.getElementById('email').value.trim();
                const password = document.getElementById('password').value;
                
                if (!email || !password) {
                    e.preventDefault();
                    resetButton();
                    alert('Please fill in all required fields.');
                    return false;
                }
                
                if (!isValidEmail(email)) {
                    e.preventDefault();
                    resetButton();
                    alert('Please enter a valid email address.');
                    return false;
                }
            });
            
            // Reset button state
            function resetButton() {
                submitBtn.disabled = false;
                loadingSpinner.classList.add('d-none');
                btnText.textContent = 'Sign In';
                loadingOverlay.style.display = 'none';
            }
            
            // Email validation helper
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            // Auto-hide success/error messages after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
            
            // Real-time validation feedback
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            emailInput.addEventListener('blur', function() {
                validateEmailField(this);
            });
            
            passwordInput.addEventListener('blur', function() {
                validatePasswordField(this);
            });
            
            function validateEmailField(input) {
                const email = input.value.trim();
                if (email && !isValidEmail(email)) {
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else if (email) {
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                } else {
                    input.classList.remove('is-valid', 'is-invalid');
                }
            }
            
            function validatePasswordField(input) {
                const password = input.value;
                if (password && password.length < 6) {
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else if (password) {
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                } else {
                    input.classList.remove('is-valid', 'is-invalid');
                }
            }
        });
    </script>

@endsection