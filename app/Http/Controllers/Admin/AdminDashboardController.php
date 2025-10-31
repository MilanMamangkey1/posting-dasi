<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchivedConsultationRequest;
use App\Models\ConsultationRequest;
use App\Models\EducationalContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
            'contentTypeLabels' => EducationalContent::TYPE_LABELS,
            'consultationStatusLabels' => ConsultationRequest::STATUS_LABELS,
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
            'contentTypeLabels' => EducationalContent::TYPE_LABELS,
            'statusMessage' => session('admin_status'),
            'statusError' => session('admin_error'),
        ]);
    }

    public function consultations(Request $request): View
    {
        $allowedRanges = ['7_days', '1_month', 'all'];
        $consultationFilters = [
            'status' => $request->query('consultation_status'),
            'search' => $request->query('consultation_search'),
            'date_range' => $request->query('consultation_range', 'all'),
        ];

        if (! in_array($consultationFilters['date_range'], $allowedRanges, true)) {
            $consultationFilters['date_range'] = 'all';
        }

        $statusOrderSql = <<<'SQL'
CASE status
    WHEN ? THEN 0
    WHEN ? THEN 1
    WHEN ? THEN 2
    WHEN ? THEN 3
    ELSE 4
END
SQL;

        $consultationsQuery = ConsultationRequest::query()
            ->orderByRaw(
                $statusOrderSql,
                [
                    ConsultationRequest::STATUS_PENDING,
                    ConsultationRequest::STATUS_IN_PROGRESS,
                    ConsultationRequest::STATUS_RESOLVED,
                    ConsultationRequest::STATUS_ARCHIVED,
                ]
            )
            ->latest();
        if ($consultationFilters['status']) {
            $consultationsQuery->where('status', $consultationFilters['status']);
        }
        if ($consultationFilters['date_range'] === '7_days') {
            $consultationsQuery->where('created_at', '>=', now()->subDays(7));
        } elseif ($consultationFilters['date_range'] === '1_month') {
            $consultationsQuery->where('created_at', '>=', now()->subMonth());
        }

        $dateRangeOptions = [
            '7_days' => '7 Hari Terakhir',
            '1_month' => '1 Bulan Terakhir',
            'all' => 'Semua Waktu',
        ];

        $searchTerm = $consultationFilters['search'];
        $consultations = $consultationsQuery->get();
        if ($searchTerm) {
            $normalizedSearch = $this->normalizeDigits($searchTerm);
            $consultations = $consultations->filter(function ($item) use ($searchTerm, $normalizedSearch) {
                $nameMatch = stripos($item->full_name ?? '', $searchTerm) !== false;
                $numberMatch = false;

                if ($normalizedSearch !== '') {
                    $sanitizedNumber = $this->normalizeDigits($item->whatsapp_number ?? '');
                    $numberMatch = str_contains($sanitizedNumber, $normalizedSearch);
                }

                return $nameMatch || $numberMatch;
            })->values();
        }

        $paginatedConsultations = $this->paginateCollection($consultations, 10, (int) $request->query('page', 1));
        $paginatedConsultations->appends($request->except('page'));

        return view('admin.consultations', [
            'consultations' => $paginatedConsultations,
            'consultationFilters' => $consultationFilters,
            'consultationStatuses' => ConsultationRequest::STATUSES,
            'consultationStatusLabels' => ConsultationRequest::STATUS_LABELS,
            'consultationDateRanges' => $dateRangeOptions,
            'statusMessage' => session('admin_status'),
            'statusError' => session('admin_error'),
        ]);
    }

    public function consultationArchives(Request $request): View
    {
        $filters = [
            'search' => $request->query('archive_search'),
        ];

        $archivesQuery = ArchivedConsultationRequest::query()->latest('archived_at');

        $archives = $archivesQuery->get();
        if ($filters['search']) {
            $searchTerm = $filters['search'];
            $normalizedSearch = $this->normalizeDigits($searchTerm);
            $archives = $archives->filter(function ($item) use ($searchTerm, $normalizedSearch) {
                $nameMatch = stripos($item->full_name ?? '', $searchTerm) !== false;
                $numberMatch = false;

                if ($normalizedSearch !== '') {
                    $sanitizedNumber = $this->normalizeDigits($item->whatsapp_number ?? '');
                    $numberMatch = str_contains($sanitizedNumber, $normalizedSearch);
                }

                return $nameMatch || $numberMatch;
            })->values();
        }

        $paginatedArchives = $this->paginateCollection($archives, 10, (int) $request->query('page', 1));
        $paginatedArchives->appends($request->except('page'));

        return view('admin.consultations-archive', [
            'archives' => $paginatedArchives,
            'filters' => $filters,
            'consultationStatusLabels' => ConsultationRequest::STATUS_LABELS,
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
                ->get(['id', 'title', 'type', 'file_path', 'file_size_bytes', 'event_date', 'updated_at']),
            'recent_consultations' => ConsultationRequest::query()
                ->latest()
                ->take(5)
                ->get(['id', 'full_name', 'status', 'updated_at']),
        ];
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
