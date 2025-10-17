<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\ContentAsset;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PhotoController extends Controller
{
    public function index(): Response
    {
        $recentPhotos = EducationalContent::query()
            ->where('content_type', 'photo')
            ->withCount(['assets as photo_count' => function ($query) {
                $query->where('type', 'photo');
            }])
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (EducationalContent $content) => [
                'id' => $content->id,
                'title' => $content->title,
                'photo_count' => $content->photo_count ?? 0,
                'updated_at' => optional($content->updated_at)->format('d M Y'),
            ]);

        return Inertia::render('content/photo', [
            'recentPhotos' => $recentPhotos,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'tags' => ['nullable', 'string', 'max:255'],
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['image', 'max:2048'],
        ]);

        DB::transaction(function () use ($data, $request) {
            $content = EducationalContent::create([
                'created_by' => Auth::id(),
                'title' => $data['title'],
                'slug' => $this->generateUniqueSlug($data['title']),
                'content_type' => 'photo',
                'summary' => $data['description'] ?? null,
                'status' => 'draft',
                'meta' => $this->buildMeta($data['tags'] ?? null),
            ]);

            $files = $request->file('photos', []);

            foreach ($files as $index => $file) {
                $path = $file->store('photos', 'public');

                ContentAsset::create([
                    'educational_content_id' => $content->id,
                    'type' => 'photo',
                    'storage_path' => $path,
                    'caption' => null,
                    'ordering' => $index,
                    'meta' => [
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                    ],
                ]);
            }
        });

        return redirect()
            ->route('content.photo')
            ->with('success', __('Album foto berhasil disimpan.'));
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

    protected function buildMeta(?string $tags): array
    {
        $tagArray = collect(explode(',', (string) $tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();

        return array_filter([
            'tags' => $tagArray,
        ]);
    }
}
