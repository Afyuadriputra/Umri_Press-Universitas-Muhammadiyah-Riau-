<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('letter_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('letter_types')->insert([
            ['code' => 'OUT', 'name' => 'Surat Keluar', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'SK', 'name' => 'Surat Keputusan', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'UND', 'name' => 'Undangan', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_types');
    }
};
