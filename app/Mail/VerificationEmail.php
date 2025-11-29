<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $userName;

    public function __construct($verificationCode, $userName = null)
    {
        $this->verificationCode = $verificationCode;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode Verifikasi Email - IslamIQ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verification',
            with: [
                'verificationCode' => $this->verificationCode,
                'userName' => $this->userName,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}