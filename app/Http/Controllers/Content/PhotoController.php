<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\ContentAsset;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PhotoController extends Controller
{
    public function index(): Response
    {
        $fotoEntries = EducationalContent::query()
            ->where('content_type', 'photo')
            ->with(['assets' => function ($query) {
                $query->where('type', 'photo')->orderBy('ordering')->orderBy('id');
            }])
            ->orderByDesc('updated_at')
            ->get()
            ->map(function (EducationalContent $content) {
                $photos = $content->assets
                    ->map(function (ContentAsset $asset) {
                        $url = $asset->external_url;

                        if (! $url && $asset->storage_path) {
                            $url = Storage::disk('public')->url($asset->storage_path);
                        }

                        return [
                            'id' => $asset->id,
                            'url' => $url,
                            'caption' => $asset->caption,
                        ];
                    })
                    ->filter(fn (array $photo) => $photo['url'] !== null)
                    ->values();

                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'photo_count' => $photos->count(),
                    'updated_at' => optional($content->updated_at)->format('d M Y'),
                    'photos' => $photos->toArray(),
                ];
            })
            ->values();

        $recentPhotos = $fotoEntries
            ->take(6)
            ->map(function (array $entry) {
                return [
                    'id' => $entry['id'],
                    'title' => $entry['title'],
                    'photo_count' => $entry['photo_count'],
                    'updated_at' => $entry['updated_at'],
                    'preview_photos' => collect($entry['photos'])->take(3)->values()->all(),
                ];
            })
            ->values();

        return Inertia::render('content/photo', [
            'recentPhotos' => $recentPhotos,
            'fotoEntries' => $fotoEntries,
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
            ->with('success', __('Foto berhasil disimpan.'));
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
