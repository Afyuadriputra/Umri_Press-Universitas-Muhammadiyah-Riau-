<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use SoftDeletes;

    protected $table = 'buku';
    protected $guarded = ['id'];
    protected $with = ['kategori'];
    protected $casts = [
        'harga' => 'integer',
        'harga_soft' => 'integer',
        'diskon' => 'integer',
        'diskon_hard' => 'integer',
        'diskon_soft' => 'integer',
        'allow_umri_press_payment' => 'boolean',
        'is_hard_available' => 'boolean',
        'is_soft_available' => 'boolean',
        'is_coming_soon' => 'boolean',
        'stock' => 'integer',
        'preview_pages' => 'integer',
    ];
    protected $appends = ['harga_setelah_diskon'];

    public function naskah()
    {
        return $this->belongsTo(Naskah::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Authors::class, 'author_buku', 'buku_id', 'author_id')
            ->withPivot(['royalty_percentage']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'buku_id')->whereNull('parent_id')->where('is_approved', true)->latest();
    }

    public function directOrders()
    {
        return $this->hasMany(DirectOrder::class, 'buku_id');
    }

    public function getHargaSetelahDiskonAttribute(): int
    {
        return $this->calculateDiskon($this->harga, $this->getDiskonPercent('hard'));
    }

    public function getHargaSoftSetelahDiskonAttribute(): ?int
    {
        if ($this->harga_soft === null) {
            return null;
        }

        return $this->calculateDiskon($this->harga_soft, $this->getDiskonPercent('soft'));
    }

    protected function calculateDiskon(?int $harga, int $diskon): int
    {
        if ($harga === null) {
            return 0;
        }

        if ($diskon <= 0) {
            return (int) $harga;
        }

        $discounted = $harga - ($harga * ($diskon / 100));

        return (int) max(0, round($discounted));
    }

    protected function getDiskonPercent(string $tipe): int
    {
        if ($tipe === 'soft' && $this->diskon_soft !== null) {
            return (int) $this->diskon_soft;
        }

        if ($tipe === 'hard' && $this->diskon_hard !== null) {
            return (int) $this->diskon_hard;
        }

        return (int) ($this->diskon ?? 0);
    }
}
