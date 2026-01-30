<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    protected $table = 'outgoing_letters';

    protected $fillable = [
        'letter_number',
        'recipient',
        'recipient_phone',
        'recipient_position',
        'subject',
        'body',
        'letter_type',
        'unit_code',
        'status',
        'sent_at',
        'final_file_path',
        'signature_path',
        'signed_at',
        'verification_code',
        'attachment_path',
        'created_by',
        'approved_by',
        'template_id',
    ];

    protected $casts = [
        'sent_at' => 'date',
        'created_by' => 'integer',
        'approved_by' => 'integer',
        'signed_at' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
