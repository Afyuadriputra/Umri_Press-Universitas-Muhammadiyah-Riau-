<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratSetting extends Model
{
    protected $table = 'surat_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }
}
