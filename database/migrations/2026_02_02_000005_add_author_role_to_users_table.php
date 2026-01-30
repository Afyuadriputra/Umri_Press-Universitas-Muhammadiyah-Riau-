<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('user','editor','admin','author') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('user','editor','admin') NOT NULL DEFAULT 'user'");
    }
};
