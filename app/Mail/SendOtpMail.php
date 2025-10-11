<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;


    public $otp;
    public $subjectText;

    public function __construct($otp, $subjectText)
    {
        $this->otp = $otp;
        $this->subjectText = $subjectText;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->markdown('emails.otp')
                    ->with(['otp' => $this->otp]);
    }
}
