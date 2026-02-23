@extends('layouts.app')

@section('title', 'Reset Password')
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
            <i class="fa-solid fa-lock"></i>
        </div>

        <h2 class="auth-title">Create New Password</h2>
        <p class="auth-subtitle">Please reset your new password.</p>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ old('email', $email) }}">

            <div class="mb-3">
                <label for="password" class="form-label">Password *</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter new password"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Confirm new password"
                    required
                >
            </div>

            <button type="submit" class="btn btn-auth">Update Password</button>
        </form>
    </div>
</div>
@endsection
