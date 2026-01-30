<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('surat_settings')->insert([
            ['key' => 'instansi', 'value' => 'UMRIPRESS', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'number_format', 'value' => '{sequence}/{instansi}/{jenis}/{unit}/{bulan_roman}/{tahun}', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'sequence_length', 'value' => '3', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_settings');
    }
};
