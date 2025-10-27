<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreConsultationRequestRequest;
use App\Http\Requests\Admin\UpdateConsultationRequestRequest;
use App\Models\ConsultationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class ConsultationRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ConsultationRequest::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($inner) use ($search) {
                $inner->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('whatsapp_number', 'like', '%' . $search . '%');
            });
        }

        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? $perPage : 15;

        return response()->json(
            $query->paginate($perPage)
        );
    }

    public function store(StoreConsultationRequestRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = $data['status'] ?? ConsultationRequest::STATUS_PENDING;

        $this->applyHandlingDefaults($data, $request);

        $consultation = ConsultationRequest::create($data);

        if ($request->expectsJson()) {
            return response()->json($consultation, Response::HTTP_CREATED);
        }

        return redirect()
            ->route('admin.consultations.index')
            ->with('admin_status', 'Pengajuan konsultasi baru dibuat.');
    }

    public function show(ConsultationRequest $consultationRequest): JsonResponse
    {
        return response()->json($consultationRequest);
    }

    public function update(UpdateConsultationRequestRequest $request, ConsultationRequest $consultationRequest): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        $this->applyHandlingDefaults($data, $request, $consultationRequest);

        $consultationRequest->fill($data);
        $consultationRequest->save();

        if ($request->expectsJson()) {
            return response()->json($consultationRequest->fresh());
        }

        return redirect()
            ->route('admin.consultations.index')
            ->with('admin_status', 'Status konsultasi diperbarui.');
    }

    public function destroy(Request $request, ConsultationRequest $consultationRequest): JsonResponse|RedirectResponse
    {
        $consultationRequest->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Consultation request deleted successfully.',
            ]);
        }

        return redirect()
            ->route('admin.consultations.index')
            ->with('admin_status', 'Pengajuan konsultasi dihapus.');
    }

    private function applyHandlingDefaults(array &$data, Request $request, ?ConsultationRequest $existing = null): void
    {
        $status = $data['status'] ?? $existing?->status ?? ConsultationRequest::STATUS_PENDING;

        if ($status === ConsultationRequest::STATUS_PENDING) {
            if (array_key_exists('handled_at', $data)) {
                $data['handled_at'] = $data['handled_at'] ? Carbon::parse($data['handled_at']) : null;
            }

            if (! array_key_exists('handled_by', $data)) {
                $data['handled_by'] = null;
            }

            return;
        }

        if (! array_key_exists('handled_at', $data)) {
            $data['handled_at'] = $existing?->handled_at ?? now();
        } elseif ($data['handled_at']) {
            $data['handled_at'] = Carbon::parse($data['handled_at']);
        }

        if (! array_key_exists('handled_by', $data) && $request->user()) {
            $data['handled_by'] = $request->user()->id;
        }
    }
}
