<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }

        $hasTable = Schema::hasTable('royalty_transactions');
        $hasOldTable = Schema::hasTable('royalty_transactions_old');

        if (! $hasTable && ! $hasOldTable) {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');

        if ($hasOldTable && $hasTable) {
            DB::statement("
                INSERT OR IGNORE INTO royalty_transactions (id, author_id, order_id, amount, type, status, description, created_at, updated_at)
                SELECT id, author_id, order_id, amount, type, status, description, created_at, updated_at
                FROM royalty_transactions_old
            ");

            Schema::drop('royalty_transactions_old');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        if ($hasOldTable && ! $hasTable) {
            Schema::create('royalty_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
                $table->foreignId('order_id')->nullable()->constrained('direct_orders')->nullOnDelete();
                $table->decimal('amount', 12, 2);
                $table->enum('type', ['credit', 'debit']);
                $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
                $table->string('description')->nullable();
                $table->timestamps();
            });

            DB::statement("
                INSERT INTO royalty_transactions (id, author_id, order_id, amount, type, status, description, created_at, updated_at)
                SELECT id, author_id, order_id, amount, type, status, description, created_at, updated_at
                FROM royalty_transactions_old
            ");

            Schema::drop('royalty_transactions_old');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        Schema::rename('royalty_transactions', 'royalty_transactions_old');

        Schema::create('royalty_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('direct_orders')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['credit', 'debit']);
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::statement("
            INSERT INTO royalty_transactions (id, author_id, order_id, amount, type, status, description, created_at, updated_at)
            SELECT id, author_id, order_id, amount, type, status, description, created_at, updated_at
            FROM royalty_transactions_old
        ");

        Schema::drop('royalty_transactions_old');

        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }
    }
};
