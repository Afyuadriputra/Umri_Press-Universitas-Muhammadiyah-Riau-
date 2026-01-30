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

        $hasTable = Schema::hasTable('payout_requests');
        $hasOldTable = Schema::hasTable('payout_requests_old');

        if (! $hasTable && ! $hasOldTable) {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');

        if ($hasOldTable && $hasTable) {
            DB::statement("
                INSERT OR IGNORE INTO payout_requests (id, author_id, amount, bank_details, status, proof_of_payment, created_at, updated_at)
                SELECT id, author_id, amount, bank_details, status, proof_of_payment, created_at, updated_at
                FROM payout_requests_old
            ");

            Schema::drop('payout_requests_old');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        if ($hasOldTable && ! $hasTable) {
            Schema::create('payout_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
                $table->decimal('amount', 12, 2);
                $table->text('bank_details');
                $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
                $table->string('proof_of_payment')->nullable();
                $table->timestamps();
            });

            DB::statement("
                INSERT INTO payout_requests (id, author_id, amount, bank_details, status, proof_of_payment, created_at, updated_at)
                SELECT id, author_id, amount, bank_details, status, proof_of_payment, created_at, updated_at
                FROM payout_requests_old
            ");

            Schema::drop('payout_requests_old');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        Schema::rename('payout_requests', 'payout_requests_old');

        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->text('bank_details');
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->string('proof_of_payment')->nullable();
            $table->timestamps();
        });

        DB::statement("
            INSERT INTO payout_requests (id, author_id, amount, bank_details, status, proof_of_payment, created_at, updated_at)
            SELECT id, author_id, amount, bank_details, status, proof_of_payment, created_at, updated_at
            FROM payout_requests_old
        ");

        Schema::drop('payout_requests_old');

        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }
    }
};
