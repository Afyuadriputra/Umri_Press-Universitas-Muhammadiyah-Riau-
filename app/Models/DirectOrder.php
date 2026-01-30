<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectOrder extends Model
{
    use HasFactory;

    public const STATUS_PENDING    = 'pending';
    public const STATUS_VERIFIED   = 'verified';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED    = 'shipped';
    public const STATUS_COMPLETED  = 'completed';
    public const STATUS_CANCELLED  = 'cancelled';

    public const STATUS_LABELS = [
        self::STATUS_PENDING    => 'Menunggu Konfirmasi',
        self::STATUS_VERIFIED   => 'Terverifikasi',
        self::STATUS_PROCESSING => 'Diproses',
        self::STATUS_SHIPPED    => 'Dikirim',
        self::STATUS_COMPLETED  => 'Selesai',
        self::STATUS_CANCELLED  => 'Dibatalkan',
    ];

    protected $fillable = [
        'buku_id',
        'payment_method_id',
        'tipe_order',
        'recipient_name',
        'recipient_phone',
        'recipient_email',
        'address_label',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'alamat_lengkap',
        'harga_asli',
        'harga_setelah_diskon',
        'status',
        'catatan_pengguna',
        'catatan_admin',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'harga_asli'            => 'integer',
        'harga_setelah_diskon'  => 'integer',
        'status'                => 'string',
        'tipe_order'            => 'string',
    ];

    public function buku()
    {
        // include soft-deleted books so existing orders still resolve their title
        return $this->belongsTo(Buku::class)->withTrashed();
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
