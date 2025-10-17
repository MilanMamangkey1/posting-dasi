<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'educational_content_id',
        'type',
        'storage_path',
        'external_url',
        'caption',
        'ordering',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(EducationalContent::class, 'educational_content_id');
    }
}
