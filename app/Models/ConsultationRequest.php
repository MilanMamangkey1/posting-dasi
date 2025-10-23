<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_ARCHIVED = 'archived';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_IN_PROGRESS,
        self::STATUS_RESOLVED,
        self::STATUS_ARCHIVED,
    ];

    protected $fillable = [
        'full_name',
        'address',
        'issue_description',
        'whatsapp_number',
        'status',
        'admin_notes',
        'handled_at',
        'handled_by',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
    ];
}
