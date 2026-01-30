<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->string('agenda_number')->nullable()->after('letter_number');
            $table->integer('agenda_year')->nullable()->after('agenda_number');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->string('recipient_phone')->nullable()->after('recipient');
            $table->string('recipient_position')->nullable()->after('recipient_phone');
            $table->string('verification_code')->nullable()->unique()->after('letter_number');
            $table->string('signature_path')->nullable()->after('final_file_path');
            $table->date('signed_at')->nullable()->after('signature_path');
        });
    }

    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropColumn(['agenda_number', 'agenda_year']);
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropColumn(['recipient_phone', 'recipient_position', 'verification_code', 'signature_path', 'signed_at']);
        });
    }
};
