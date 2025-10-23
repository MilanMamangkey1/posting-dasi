<?php

namespace App\Mail;

use App\Models\ConsultationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewConsultationRequestMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public ConsultationRequest $consultation)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Pengajuan Konsultasi Baru - Website Posting Dasi')
            ->view('emails.new_consultation_request');
    }
}
