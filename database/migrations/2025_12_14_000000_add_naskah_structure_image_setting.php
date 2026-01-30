<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $exists = DB::table('pengaturan')
            ->where('key', 'naskah_structure_image')
            ->exists();

        if (! $exists) {
            DB::table('pengaturan')->insert([
                'key' => 'naskah_structure_image',
                'value' => null,
                'display_name' => 'Gambar Struktur Kirim Naskah',
                'type' => 'image',
                'group' => 'kirim-naskah',
                'keterangan' => 'Ukuran disarankan: 1280x719 (24-bit, 96 dpi)',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('pengaturan')
            ->where('key', 'naskah_structure_image')
            ->delete();
    }
};
