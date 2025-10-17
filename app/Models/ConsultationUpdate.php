<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_request_id',
        'recorded_by',
        'status_after_update',
        'message',
        'follow_up_at',
    ];

    protected $casts = [
        'follow_up_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(ConsultationRequest::class, 'consultation_request_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
