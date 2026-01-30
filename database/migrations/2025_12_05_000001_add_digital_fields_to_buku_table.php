<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->boolean('is_hard_available')
                ->default(true)
                ->after('ketersediaan');
            $table->boolean('is_soft_available')
                ->default(false)
                ->after('is_hard_available');
            $table->string('ebook_path')
                ->nullable()
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['is_hard_available', 'is_soft_available', 'ebook_path']);
        });
    }
};
