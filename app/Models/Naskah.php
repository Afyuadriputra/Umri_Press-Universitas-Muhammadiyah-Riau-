<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Naskah extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];
    protected $table = 'naskah';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->hasOne(Buku::class);
    }
}
