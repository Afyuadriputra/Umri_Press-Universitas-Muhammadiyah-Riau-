<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketPenerbit extends Model
{
    use SoftDeletes;

    protected $table = 'paket_penerbit';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'position',
        'active',
    ];

    protected $casts = [
        'fitur' => 'array',
        'recommended' => 'boolean',
        'active' => 'boolean'
    ];
}
