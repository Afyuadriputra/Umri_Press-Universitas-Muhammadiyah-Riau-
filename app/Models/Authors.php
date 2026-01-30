<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    protected $table = 'authors';
    protected $guarded = ['id'];
    protected $with = ['buku'];

    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'author_buku', 'author_id', 'buku_id')
            ->withPivot(['royalty_percentage']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function royaltyTransactions()
    {
        return $this->hasMany(RoyaltyTransaction::class, 'author_id');
    }

    public function payoutRequests()
    {
        return $this->hasMany(PayoutRequest::class, 'author_id');
    }
}
