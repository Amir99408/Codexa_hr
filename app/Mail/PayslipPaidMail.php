<?php

namespace App\Mail;

use App\Models\Payroll;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayslipPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Payroll $payroll) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Salary Credited — {$this->payroll->month_name}",
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.payslip-paid');
    }
}
