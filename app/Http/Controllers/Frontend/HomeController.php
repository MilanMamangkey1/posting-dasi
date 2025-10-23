<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $contents = EducationalContent::query()
            ->latest()
            ->get()
            ->map(function (EducationalContent $content): EducationalContent {
                if ($content->type === EducationalContent::TYPE_VIDEO) {
                    $content->embed_url = $this->buildYoutubeEmbedUrl($content->source_url);
                }

                return $content;
            });

        $grouped = $contents->groupBy('type');

        return view('frontend.home', [
            'videos' => $grouped->get(EducationalContent::TYPE_VIDEO, collect()),
            'photos' => $grouped->get(EducationalContent::TYPE_PHOTO, collect()),
            'narratives' => $grouped->get(EducationalContent::TYPE_NARRATIVE, collect()),
            'materials' => $grouped->get(EducationalContent::TYPE_MATERIAL, collect()),
            'submissionStatus' => $request->session()->get('consultation_status'),
        ]);
    }

    private function buildYoutubeEmbedUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $pattern = '%^https?://(?:www\.)?(?:youtube\.com/(?:watch\?v=|embed/|v/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})%i';

        return preg_match($pattern, $url, $matches) === 1
            ? 'https://www.youtube.com/embed/' . $matches[1]
            : null;
    }
}
