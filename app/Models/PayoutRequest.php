<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    protected $fillable = [
        'author_id',
        'amount',
        'bank_details',
        'status',
        'proof_of_payment',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function author()
    {
        return $this->belongsTo(Authors::class, 'author_id');
    }
}
