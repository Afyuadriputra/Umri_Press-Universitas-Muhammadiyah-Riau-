<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorBuku extends Model
{
    protected $table = 'author_buku';

    protected $fillable = [
        'author_id',
        'buku_id',
        'royalty_percentage',
    ];

    protected $casts = [
        'royalty_percentage' => 'decimal:2',
    ];

    public function author()
    {
        return $this->belongsTo(Authors::class, 'author_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
