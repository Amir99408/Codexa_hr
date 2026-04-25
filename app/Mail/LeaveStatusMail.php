<?php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Leave $leave) {}

    public function envelope(): Envelope
    {
        $status  = ucfirst($this->leave->status);
        $subject = "Leave Request {$status} — {$this->leave->leaveType?->name}";

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'mail.leave-status');
    }
}
