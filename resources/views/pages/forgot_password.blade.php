@extends('layouts.app')

@section('title', 'Forgot Password')
@section('content')
<style>
    .auth-wrap {
        margin-top: 120px;
        margin-bottom: 30px;
    }

    .auth-card {
        max-width: 450px;
        margin: auto;
        padding: 28px 24px 20px;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
    }

    .auth-illustration {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        margin: 6px auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        color: #1d4ed8;
        background: radial-gradient(circle at 30% 30%, #e0f2fe, #dbeafe 60%, #bfdbfe);
    }

    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .auth-subtitle {
        text-align: center;
        color: #4b5563;
        margin-bottom: 1.25rem;
        line-height: 1.5;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 0.9rem 0.75rem;
        background: #f9fafb;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.2);
        border-color: #2563eb;
        background: #fff;
    }

    .btn-auth {
        width: 100%;
        border: none;
        border-radius: 10px;
        padding: 0.82rem 1rem;
        color: #fff;
        font-weight: 600;
        background: linear-gradient(90deg, #0ea5e9, #2563eb);
    }

    .btn-auth:hover {
        color: #fff;
        filter: brightness(0.98);
    }

    .hint-link {
        display: inline-block;
        margin-top: 14px;
        color: #2563eb;
        text-decoration: underline;
    }

    .alert {
        border-radius: 10px;
        border: 0;
    }
</style>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="text-center mb-3">
            <span style="font-size: 1.3rem; font-weight: 500; color: #2563eb;">Routier+237</span>
        </div>

        <div class="auth-illustration">
            <i class="fa-solid fa-envelope-open-text"></i>
        </div>

        <h2 class="auth-title">Email Verification Code</h2>
        <p class="auth-subtitle">
            Please enter your account email. We will send you a password reset link.
        </p>

        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address *</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="your@email.com"
                    required
                >
            </div>
            <button type="submit" class="btn btn-auth">Verify Code</button>
        </form>

        <div class="text-center">
            <a href="{{ route('sign_in') }}" class="hint-link">Back to Sign In</a>
        </div>
    </div>
</div>
@endsection
