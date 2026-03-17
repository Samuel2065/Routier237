<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingVerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $verificationData
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Verification Code - ' . ($this->verificationData['confirmation_code'] ?? '')
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-verification-code'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
