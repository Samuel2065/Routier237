@extends('layouts.app')

@section('title', 'Sign Up')
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

    .active {
        background-color: #2563eb !important;
        color: white !important;
        border-color: #2563eb !important;
    }

    /* Styles for dynamic fields */
    .field-transition {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .agency-fields {
        max-height: 0;
        opacity: 0;
        pointer-events: none;
    }

    .agency-fields.show {
        max-height: 2000px;
        opacity: 1;
        pointer-events: all;
    }

    .passenger-fields {
        max-height: 2000px;
        opacity: 1;
        pointer-events: all;
    }

    .passenger-fields.hide {
        max-height: 0;
        opacity: 0;
        pointer-events: none;
    }
</style>


<body>
    <div class="signin-container" style="margin-top: 120px;">
            <div class="signin-card" style="max-width: 450px; margin: auto; margin-bottom: 30px;">
                <div class="text-center mb-3">
                <!-- <img src="{{ asset('assets/images/logo.png') }}" alt="YourTrip" style="height: 48px;"> -->
                <span style="font-size: 1.3rem; font-weight: 500; color: #2563eb; margin-left: 8px; vertical-align: middle;">Routier+237</span>
            </div>

            <h2 class="text-center" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem;">Create your account</h2>
            <p class="text-center mb-3" style="color: #444;">Join cameroon transport community</p>

            <!-- Laravel Blade Form -->
            <form method="POST" action="{{ route('sign_up') }}" novalidate id="signupForm">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-flex justify-content-center mb-3 gap-2">
                    <button type="button" class="btn btn-outline-primary active" name="role" style="width: 42%; font-weight: 500;" id="role-voyageur">
                        <i class="bi bi-person"></i> Passenger
                    </button>
                    <button type="button" class="btn btn-outline-primary" name="role" style="width: 42%; font-weight: 500;" id="role-agence">
                        <i class="bi bi-building"></i> Agency
                    </button>
                </div>
                
                <!-- Hidden field to store user type -->
                <input type="hidden" name="user_type" id="user_type" value="passenger">

                <!-- Passenger Fields -->
                <div class="passenger-fields field-transition" id="passengerFields">
                    <div class="mb-2">
                        <label for="name" class="form-label">Full name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Entrez votre nom complet" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Agency Fields -->
                <div class="agency-fields field-transition" id="agencyFields">
                    <div class="mb-2">
                        <label for="agency_name" class="form-label">Agency name *</label>
                        <input type="text" class="form-control @error('agency_name') is-invalid @enderror" id="agency_name" name="agency_name" placeholder="Travel Agency Inc." value="{{ old('agency_name') }}" disabled>
                        @error('agency_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="business_license" class="form-label">Business license number *</label>
                        <input type="text" class="form-control @error('business_license') is-invalid @enderror" id="business_license" name="business_license" placeholder="BL-123456789" value="{{ old('business_license') }}" disabled>
                        @error('business_license')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="address" class="form-label">Business address *</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="123 Business St, Yaoundé" value="{{ old('address') }}" disabled>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="tax_id" class="form-label">Tax ID *</label>
                        <input type="text" class="form-control @error('tax_id') is-invalid @enderror" id="tax_id" name="tax_id" placeholder="XX-XXXXXXX" value="{{ old('tax_id') }}" disabled>
                        @error('tax_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="contact_person" class="form-label">Contact person *</label>
                        <input type="text" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" name="contact_person" placeholder="Manager Name" value="{{ old('contact_person') }}" disabled>
                        @error('contact_person')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Common Fields -->
                <div class="mb-2">
                    <label for="email" class="form-label">Email addresse*</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="votre@email.com" required value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="phone" class="form-label">Telephone number *</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="6XX XXX XXX" required value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="password_confirmation" class="form-label">Confirm password *</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirme password" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary w-100" type="submit" style="height: 48px; font-weight: 600; font-size: 1.05rem; border-radius: 8px; justify-content: center; background: #2563eb;">Create an account</button>
            </form>
            <div class="text-center" style="font-size: 0.98rem; margin-bottom: 15px;">
                Already have an account ? <a href="{{ route('sign_in') }}" style="color: #2563eb; font-weight: 500; text-decoration: underline;">Sign in here</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get elements
        const roleVoyageur = document.getElementById('role-voyageur');
        const roleAgence = document.getElementById('role-agence');
        const userTypeInput = document.getElementById('user_type');
        const passengerFields = document.getElementById('passengerFields');
        const agencyFields = document.getElementById('agencyFields');

        // Get all inputs
        const nameInput = document.getElementById('name');
        const agencyNameInput = document.getElementById('agency_name');
        const businessLicenseInput = document.getElementById('business_license');
        const addressInput = document.getElementById('address');
        const taxIdInput = document.getElementById('tax_id');
        const contactPersonInput = document.getElementById('contact_person');

        // Function to switch to passenger mode
        function switchToPassenger() {
            roleVoyageur.classList.add('active');
            roleAgence.classList.remove('active');
            userTypeInput.value = 'passenger';
            
            // Show passenger fields
            passengerFields.classList.remove('hide');
            agencyFields.classList.remove('show');
            
            // Enable/disable and set required attributes for passenger
            nameInput.disabled = false;
            nameInput.required = true;
            
            // Disable and remove required for agency fields
            agencyNameInput.disabled = true;
            agencyNameInput.required = false;
            businessLicenseInput.disabled = true;
            businessLicenseInput.required = false;
            addressInput.disabled = true;
            addressInput.required = false;
            taxIdInput.disabled = true;
            taxIdInput.required = false;
            contactPersonInput.disabled = true;
            contactPersonInput.required = false;
        }

        // Function to switch to agency mode
        function switchToAgency() {
            roleAgence.classList.add('active');
            roleVoyageur.classList.remove('active');
            userTypeInput.value = 'agency';
            
            // Show agency fields
            passengerFields.classList.add('hide');
            agencyFields.classList.add('show');
            
            // Disable and remove required for passenger field
            nameInput.disabled = true;
            nameInput.required = false;
            
            // Enable and set required for agency fields
            agencyNameInput.disabled = false;
            agencyNameInput.required = true;
            businessLicenseInput.disabled = false;
            businessLicenseInput.required = true;
            addressInput.disabled = false;
            addressInput.required = true;
            taxIdInput.disabled = false;
            taxIdInput.required = true;
            contactPersonInput.disabled = false;
            contactPersonInput.required = true;
        }

        // Event listeners
        roleVoyageur.addEventListener('click', switchToPassenger);
        roleAgence.addEventListener('click', switchToAgency);

        // Initialize based on old input (for validation errors)
        @if(old('user_type') === 'agency')
            switchToAgency();
        @else
            switchToPassenger();
        @endif
    </script>

@endsection