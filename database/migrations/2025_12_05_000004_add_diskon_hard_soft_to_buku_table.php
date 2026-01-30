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
            if (!Schema::hasColumn('buku', 'diskon_hard')) {
                $table->unsignedTinyInteger('diskon_hard')->default(0)->after('diskon');
            }
            if (!Schema::hasColumn('buku', 'diskon_soft')) {
                $table->unsignedTinyInteger('diskon_soft')->default(0)->after('diskon_hard');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            if (Schema::hasColumn('buku', 'diskon_hard')) {
                $table->dropColumn('diskon_hard');
            }
            if (Schema::hasColumn('buku', 'diskon_soft')) {
                $table->dropColumn('diskon_soft');
            }
        });
    }
};
