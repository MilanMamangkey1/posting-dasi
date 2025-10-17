<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class MaterialController extends Controller
{
    public function index(): Response
    {
        $recentMaterials = EducationalContent::query()
            ->where('content_type', 'material')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (EducationalContent $content) => [
                'id' => $content->id,
                'title' => $content->title,
                'format' => $content->meta['format'] ?? ($content->media_path ? strtoupper(pathinfo($content->media_path, PATHINFO_EXTENSION)) : 'N/A'),
                'updated_at' => optional($content->updated_at)->format('d M Y'),
            ]);

        return Inertia::render('content/material', [
            'recentMaterials' => $recentMaterials,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:50'],
            'file' => ['nullable', 'required_without:link', 'file', 'mimes:pdf,ppt,pptx,doc,docx', 'max:10240'],
            'link' => ['nullable', 'required_without:file', 'url'],
            'notes' => ['nullable', 'string'],
        ]);

        $mediaPath = null;

        if ($request->file('file')) {
            $mediaPath = $request->file('file')->store('materials', 'public');
        }

        EducationalContent::create([
            'created_by' => Auth::id(),
            'title' => $data['title'],
            'slug' => $this->generateUniqueSlug($data['title']),
            'content_type' => 'material',
            'summary' => $data['notes'] ? Str::limit(strip_tags($data['notes']), 200, '...') : null,
            'material_md' => $data['notes'] ?? null,
            'media_path' => $mediaPath,
            'status' => 'draft',
            'meta' => array_filter([
                'format' => $data['format'] ?? null,
                'external_link' => $data['link'] ?? null,
            ]),
        ]);

        return redirect()
            ->route('content.material')
            ->with('success', __('Materi pendukung berhasil disimpan.'));
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
