<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use App\Models\EducationalContent;
use Illuminate\Http\JsonResponse;

class AdminDashboardController extends Controller
{
    public function index(): JsonResponse
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

        return response()->json([
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
        ]);
    }
}
