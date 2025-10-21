<?php

namespace App\Http\Controllers;

use App\Models\ContentAsset;
use App\Models\EducationalContent;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PublicSiteController extends Controller
{
    public function __invoke(): Response
    {
        $videos = $this->videoListing();
        $photoCollections = $this->photoListing();
        $narratives = $this->narrativeListing();
        $materials = $this->materialListing();

        return Inertia::render('public/home', [
            'videos' => $videos,
            'photos' => $photoCollections,
            'narratives' => $narratives,
            'materials' => $materials,
            'consultation' => [
                'source' => 'public_portal',
                'redirect_url' => route('home'),
            ],
        ]);
    }

    private function videoListing(): array
    {
        return EducationalContent::query()
            ->where('content_type', 'video')
            ->latest('updated_at')
            ->take(8)
            ->get()
            ->map(function (EducationalContent $content) {
                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'summary' => $content->summary,
                    'video_url' => $content->video_url,
                    'media_url' => $content->media_path ? Storage::url($content->media_path) : null,
                    'updated_at' => optional($content->updated_at)->toDateTimeString(),
                ];
            })
            ->toArray();
    }

    private function photoListing(): array
    {
        return EducationalContent::query()
            ->where('content_type', 'photo')
            ->with(['assets' => function ($query) {
                $query->where('type', 'photo')
                    ->orderBy('ordering')
                    ->orderBy('id');
            }])
            ->latest('updated_at')
            ->take(8)
            ->get()
            ->map(function (EducationalContent $content) {
                $photos = $content->assets
                    ->map(function (ContentAsset $asset) {
                        $url = $asset->external_url;

                        if (! $url && $asset->storage_path) {
                            $url = Storage::url($asset->storage_path);
                        }

                        return [
                            'id' => $asset->id,
                            'url' => $url,
                            'caption' => $asset->caption,
                        ];
                    })
                    ->filter(fn (array $photo) => $photo['url']);

                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'photos' => $photos->values()->take(3)->toArray(),
                    'updated_at' => optional($content->updated_at)->toDateTimeString(),
                ];
            })
            ->toArray();
    }

    private function narrativeListing(): array
    {
        return EducationalContent::query()
            ->where('content_type', 'narrative')
            ->latest('updated_at')
            ->take(8)
            ->get()
            ->map(function (EducationalContent $content) {
                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'summary' => $content->summary,
                    'body' => $content->narrative_md,
                    'updated_at' => optional($content->updated_at)->toDateTimeString(),
                ];
            })
            ->toArray();
    }

    private function materialListing(): array
    {
        return EducationalContent::query()
            ->where('content_type', 'material')
            ->latest('updated_at')
            ->take(8)
            ->get()
            ->map(function (EducationalContent $content) {
                $downloadUrl = $content->media_path ? Storage::url($content->media_path) : null;

                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'summary' => $content->summary,
                    'format' => $content->meta['format'] ?? null,
                    'external_link' => $content->meta['external_link'] ?? null,
                    'download_url' => $downloadUrl,
                    'updated_at' => optional($content->updated_at)->toDateTimeString(),
                ];
            })
            ->toArray();
    }
}

