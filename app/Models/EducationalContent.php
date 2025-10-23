<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalContent extends Model
{
    use HasFactory;

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

    protected $fillable = [
        'title',
        'type',
        'summary',
        'body',
        'source_url',
        'file_path',
        'file_size_bytes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'file_size_bytes' => 'integer',
    ];
}
