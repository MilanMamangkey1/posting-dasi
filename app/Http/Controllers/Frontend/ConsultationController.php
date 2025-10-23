<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreConsultationRequest;
use App\Models\ConsultationRequest;
use Illuminate\Http\RedirectResponse;

class ConsultationController extends Controller
{
    public function store(StoreConsultationRequest $request): RedirectResponse
    {
        ConsultationRequest::create([
            'full_name' => $request->input('full_name'),
            'address' => $request->input('address'),
            'issue_description' => $request->input('issue_description'),
            'whatsapp_number' => $request->input('whatsapp_number'),
            'status' => ConsultationRequest::STATUS_PENDING,
        ]);

        return redirect()
            ->route('public.home')
            ->with('consultation_status', 'Pengajuan konsultasi berhasil diterima. Kami akan menghubungi Anda melalui WhatsApp.');
    }
}
