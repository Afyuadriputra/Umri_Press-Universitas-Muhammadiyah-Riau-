<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('outgoing_letters') || !Schema::hasTable('letter_templates')) {
            return;
        }

        if (!Schema::hasColumn('outgoing_letters', 'template_id')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver !== 'mysql') {
            return;
        }

        $dbName = Schema::getConnection()->getDatabaseName();
        $hasFk = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', 'outgoing_letters')
            ->where('COLUMN_NAME', 'template_id')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->exists();

        if ($hasFk) {
            return;
        }

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->foreign('template_id')
                ->references('id')
                ->on('letter_templates')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('outgoing_letters')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver !== 'mysql') {
            return;
        }

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
        });
    }
};
