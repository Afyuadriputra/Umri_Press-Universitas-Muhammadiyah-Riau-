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
            // Skip if column already exists (e.g., on re-run in SQLite)
            if (Schema::hasColumn('buku', 'eisbn')) {
                return;
            }

            $table->string('eisbn')->nullable()->unique()->after('isbn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            if (Schema::hasColumn('buku', 'eisbn')) {
                $table->dropColumn('eisbn');
            }
        });
    }
};
