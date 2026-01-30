<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->nullable();
            $table->string('recipient');
            $table->string('subject');
            $table->text('body')->nullable();
            $table->string('letter_type')->nullable();
            $table->string('unit_code')->nullable();
            $table->foreignId('template_id')->nullable();
            $table->string('status')->default('draft');
            $table->date('sent_at')->nullable();
            $table->string('final_file_path')->nullable();
            $table->string('attachment_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_letters');
    }
};
