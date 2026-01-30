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
            if (Schema::hasColumn('buku', 'allow_umri_press_payment')) {
                return;
            }

            $table->boolean('allow_umri_press_payment')
                ->default(true)
                ->after('marketplace_links');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            if (Schema::hasColumn('buku', 'allow_umri_press_payment')) {
                $table->dropColumn('allow_umri_press_payment');
            }
        });
    }
};
