<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_request_id',
        'full_name',
        'address',
        'issue_description',
        'whatsapp_number',
        'status',
        'admin_notes',
        'handled_at',
        'handled_by',
        'resolved_at',
        'archived_at',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
        'resolved_at' => 'datetime',
        'archived_at' => 'datetime',
        'address' => 'encrypted',
        'whatsapp_number' => 'encrypted',
    ];

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
