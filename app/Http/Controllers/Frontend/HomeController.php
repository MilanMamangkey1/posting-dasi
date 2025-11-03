<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const PER_PAGE = 4;

    public function index(Request $request): View
    {
        // === VIDEO: 4 per halaman + paginasi ===
        $videos = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_VIDEO)
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'video_page')
            ->through(function (EducationalContent $content): EducationalContent {
                $content->embed_url = $this->buildYoutubeEmbedUrl($content->source_url);
                return $content;
            });

        // === FOTO: 4 per halaman + paginasi ===
        $photos = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_PHOTO)
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'photo_page');

        // === NARASI: 4 per halaman + paginasi ===
        $narratives = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_NARRATIVE)
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'narrative_page');

        // === MATERI: 4 per halaman + paginasi ===
        $materials = EducationalContent::query()
            ->where('type', EducationalContent::TYPE_MATERIAL)
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'material_page');

        return view('frontend.home', [
            'videos'           => $videos,
            'photos'           => $photos,
            'narratives'        => $narratives,
            'materials'        => $materials,
            'submissionStatus' => $request->session()->get('consultation_status'),
        ]);
    }

    private function buildYoutubeEmbedUrl(?string $url): ?string
    {
        if (! $url) return null;

        $pattern = '%^https?://(?:www\.)?(?:youtube\.com/(?:watch\?v=|embed/|v/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})%i';

        return preg_match($pattern, $url, $matches) === 1
            ? 'https://www.youtube.com/embed/' . $matches[1]
            : null;
    }
}