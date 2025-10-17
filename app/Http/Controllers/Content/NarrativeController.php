<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NarrativeController extends Controller
{
    public function index(): Response
    {
        $recentNarratives = EducationalContent::query()
            ->where('content_type', 'narrative')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (EducationalContent $content) => [
                'id' => $content->id,
                'title' => $content->title,
                'summary' => $content->summary,
                'updated_at' => optional($content->updated_at)->format('d M Y'),
            ]);

        return Inertia::render('content/narrative', [
            'recentNarratives' => $recentNarratives,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'tags' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'url'],
        ]);

        $summary = Str::limit(strip_tags($data['body']), 200, '...');

        EducationalContent::create([
            'created_by' => Auth::id(),
            'title' => $data['title'],
            'slug' => $this->generateUniqueSlug($data['title']),
            'content_type' => 'narrative',
            'summary' => $summary,
            'narrative_md' => $data['body'],
            'status' => 'draft',
            'meta' => $this->buildMeta($data['tags'] ?? null, $data['reference'] ?? null),
        ]);

        return redirect()
            ->route('content.narrative')
            ->with('success', __('Narasi edukasi berhasil disimpan.'));
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

    protected function buildMeta(?string $tags, ?string $reference): array
    {
        $tagArray = collect(explode(',', (string) $tags))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();

        return array_filter([
            'tags' => $tagArray,
            'reference' => $reference,
        ]);
    }
}
