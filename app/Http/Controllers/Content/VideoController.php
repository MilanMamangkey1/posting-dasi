<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class VideoController extends Controller
{
    public function index(): Response
    {
        $recentVideos = EducationalContent::query()
            ->where('content_type', 'video')
            ->latest()
            ->take(6)
            ->get()
            ->map(function (EducationalContent $content) {
                $mode = $content->meta['mode'] ?? ($content->video_url ? 'embed' : 'upload');

                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'source' => $mode === 'upload' ? 'Unggah Manual' : 'YouTube',
                    'updated_at' => optional($content->updated_at)->format('d M Y'),
                ];
            });

        return Inertia::render('content/video', [
            'recentVideos' => $recentVideos,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'integer', 'min:1', 'max:180'],
            'summary' => ['nullable', 'string', 'max:500'],
            'mode' => ['required', 'in:embed,upload'],
            'video_url' => ['nullable', 'required_if:mode,embed', 'url'],
            'video_file' => ['nullable', 'required_if:mode,upload', 'file', 'mimetypes:video/mp4,video/webm', 'max:51200'],
        ]);

        $mediaPath = null;

        if ($data['mode'] === 'upload' && $request->file('video_file')) {
            $mediaPath = $request->file('video_file')->store('videos', 'public');
        }

        $duration = $data['duration'] ?? null;

        $content = EducationalContent::create([
            'created_by' => Auth::id(),
            'title' => $data['title'],
            'slug' => $this->generateUniqueSlug($data['title']),
            'content_type' => 'video',
            'summary' => $data['summary'] ?? null,
            'video_url' => $data['mode'] === 'embed' ? $data['video_url'] : null,
            'media_path' => $mediaPath,
            'status' => 'draft',
            'meta' => array_filter([
                'duration' => $duration !== null ? (int) $duration : null,
                'mode' => $data['mode'],
            ], static fn ($value) => $value !== null),
        ]);

        return redirect()
            ->route('content.video')
            ->with('success', __('Video edukasi ":title" berhasil disimpan.', [
            'title' => $content->title,
        ]));
    }

    protected function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (EducationalContent::where('slug', $slug)->exists()) {
            $slug = $base.'-'.Str::lower(Str::random(4)).'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
