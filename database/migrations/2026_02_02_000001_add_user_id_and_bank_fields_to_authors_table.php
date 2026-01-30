<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained('users')->nullOnDelete();
            $table->string('bank_name')->nullable()->after('description');
            $table->string('bank_account_name')->nullable()->after('bank_name');
            $table->string('bank_account_number', 50)->nullable()->after('bank_account_name');
        });
    }

    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->dropColumn(['user_id', 'bank_name', 'bank_account_name', 'bank_account_number']);
        });
    }
};
