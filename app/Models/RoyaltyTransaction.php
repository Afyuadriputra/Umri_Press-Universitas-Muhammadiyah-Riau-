<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoyaltyTransaction extends Model
{
    protected $fillable = [
        'author_id',
        'order_id',
        'amount',
        'type',
        'status',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function author()
    {
        return $this->belongsTo(Authors::class, 'author_id');
    }

    public function order()
    {
        return $this->belongsTo(DirectOrder::class, 'order_id');
    }
}
