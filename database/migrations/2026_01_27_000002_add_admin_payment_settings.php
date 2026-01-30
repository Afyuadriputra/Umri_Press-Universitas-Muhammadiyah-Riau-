<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            [
                'key' => 'admin_wa_number',
                'value' => '6287837151510',
                'display_name' => 'Nomor WhatsApp Admin Pembayaran',
                'type' => 'text',
                'group' => 'pembayaran',
                'keterangan' => 'Nomor WhatsApp untuk menerima bukti pembayaran',
            ],
            [
                'key' => 'admin_email',
                'value' => null,
                'display_name' => 'Email Admin Pembayaran',
                'type' => 'text',
                'group' => 'pembayaran',
                'keterangan' => 'Email untuk menerima bukti pembayaran',
            ],
        ];

        foreach ($settings as $setting) {
            $exists = DB::table('pengaturan')->where('key', $setting['key'])->exists();
            if (! $exists) {
                DB::table('pengaturan')->insert(array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function down(): void
    {
        DB::table('pengaturan')
            ->whereIn('key', ['admin_wa_number', 'admin_email'])
            ->delete();
    }
};
