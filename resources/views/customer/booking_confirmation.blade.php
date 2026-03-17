@extends('customer.layout')
@section('title', 'Booking Confirmation')
@section('page_title', 'Booking Confirmation')
@section('content')
<style>
    .otp-panel {
        max-width: 560px;
        margin: 0 auto 1.25rem;
        padding: 1.1rem 1rem 1.25rem;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        background: #f8fbff;
    }

    .otp-title {
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 0.35rem;
    }

    .otp-subtitle {
        color: #64748b;
        font-size: 0.92rem;
        margin-bottom: 0.9rem;
    }

    .otp-inputs {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        margin-bottom: 0.9rem;
    }

    .otp-box {
        width: 44px;
        height: 50px;
        border: 2px solid #bfdbfe;
        border-radius: 10px;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e3a8a;
        background: #fff;
        text-transform: uppercase;
    }

    .otp-box:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.16);
    }

    .otp-divider {
        color: #60a5fa;
        font-weight: 700;
        margin: 0 2px;
        user-select: none;
    }

    @media (max-width: 576px) {
        .otp-box {
            width: 38px;
            height: 46px;
            font-size: 1.1rem;
        }

        .otp-inputs {
            gap: 6px;
        }
    }
</style>
@php
    $trip = $reservation->trip;
    $agencyName = data_get($trip, 'departureAgency.company.name')
        ?? data_get($trip, 'departureAgency.name')
        ?? 'N/A';
    $routeLabel = data_get($trip, 'route.fromCity.name', '-') . ' - ' . data_get($trip, 'route.toCity.name', '-');
    $travelDate = optional(data_get($trip, 'travel_date'))->format('Y-m-d') ?? ($reservation->departure_date ?? '-');
    $departureTime = data_get($trip, 'departure_time')
        ? \Carbon\Carbon::createFromFormat('H:i:s', data_get($trip, 'departure_time'))->format('H:i')
        : '-';
    $isVerified = in_array(strtolower((string) ($reservation->status ?? '')), ['confirmed', 'valid'], true);
@endphp

<div class="content-card mb-3">
    <div class="text-center py-3">
        <h4 class="mb-1 {{ $isVerified ? 'text-success' : 'text-primary' }}">
            <i class="bi {{ $isVerified ? 'bi-check-circle-fill' : 'bi-shield-lock-fill' }}"></i>
            {{ $isVerified ? 'Booking Confirmed' : 'Verify Booking' }}
        </h4>
        <p class="text-muted mb-0">
            {{ $isVerified ? 'Your booking is confirmed.' : 'Enter the code sent to your email inbox to confirm your booking.' }}
        </p>
    </div>

    @if(!$isVerified)
        <form method="POST" action="{{ route('customer.book.confirmation.verify', ['reservation' => $reservation->id]) }}" class="mb-4">
            @csrf
            <div class="otp-panel">
                <div class="text-center otp-title">Booking Verification Code</div>
                <div class="text-center otp-subtitle">Enter the 8-character code sent to your Gmail inbox.</div>
                <div class="otp-inputs" id="otpInputs">
                    @for($i = 0; $i < 8; $i++)
                        @if($i === 4)
                            <span class="otp-divider">-</span>
                        @endif
                        <input
                            type="text"
                            inputmode="text"
                            maxlength="1"
                            class="otp-box"
                            data-otp-index="{{ $i }}"
                            autocomplete="one-time-code"
                            required
                        >
                    @endfor
                </div>
                <input type="hidden" name="confirmation_code" id="confirmation_code" value="{{ old('confirmation_code') }}">
                <div class="form-text text-center">Example: A1B2-C3D4</div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle"></i> Confirm Booking
                </button>
            </div>
        </form>
    @endif

    <div class="row g-3">
        <div class="col-md-6">
            <div><strong>Ticket Number:</strong> {{ $reservation->ticket_number ?? ('RSV-' . $reservation->id) }}</div>
            <div><strong>Agency:</strong> {{ $agencyName }}</div>
            <div><strong>Route:</strong> {{ $routeLabel }}</div>
            <div><strong>Date:</strong> {{ $travelDate }}</div>
            <div><strong>Departure:</strong> {{ $departureTime }}</div>
        </div>
        <div class="col-md-6">
            <div><strong>Seat:</strong> {{ $reservation->seat_number ?? '-' }}</div>
            <div><strong>Status:</strong> {{ ucfirst($reservation->status ?? 'pending') }}</div>
            <div><strong>Amount:</strong> {{ isset($reservation->total_amount) ? number_format((float) $reservation->total_amount, 0, ',', ' ') . ' XAF' : '-' }}</div>
            <div><strong>Reserved At:</strong> {{ optional($reservation->reservation_date ?? $reservation->created_at)->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    <hr class="my-4">

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('customer.reservations') }}" class="btn btn-primary">
            <i class="bi bi-ticket-perforated"></i> View My Reservations
        </a>
        @if(!$isVerified)
            <a href="{{ route('customer.book.confirmation', ['reservation' => $reservation->id]) }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-clockwise"></i> I Have a New Code
            </a>
        @endif
        <a href="{{ route('customer.book') }}" class="btn btn-outline-secondary">
            <i class="bi bi-plus-circle"></i> Book Another Trip
        </a>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hiddenInput = document.getElementById('confirmation_code');
        const boxes = Array.from(document.querySelectorAll('.otp-box'));
        if (!hiddenInput || boxes.length === 0) return;

        const sanitize = (value) => (value || '')
            .replace(/[^a-zA-Z0-9]/g, '')
            .toUpperCase()
            .slice(0, boxes.length);

        const syncHiddenInput = () => {
            hiddenInput.value = boxes.map((box) => box.value.toUpperCase()).join('');
        };

        const fillFromValue = (value) => {
            const cleaned = sanitize(value);
            boxes.forEach((box, index) => {
                box.value = cleaned[index] || '';
            });
            syncHiddenInput();
        };

        fillFromValue(hiddenInput.value);

        boxes.forEach((box, index) => {
            box.addEventListener('input', (event) => {
                const char = sanitize(event.target.value);
                event.target.value = char ? char[char.length - 1] : '';
                syncHiddenInput();
                if (event.target.value && index < boxes.length - 1) {
                    boxes[index + 1].focus();
                }
            });

            box.addEventListener('keydown', (event) => {
                if (event.key === 'Backspace' && !box.value && index > 0) {
                    boxes[index - 1].focus();
                }
            });

            box.addEventListener('paste', (event) => {
                event.preventDefault();
                const pasted = sanitize((event.clipboardData || window.clipboardData).getData('text'));
                if (!pasted) return;
                fillFromValue(pasted);
                const nextIndex = Math.min(pasted.length, boxes.length - 1);
                boxes[nextIndex].focus();
            });
        });

        const form = hiddenInput.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                syncHiddenInput();
            });
        }
    });
</script>
@endsection
