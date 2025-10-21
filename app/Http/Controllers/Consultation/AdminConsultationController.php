<?php

namespace App\Http\Controllers\Consultation;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class AdminConsultationController extends Controller
{
    public function index(): Response
    {
        $requests = ConsultationRequest::query()
            ->latest('submitted_at')
            ->get()
            ->map(fn (ConsultationRequest $request) => [
                'id' => $request->id,
                'uuid' => $request->uuid,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'address_line' => $request->address_line,
                'notes_from_public' => $request->notes_from_public,
                'status' => $request->status,
                'status_label' => $this->statusLabel($request->status),
                'submitted_at' => optional($request->submitted_at)->format('d M Y H:i'),
                'source' => $request->source,
                'whatsapp_url' => $this->buildWhatsappUrl($request->phone),
            ]);

        $stats = [
            'total' => ConsultationRequest::count(),
            'pending' => ConsultationRequest::pending()->count(),
            'today' => ConsultationRequest::whereDate('submitted_at', now())->count(),
        ];

        return Inertia::render('consultation/index', [
            'requests' => $requests,
            'stats' => $stats,
        ]);
    }

    private function buildWhatsappUrl(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return "https://wa.me/{$digits}";
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'new' => 'Menunggu',
            'in_review' => 'Dalam Review',
            'scheduled' => 'Dijadwalkan',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            default => Str::headline($status),
        };
    }
}

