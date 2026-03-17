<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $bookingData
    ) {
    }

    public function envelope(): Envelope
    {
        $code = $this->bookingData['confirmation_code'] ?? null;
        $subjectSuffix = $code ? (' - ' . $code) : '';

        return new Envelope(
            subject: 'Trip Booking Confirmation' . $subjectSuffix
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-confirmation'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
