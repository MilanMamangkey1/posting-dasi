<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class EducationalContent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'created_by',
        'title',
        'slug',
        'content_type',
        'summary',
        'narrative_md',
        'material_md',
        'video_url',
        'media_path',
        'hero_image_path',
        'meta',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'meta' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $content): void {
            $content->uuid ??= (string) Str::uuid();
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(ContentAsset::class)->orderBy('ordering');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
