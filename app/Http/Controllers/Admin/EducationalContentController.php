<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEducationalContentRequest;
use App\Http\Requests\Admin\UpdateEducationalContentRequest;
use App\Models\EducationalContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class EducationalContentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = EducationalContent::query()->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->query('search') . '%');
        }

        $perPage = (int) $request->query('per_page', 15);
        $perPage = $perPage > 0 ? $perPage : 15;

        return response()->json(
            $query->paginate($perPage)
        );
    }

    public function store(StoreEducationalContentRequest $request): JsonResponse|RedirectResponse
    {
        $payload = $this->buildPayload($request);
        $content = EducationalContent::create($payload);

        if ($request->expectsJson()) {
            return response()->json($content, Response::HTTP_CREATED);
        }

        return redirect()
            ->route('admin.contents.index')
            ->with('admin_status', 'Konten berhasil dibuat.');
    }

    public function show(EducationalContent $educationalContent): JsonResponse
    {
        return response()->json($educationalContent);
    }

    public function update(UpdateEducationalContentRequest $request, EducationalContent $educationalContent): JsonResponse|RedirectResponse
    {
        $payload = $this->buildPayload($request, $educationalContent);
        $educationalContent->fill($payload);
        $educationalContent->save();

        if ($request->expectsJson()) {
            return response()->json($educationalContent->fresh());
        }

        return redirect()
            ->route('admin.contents.index')
            ->with('admin_status', 'Konten berhasil diperbarui.');
    }

    public function destroy(Request $request, EducationalContent $educationalContent): JsonResponse|RedirectResponse
    {
        $this->deleteStoredFile($educationalContent);
        $educationalContent->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Educational content deleted successfully.',
            ]);
        }

        return redirect()
            ->route('admin.contents.index')
            ->with('admin_status', 'Konten berhasil dihapus.');
    }

    private function buildPayload(StoreEducationalContentRequest|UpdateEducationalContentRequest $request, ?EducationalContent $content = null): array
    {
        $data = $request->validated();
        $type = $data['type'] ?? $content?->type;

        $data['type'] = $type;

        $isPhoto = $type === EducationalContent::TYPE_PHOTO;
        $isMaterial = $type === EducationalContent::TYPE_MATERIAL;

        if ($isPhoto || $isMaterial) {
            if ($request->hasFile('file')) {
                if ($content?->file_path) {
                    $this->deleteStoredFile($content);
                }

                $directory = $isPhoto ? 'education/photos' : 'education/materials';
                $storedPath = $request->file('file')->store($directory, 'public');

                $data['file_path'] = $storedPath;
                $data['file_size_bytes'] = $request->file('file')->getSize();
            } elseif (! $content?->file_path) {
                $data['file_path'] = null;
                $data['file_size_bytes'] = null;
            }

            $data['body'] = null;
            $data['source_url'] = null;
        } else {
            if ($content && $content->file_path && in_array($content->type, [EducationalContent::TYPE_PHOTO, EducationalContent::TYPE_MATERIAL], true)) {
                $this->deleteStoredFile($content);
            }

            $data['file_path'] = null;
            $data['file_size_bytes'] = null;
        }

        if ($type === EducationalContent::TYPE_VIDEO) {
            $sourceUrl = $data['source_url'] ?? $content?->source_url;
            $data['source_url'] = $sourceUrl;
            $data['body'] = null;
        } elseif ($type === EducationalContent::TYPE_NARRATIVE) {
            $data['body'] = $data['body'] ?? $content?->body;
            $data['source_url'] = null;
        } else {
            $data['body'] = null;
            $data['source_url'] = null;
        }

        unset($data['file']);

        $userId = $request->user()?->id;

        if ($content) {
            if ($userId) {
                $data['updated_by'] = $userId;
            }
        } elseif ($userId) {
            $data['created_by'] = $userId;
        }

        return $data;
    }

    private function deleteStoredFile(EducationalContent $content): void
    {
        if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
            Storage::disk('public')->delete($content->file_path);
        }
    }
}
