<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outgoing_letters', function (Blueprint $table) {
            if (!Schema::hasColumn('outgoing_letters', 'unit_code')) {
                $table->string('unit_code')->nullable();
            }
            if (!Schema::hasColumn('outgoing_letters', 'template_id')) {
                $table->foreignId('template_id')->nullable()->constrained('letter_templates')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('outgoing_letters', function (Blueprint $table) {
            if (Schema::hasColumn('outgoing_letters', 'template_id')) {
                $table->dropConstrainedForeignId('template_id');
            }
            if (Schema::hasColumn('outgoing_letters', 'unit_code')) {
                $table->dropColumn('unit_code');
            }
        });
    }
};
