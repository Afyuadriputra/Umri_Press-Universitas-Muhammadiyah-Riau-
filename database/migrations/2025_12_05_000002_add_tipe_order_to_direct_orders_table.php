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
        Schema::table('direct_orders', function (Blueprint $table) {
            $table->string('tipe_order', 10)
                ->default('hard')
                ->after('payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('direct_orders', function (Blueprint $table) {
            $table->dropColumn('tipe_order');
        });
    }
};
