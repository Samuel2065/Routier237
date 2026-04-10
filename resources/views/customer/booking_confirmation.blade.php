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

    .payment-section {
        max-width: 760px;
        margin: 0 auto 1.5rem;
        padding: 1.2rem;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
    }

    .payment-title {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }

    .payment-subtitle {
        color: #64748b;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
        margin-bottom: 1rem;
    }

    .payment-card {
        position: relative;
        border: 2px solid transparent;
        border-radius: 14px;
        background: #f8fafc;
        padding: 14px;
        cursor: pointer;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        min-height: 140px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .payment-card img {
        width: 140px;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 8px 16px rgba(15, 23, 42, 0.12);
    }

    .payment-card span {
        font-weight: 700;
        color: #1e293b;
    }

    .payment-card.active {
        border-color: #f97316;
        box-shadow: 0 10px 25px rgba(249, 115, 22, 0.25);
        transform: translateY(-2px);
        background: #fff7ed;
    }

    .payment-amount {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        background: #0f172a;
        color: #fff;
        font-weight: 700;
        margin-bottom: 1rem;
        opacity: 0.2;
        transition: opacity 0.2s ease;
    }

    .payment-amount.active {
        opacity: 1;
    }

    .pay-btn {
        width: 100%;
        font-weight: 700;
        padding: 0.85rem 1.1rem;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .payment-modal {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        padding: 1rem;
    }

    .payment-modal.active {
        display: flex;
    }

    .payment-modal-card {
        background: #fff;
        border-radius: 18px;
        padding: 1.5rem 1.8rem;
        width: min(420px, 100%);
        text-align: center;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.25);
    }

    .loader {
        width: 56px;
        height: 56px;
        border: 5px solid #e2e8f0;
        border-top-color: #f97316;
        border-radius: 50%;
        animation: spin 0.9s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .ticket-wrap {
        margin-top: 1.5rem;
        padding: 0;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
        background: #fff;
    }

    .ticket-header {
        background: linear-gradient(120deg, #0f172a, #1e293b);
        color: #fff;
        padding: 1.2rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .ticket-header h5 {
        margin: 0;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .ticket-badge {
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .ticket-body {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        padding: 1.5rem;
    }

    .ticket-info {
        background: #f8fafc;
        border-radius: 12px;
        padding: 0.9rem 1rem;
        display: grid;
        gap: 0.2rem;
    }

    .ticket-info span {
        color: #64748b;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .ticket-info strong {
        color: #0f172a;
        font-size: 1.05rem;
    }

    .ticket-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem 1.5rem;
        border-top: 1px dashed #cbd5f5;
        flex-wrap: wrap;
    }

    .ticket-qr {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem;
        background: #fff;
        min-width: 120px;
        text-align: center;
        font-size: 0.75rem;
        color: #64748b;
    }

    .ticket-actions {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        #ticketArea, #ticketArea * {
            visibility: visible;
        }
        #ticketArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .ticket-actions {
            display: none;
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
    $paymentStatus = strtolower((string) ($reservation->payment_status ?? ''));
    $isPaid = $paymentStatus === 'paid';
    $sessionKey = 'reservation_verified_' . $reservation->id;
    $isOtpVerified = session($sessionKey, false) || $isPaid;
    $isVerified = $isPaid;
    $totalAmount = isset($reservation->total_amount) ? (float) $reservation->total_amount : 0;
    $amountFormatted = $totalAmount ? number_format($totalAmount, 0, ',', ' ') . ' XAF' : '-';
    $paymentMethodValue = $reservation->payment_method ?? session('last_payment_method');
    $paymentMethodLabel = $paymentMethodValue === 'om'
        ? 'Orange Money'
        : ($paymentMethodValue === 'momo'
            ? 'Mobile Money'
            : ($paymentMethodValue === 'card'
                ? 'Card'
                : ($paymentMethodValue === 'cash' ? 'Cash' : '-')
            ));
@endphp

<div class="content-card mb-3">
    <div class="text-center py-3">
        <h4 class="mb-1 {{ $isVerified ? 'text-success' : 'text-primary' }}">
            <i class="bi {{ $isVerified ? 'bi-check-circle-fill' : 'bi-shield-lock-fill' }}"></i>
            {{ $isVerified ? 'Booking Confirmed' : ($isOtpVerified ? 'Complete Payment' : 'Verify Booking') }}
        </h4>
        <p class="text-muted mb-0">
            {{ $isVerified ? 'Your booking is confirmed.' : ($isOtpVerified ? 'Select your payment method to finalize your ticket.' : 'Enter the code sent to your email inbox to confirm your booking.') }}
        </p>
    </div>

    @if(!$isOtpVerified)
        <form method="POST" action="{{ route('customer.book.confirmation.verify', ['reservation' => $reservation->id]) }}" class="mb-4" id="bookingOtpForm">
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
                    <i class="bi bi-check2-circle"></i> Continue to Payment
                </button>
            </div>

        </form>
    @endif

    @if($isOtpVerified && !$isVerified)
        <form method="POST" action="{{ route('customer.book.confirmation.verify', ['reservation' => $reservation->id]) }}" class="mb-4" id="bookingPaymentForm">
            @csrf
            <div class="payment-section">
                <div class="payment-title">Choose Payment Method</div>
                <div class="payment-subtitle">Select Orange Money or Mobile Money before we confirm your booking.</div>
                <div class="payment-options">
                    <label class="payment-card" data-method="om">
                        <input type="radio" name="payment_method" value="om" class="d-none">
                        <img src="{{ asset('images/payments/om.png') }}" alt="Orange Money">
                        <span>Orange Money</span>
                    </label>
                    <label class="payment-card" data-method="momo">
                        <input type="radio" name="payment_method" value="momo" class="d-none">
                        <img src="{{ asset('images/payments/momo.png') }}" alt="Mobile Money">
                        <span>Mobile Money</span>
                    </label>
                </div>
                <div class="payment-amount" id="paymentAmount" data-amount="{{ $amountFormatted }}">
                    <span>Amount to Pay</span>
                    <span id="amountValue">---</span>
                </div>
                <input type="hidden" name="payment_confirmed" id="payment_confirmed" value="">
                <button type="button" class="btn btn-warning pay-btn" id="payNowBtn" disabled>
                    <i class="bi bi-shield-check"></i> Pay Now
                </button>
                <div class="form-text text-center mt-2">Payment is simulated for this version.</div>
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
            <div><strong>Amount:</strong> {{ $isVerified ? $amountFormatted : 'Pending' }}</div>
            <div><strong>Payment Method:</strong> {{ $isVerified ? $paymentMethodLabel : '-' }}</div>
            <div><strong>Reserved At:</strong> {{ optional($reservation->reservation_date ?? $reservation->created_at)->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    @if($isVerified)
        <div class="ticket-wrap" id="ticketArea">
            <div class="ticket-header">
                <div>
                    <h5>Trip Booking Confirmation Ticket</h5>
                    <div class="text-white-50">Keep this ticket for your journey.</div>
                </div>
                <div class="ticket-badge">Confirmed</div>
            </div>
            <div class="ticket-body">
                <div class="ticket-info">
                    <span>Passenger</span>
                    <strong>{{ $reservation->client->full_name ?? Auth::user()->full_name ?? 'Customer' }}</strong>
                </div>
                <div class="ticket-info">
                    <span>Ticket Number</span>
                    <strong>{{ $reservation->ticket_number ?? ('RSV-' . $reservation->id) }}</strong>
                </div>
                <div class="ticket-info">
                    <span>Route</span>
                    <strong>{{ $routeLabel }}</strong>
                </div>
                <div class="ticket-info">
                    <span>Travel Date</span>
                    <strong>{{ $travelDate }}</strong>
                </div>
                <div class="ticket-info">
                    <span>Departure</span>
                    <strong>{{ $departureTime }}</strong>
                </div>
                <div class="ticket-info">
                    <span>Seat</span>
                    <strong>{{ $reservation->seat_number ?? '-' }}</strong>
                </div>
                <div class="ticket-info">
                    <span>Amount Paid</span>
                    <strong>{{ $amountFormatted }}</strong>
                </div>
                <div class="ticket-info">
                    <span>Payment Method</span>
                    <strong>{{ $paymentMethodLabel }}</strong>
                </div>
            </div>
            <div class="ticket-footer">
                <div class="ticket-qr">
                    <div class="fw-bold text-dark mb-1">QR Code</div>
                    <div>{{ $reservation->ticket_number ?? ('RSV-' . $reservation->id) }}</div>
                </div>
                <div>
                    <div class="text-muted text-uppercase small">Agency</div>
                    <div class="fw-bold text-dark">{{ $agencyName }}</div>
                </div>
                <div class="ticket-actions">
                    <button type="button" class="btn btn-outline-primary" id="downloadTicketBtn">
                        <i class="bi bi-download"></i> Download PDF
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print Ticket
                    </button>
                </div>
            </div>
        </div>
    @endif

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
<div class="payment-modal" id="paymentModal">
    <div class="payment-modal-card">
        <div class="loader"></div>
        <h5 class="mb-2">Processing Payment</h5>
        <p class="text-muted mb-0">Please wait, we are confirming your payment.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hiddenInput = document.getElementById('confirmation_code');
        const boxes = Array.from(document.querySelectorAll('.otp-box'));
        const paymentCards = Array.from(document.querySelectorAll('.payment-card'));
        const payNowBtn = document.getElementById('payNowBtn');
        const paymentAmount = document.getElementById('paymentAmount');
        const paymentModal = document.getElementById('paymentModal');
        const paymentConfirmed = document.getElementById('payment_confirmed');
        const paymentForm = document.getElementById('bookingPaymentForm');
        const downloadBtn = document.getElementById('downloadTicketBtn');
        const ticketArea = document.getElementById('ticketArea');
        const amountValue = document.getElementById('amountValue');
        const otpForm = document.getElementById('bookingOtpForm');

        if (hiddenInput && boxes.length > 0) {
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

            if (otpForm) {
                otpForm.addEventListener('submit', function () {
                    syncHiddenInput();
                });
            }
        }

        if (paymentCards.length > 0 && payNowBtn && paymentAmount) {
            paymentCards.forEach((card) => {
                card.addEventListener('click', () => {
                    paymentCards.forEach((item) => item.classList.remove('active'));
                    card.classList.add('active');
                    const input = card.querySelector('input[type="radio"]');
                    if (input) {
                        input.checked = true;
                    }
                    if (amountValue && paymentAmount.dataset.amount) {
                        amountValue.textContent = paymentAmount.dataset.amount;
                    }
                    paymentAmount.classList.add('active');
                    payNowBtn.removeAttribute('disabled');
                });
            });
        }

        if (payNowBtn && paymentModal && paymentConfirmed && paymentForm) {
            payNowBtn.addEventListener('click', () => {
                const selected = paymentForm.querySelector('input[name="payment_method"]:checked');
                if (!selected) {
                    return;
                }
                paymentModal.classList.add('active');
                setTimeout(() => {
                    paymentConfirmed.value = '1';
                    paymentForm.submit();
                }, 1800);
            });
        }

        if (downloadBtn && ticketArea && window.jspdf && window.jspdf.jsPDF) {
            downloadBtn.addEventListener('click', async () => {
                downloadBtn.setAttribute('disabled', 'disabled');
                const canvas = await html2canvas(ticketArea, { scale: 2 });
                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF({
                    orientation: 'portrait',
                    unit: 'pt',
                    format: 'a4'
                });
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = pageWidth - 48;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                const yPos = Math.max(24, (pageHeight - imgHeight) / 2);
                pdf.addImage(imgData, 'PNG', 24, yPos, imgWidth, imgHeight);
                pdf.save('trip-ticket.pdf');
                downloadBtn.removeAttribute('disabled');
            });
        }
    });
</script>
@endsection
