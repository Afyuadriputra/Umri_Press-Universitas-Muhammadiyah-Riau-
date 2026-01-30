<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('royalty_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('direct_orders')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['credit', 'debit']);
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index(['author_id', 'status']);
            $table->unique(['author_id', 'order_id', 'type'], 'royalty_author_order_type_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('royalty_transactions');
    }
};
