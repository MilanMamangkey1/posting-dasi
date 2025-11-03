<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreConsultationRequest;
use App\Mail\NewConsultationRequestMail;
use App\Models\ConsultationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Validation\ValidationException;

class ConsultationController extends Controller
{
    public function store(StoreConsultationRequest $request): RedirectResponse
    {
        // === VALIDASI reCAPTCHA SECARA MANUAL (karena Form Request tidak otomatis validasi NoCaptcha) ===
        $recaptchaResponse = $request->input('g-recaptcha-response');

        if (empty($recaptchaResponse)) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Silakan centang reCAPTCHA terlebih dahulu.',
            ]);
        }

        // Verifikasi ke Google
        if (!NoCaptcha::verifyResponse($recaptchaResponse)) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Coba lagi.',
            ]);
        }

        // === PROSES PENYIMPANAN ===
        $consultation = ConsultationRequest::create([
            'full_name'         => $request->input('full_name'),
            'address'           => $request->input('address'),
            'issue_description' => $request->input('issue_description'),
            'whatsapp_number'   => $request->input('whatsapp_number'),
            'status'            => ConsultationRequest::STATUS_PENDING,
        ]);

        // === KIRIM EMAIL KE ADMIN ===
        Mail::to('ayenwaluyan@gmail.com')->send(new NewConsultationRequestMail($consultation));

        // === REDIRECT DENGAN PESAN SUKSES ===
        return redirect()
            ->route('public.home')
            ->with('consultation_status', 'Pengajuan konsultasi berhasil diterima. Kami akan menghubungi Anda melalui WhatsApp.');
    }
}