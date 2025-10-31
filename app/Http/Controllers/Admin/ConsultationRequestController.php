<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreConsultationRequestRequest;
use App\Http\Requests\Admin\UpdateConsultationRequestRequest;
use App\Models\ArchivedConsultationRequest;
use App\Models\ConsultationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ConsultationRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ConsultationRequest::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? $perPage : 15;

        $items = $query->get();
        if ($request->filled('search')) {
            $searchTerm = $request->query('search');
            $normalizedSearch = $this->normalizeDigits($searchTerm);
            $items = $items->filter(function ($item) use ($searchTerm, $normalizedSearch) {
                $nameMatch = stripos($item->full_name ?? '', $searchTerm) !== false;
                $numberMatch = false;

                if ($normalizedSearch !== '') {
                    $sanitizedNumber = $this->normalizeDigits($item->whatsapp_number ?? '');
                    $numberMatch = str_contains($sanitizedNumber, $normalizedSearch);
                }

                return $nameMatch || $numberMatch;
            })->values();
        }

        $page = max(1, (int) $request->query('page', 1));
        $paginator = $this->paginateCollection($items, $perPage, $page);
        $paginator->appends($request->except('page'));

        return response()->json($paginator);
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

        $shouldArchive = ($data['status'] ?? null) === ConsultationRequest::STATUS_RESOLVED;

        if ($shouldArchive) {
            $archivePayload = DB::transaction(function () use ($consultationRequest, $data) {
                $consultationRequest->fill($data);
                $consultationRequest->status = ConsultationRequest::STATUS_RESOLVED;
                $consultationRequest->save();

                $archived = ArchivedConsultationRequest::create([
                    'consultation_request_id' => $consultationRequest->id,
                    'full_name' => $consultationRequest->full_name,
                    'address' => $consultationRequest->address,
                    'issue_description' => $consultationRequest->issue_description,
                    'whatsapp_number' => $consultationRequest->whatsapp_number,
                    'status' => ConsultationRequest::STATUS_RESOLVED,
                    'admin_notes' => $consultationRequest->admin_notes,
                    'handled_at' => $consultationRequest->handled_at,
                    'handled_by' => $consultationRequest->handled_by,
                    'resolved_at' => $consultationRequest->handled_at ?? now(),
                    'archived_at' => now(),
                ]);

                $consultationRequest->delete();

                return $archived;
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Pengajuan konsultasi selesai dan telah diarsipkan.',
                    'archive' => $archivePayload,
                ]);
            }

            return redirect()
                ->route('admin.consultations.index')
                ->with('admin_status', 'Pengajuan konsultasi telah diselesaikan dan dipindahkan ke arsip.');
        }

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
                'message' => 'Pengajuan konsultasi berhasil dihapus.',
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

    private function paginateCollection(Collection $items, int $perPage, int $page = 1, string $pageName = 'page'): LengthAwarePaginator
    {
        $page = max(1, (int) $page);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }

    private function normalizeDigits(?string $value): string
    {
        return $value ? preg_replace('/\D+/', '', $value) : '';
    }
}
