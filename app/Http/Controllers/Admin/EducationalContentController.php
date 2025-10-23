<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEducationalContentRequest;
use App\Http\Requests\Admin\UpdateEducationalContentRequest;
use App\Models\EducationalContent;
use Illuminate\Http\JsonResponse;
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

    public function store(StoreEducationalContentRequest $request): JsonResponse
    {
        $payload = $this->buildPayload($request);
        $content = EducationalContent::create($payload);

        return response()->json($content, Response::HTTP_CREATED);
    }

    public function show(EducationalContent $educationalContent): JsonResponse
    {
        return response()->json($educationalContent);
    }

    public function update(UpdateEducationalContentRequest $request, EducationalContent $educationalContent): JsonResponse
    {
        $payload = $this->buildPayload($request, $educationalContent);
        $educationalContent->fill($payload);
        $educationalContent->save();

        return response()->json($educationalContent->fresh());
    }

    public function destroy(EducationalContent $educationalContent): JsonResponse
    {
        $this->deleteStoredFile($educationalContent);
        $educationalContent->delete();

        return response()->json([
            'message' => 'Educational content deleted successfully.',
        ]);
    }

    private function buildPayload(StoreEducationalContentRequest|UpdateEducationalContentRequest $request, ?EducationalContent $content = null): array
    {
        $data = $request->validated();
        $type = $data['type'] ?? $content?->type;

        $data['type'] = $type;

        $isPhoto = $type === EducationalContent::TYPE_PHOTO;

        if ($isPhoto) {
            if ($request->hasFile('file')) {
                if ($content?->file_path) {
                    $this->deleteStoredFile($content);
                }

                $storedPath = $request->file('file')->store('education/photos', 'public');

                $data['file_path'] = $storedPath;
                $data['file_size_bytes'] = $request->file('file')->getSize();
            }

            $data['body'] = null;
            $data['source_url'] = null;
        } else {
            if ($content?->type === EducationalContent::TYPE_PHOTO && $content->file_path) {
                $this->deleteStoredFile($content);
            }

            $data['file_path'] = null;
            $data['file_size_bytes'] = null;
        }

        if ($type === EducationalContent::TYPE_VIDEO) {
            $sourceUrl = $data['source_url'] ?? $content?->source_url;
            $data['source_url'] = $sourceUrl;
            $data['body'] = null;
        } elseif (in_array($type, [EducationalContent::TYPE_NARRATIVE, EducationalContent::TYPE_MATERIAL], true)) {
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
