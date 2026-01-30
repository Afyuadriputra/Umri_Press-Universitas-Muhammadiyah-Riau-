<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratNotification extends Model
{
    protected $table = 'surat_notifications';

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'link',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
