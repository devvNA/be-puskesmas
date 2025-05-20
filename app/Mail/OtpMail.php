<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userName;
    public $otpType;
    public $expiresIn;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userName, $otp, $otpType = 'login', $expiresIn = 15)
    {
        $this->userName = $userName;
        $this->otp = $otp;
        $this->otpType = $otpType;
        $this->expiresIn = $expiresIn;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $subject = 'Kode OTP Puskesmas Kluwung';

        if ($this->otpType === 'register') {
            $subject = 'Kode OTP Pendaftaran Puskesmas Kluwung';
        } elseif ($this->otpType === 'reset_password') {
            $subject = 'Kode OTP Reset Password Puskesmas Kluwung';
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.otp',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
