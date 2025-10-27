<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use App\Models\EducationalContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json($this->gatherDashboardPayload());
    }

    public function view(): View
    {
        $dashboard = $this->gatherDashboardPayload();

        return view('admin.dashboard', [
            'metrics' => $dashboard['metrics'],
            'recentContents' => $dashboard['recent_contents'],
            'recentConsultations' => $dashboard['recent_consultations'],
            'statusMessage' => session('admin_status'),
            'statusError' => session('admin_error'),
        ]);
    }

    public function contents(Request $request): View
    {
        $contentFilters = [
            'type' => $request->query('content_type'),
            'search' => $request->query('content_search'),
        ];

        $contentsQuery = EducationalContent::query()->latest();
        if ($contentFilters['type']) {
            $contentsQuery->where('type', $contentFilters['type']);
        }
        if ($contentFilters['search']) {
            $contentsQuery->where('title', 'like', '%' . $contentFilters['search'] . '%');
        }

        return view('admin.contents', [
            'contents' => $contentsQuery->paginate(10)->withQueryString(),
            'contentFilters' => $contentFilters,
            'contentTypes' => EducationalContent::TYPES,
            'statusMessage' => session('admin_status'),
            'statusError' => session('admin_error'),
        ]);
    }

    public function consultations(Request $request): View
    {
        $consultationFilters = [
            'status' => $request->query('consultation_status'),
            'search' => $request->query('consultation_search'),
        ];

        $consultationsQuery = ConsultationRequest::query()->latest();
        if ($consultationFilters['status']) {
            $consultationsQuery->where('status', $consultationFilters['status']);
        }
        if ($consultationFilters['search']) {
            $search = $consultationFilters['search'];
            $consultationsQuery->where(function ($inner) use ($search): void {
                $inner->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('whatsapp_number', 'like', '%' . $search . '%');
            });
        }

        return view('admin.consultations', [
            'consultations' => $consultationsQuery->paginate(10)->withQueryString(),
            'consultationFilters' => $consultationFilters,
            'consultationStatuses' => ConsultationRequest::STATUSES,
            'statusMessage' => session('admin_status'),
            'statusError' => session('admin_error'),
        ]);
    }

    private function gatherDashboardPayload(): array
    {
        $contentTypes = array_fill_keys(EducationalContent::TYPES, 0);
        $contentsByType = EducationalContent::query()
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();

        $contentMetrics = array_merge($contentTypes, $contentsByType);

        $consultationStatuses = array_fill_keys(ConsultationRequest::STATUSES, 0);
        $consultationsByStatus = ConsultationRequest::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $consultationMetrics = array_merge($consultationStatuses, $consultationsByStatus);

        return [
            'metrics' => [
                'total_contents' => array_sum($contentMetrics),
                'contents_by_type' => $contentMetrics,
                'total_consultations' => array_sum($consultationMetrics),
                'consultations_by_status' => $consultationMetrics,
            ],
            'recent_contents' => EducationalContent::query()
                ->latest()
                ->take(5)
                ->get(['id', 'title', 'type', 'updated_at']),
            'recent_consultations' => ConsultationRequest::query()
                ->latest()
                ->take(5)
                ->get(['id', 'full_name', 'status', 'updated_at']),
        ];
    }
}
