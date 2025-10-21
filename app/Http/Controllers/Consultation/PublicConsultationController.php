<?php

namespace App\Http\Controllers\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Consultation\StorePublicConsultationRequest;
use App\Models\ConsultationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicConsultationController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('public/consultation-form', [
            'source' => $request->query('source', 'direct_link'),
            'redirectUrl' => route('public.consultation.create'),
        ]);
    }

    public function store(StorePublicConsultationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        ConsultationRequest::create([
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'address_line' => $data['address_line'],
            'notes_from_public' => $data['notes'] ?? null,
            'source' => $data['source'] ?? 'direct_link',
            'status' => 'new',
            'submitted_at' => now(),
        ]);

        $redirectUrl = $data['redirect_url'] ?? route('public.consultation.create');

        return redirect()
            ->to($redirectUrl)
            ->with(
                'success',
                __('Terima kasih! Permintaan konsultasi Anda telah dikirim. Tim kami akan menghubungi Anda melalui WhatsApp.')
            );
    }
}
