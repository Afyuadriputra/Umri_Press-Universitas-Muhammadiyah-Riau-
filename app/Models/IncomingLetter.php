<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    protected $table = 'incoming_letters';

    protected $fillable = [
        'received_at',
        'letter_date',
        'letter_number',
        'agenda_number',
        'agenda_year',
        'sender',
        'subject',
        'summary',
        'status',
        'internal_notes',
        'assigned_user_id',
        'disposition_note',
        'scan_path',
        'attachment_path',
        'created_by',
    ];

    protected $casts = [
        'received_at' => 'date',
        'letter_date' => 'date',
        'assigned_user_id' => 'integer',
        'created_by' => 'integer',
        'agenda_year' => 'integer',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dispositions()
    {
        return $this->hasMany(Disposition::class);
    }
}
