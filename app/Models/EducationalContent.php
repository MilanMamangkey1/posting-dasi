<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

class EducationalContent extends Model
{
    use HasFactory;

    private ?string $cachedFilePath = null;
    private ?bool $cachedFileExists = null;

    public const TYPE_VIDEO = 'video';
    public const TYPE_PHOTO = 'photo';
    public const TYPE_NARRATIVE = 'narrative';
    public const TYPE_MATERIAL = 'material';

    public const TYPES = [
        self::TYPE_VIDEO,
        self::TYPE_PHOTO,
        self::TYPE_NARRATIVE,
        self::TYPE_MATERIAL,
    ];

    public const TYPE_LABELS = [
        self::TYPE_VIDEO => 'Video',
        self::TYPE_PHOTO => 'Foto',
        self::TYPE_NARRATIVE => 'Narasi',
        self::TYPE_MATERIAL => 'Materi',
    ];

    protected $fillable = [
        'title',
        'type',
        'summary',
        'event_date',
        'body',
        'source_url',
        'file_path',
        'file_size_bytes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'file_size_bytes' => 'integer',
        'event_date' => 'date',
    ];

    protected $appends = [
        'photo_url',
        'photo_dimensions',
        'document_url',
        'document_extension',
        'document_size_bytes',
    ];

    public static function labelForType(string $type): string
    {
        return self::TYPE_LABELS[$type] ?? ucfirst($type);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->hasStoredFile() || $this->type !== self::TYPE_PHOTO) {
            return null;
        }

        return $this->storageUrl();
    }

    public function getPhotoDimensionsAttribute(): ?array
    {
        if ($this->type !== self::TYPE_PHOTO || ! $this->hasStoredFile()) {
            return null;
        }

        $disk = Storage::disk($this->storageDisk());
        if (! method_exists($disk, 'path')) {
            return null;
        }

        try {
            $path = $disk->path($this->file_path);
            $details = @getimagesize($path);
        } catch (Throwable) {
            return null;
        }

        if (! is_array($details) || empty($details[0]) || empty($details[1])) {
            return null;
        }

        $width = (int) $details[0];
        $height = (int) $details[1];

        if ($width <= 0 || $height <= 0) {
            return null;
        }

        return [
            'width' => $width,
            'height' => $height,
            'orientation' => $width >= $height ? 'landscape' : 'portrait',
            'aspect_ratio' => $height !== 0 ? $width / $height : null,
            'aspect_ratio_css' => $width . ' / ' . $height,
        ];
    }

    public function getDocumentUrlAttribute(): ?string
    {
        if ($this->type !== self::TYPE_MATERIAL || ! $this->hasStoredFile()) {
            return null;
        }

        return $this->storageUrl();
    }

    public function getDocumentExtensionAttribute(): ?string
    {
        if ($this->type !== self::TYPE_MATERIAL || ! $this->hasStoredFile()) {
            return null;
        }

        return strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
    }

    public function getDocumentSizeBytesAttribute(): ?int
    {
        if ($this->type !== self::TYPE_MATERIAL || ! $this->hasStoredFile()) {
            return null;
        }

        return $this->file_size_bytes;
    }

    protected function storageDisk(): string
    {
        return 'public';
    }

    protected function hasStoredFile(): bool
    {
        if (! $this->file_path) {
            $this->cachedFilePath = null;
            $this->cachedFileExists = false;
            return false;
        }

        if ($this->cachedFilePath === $this->file_path && $this->cachedFileExists !== null) {
            return $this->cachedFileExists;
        }

        $disk = Storage::disk($this->storageDisk());

        $exists = $disk->exists($this->file_path);

        $this->cachedFilePath = $this->file_path;
        $this->cachedFileExists = $exists;

        return $exists;
    }

    protected function storageUrl(): ?string
    {
        if (! $this->hasStoredFile()) {
            return null;
        }

        $disk = Storage::disk($this->storageDisk());

        return $disk->url($this->file_path);
    }
}
