<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->date('received_at');
            $table->date('letter_date')->nullable();
            $table->string('letter_number')->nullable();
            $table->string('sender');
            $table->string('subject');
            $table->text('summary')->nullable();
            $table->string('status')->default('baru');
            $table->text('internal_notes')->nullable();
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('disposition_note')->nullable();
            $table->string('scan_path')->nullable();
            $table->string('attachment_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_letters');
    }
};
