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
        $videos = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_VIDEO)
            ->latest()
            ->get()
            ->map(function (EducationalContent $content): EducationalContent {
                $content->embed_url = $this->buildYoutubeEmbedUrl($content->source_url);

                return $content;
            });

        $photoPage = (int) $request->query('photo_page', 1);
        $photos = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_PHOTO)
            ->latest()
            ->paginate(9, ['*'], 'photo_page', $photoPage);

        $narratives = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_NARRATIVE)
            ->latest()
            ->get();

        $materials = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_MATERIAL)
            ->latest()
            ->get();

        return view('frontend.home', [
            'videos' => $videos,
            'photos' => $photos,
            'narratives' => $narratives,
            'materials' => $materials,
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
