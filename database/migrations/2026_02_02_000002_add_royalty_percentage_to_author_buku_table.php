<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('author_buku', function (Blueprint $table) {
            $table->decimal('royalty_percentage', 5, 2)->default(0)->after('buku_id');
        });
    }

    public function down(): void
    {
        Schema::table('author_buku', function (Blueprint $table) {
            $table->dropColumn('royalty_percentage');
        });
    }
};
