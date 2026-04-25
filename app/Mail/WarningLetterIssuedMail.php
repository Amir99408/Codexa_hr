<?php

namespace App\Mail;

use App\Models\WarningLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WarningLetterIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public WarningLetter $letter) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: "Warning Letter — {$this->letter->subject}");
    }

    public function content(): Content
    {
        return new Content(view: 'mail.warning-letter-issued');
    }
}
