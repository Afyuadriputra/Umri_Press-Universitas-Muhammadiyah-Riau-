<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispositionRecipient extends Model
{
    protected $table = 'disposition_recipients';

    protected $fillable = [
        'disposition_id',
        'user_id',
        'role',
    ];

    public function disposition()
    {
        return $this->belongsTo(Disposition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
