<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $table = 'dispositions';

    protected $fillable = [
        'incoming_letter_id',
        'instruction',
        'due_date',
        'note',
        'status',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
        'created_by' => 'integer',
    ];

    public function incomingLetter()
    {
        return $this->belongsTo(IncomingLetter::class);
    }

    public function recipients()
    {
        return $this->hasMany(DispositionRecipient::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
