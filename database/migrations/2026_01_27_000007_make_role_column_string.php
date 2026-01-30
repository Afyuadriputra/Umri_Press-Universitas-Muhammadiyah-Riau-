<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            Schema::rename('users', 'users_old');
            DB::statement('DROP INDEX IF EXISTS users_email_unique');

            $existingColumns = collect(DB::select("PRAGMA table_info('users_old')"))
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->all();

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('role')->default('user');
                $table->string('password');
                $table->rememberToken();
                $table->boolean('can_access_surat')->default(false);
                $table->json('surat_permissions')->nullable();
                $table->json('dashboard_permissions')->nullable();
                $table->json('author_permissions')->nullable();
                $table->timestamps();
            });

            $selects = [
                'id',
                'name',
                'email',
                'email_verified_at',
                'role',
                'password',
                'remember_token',
                in_array('can_access_surat', $existingColumns, true) ? 'can_access_surat' : '0 AS can_access_surat',
                in_array('surat_permissions', $existingColumns, true) ? 'surat_permissions' : 'NULL AS surat_permissions',
                in_array('dashboard_permissions', $existingColumns, true) ? 'dashboard_permissions' : 'NULL AS dashboard_permissions',
                in_array('author_permissions', $existingColumns, true) ? 'author_permissions' : 'NULL AS author_permissions',
                'created_at',
                'updated_at',
            ];

            DB::statement(sprintf(
                'INSERT INTO users (id, name, email, email_verified_at, role, password, remember_token, can_access_surat, surat_permissions, dashboard_permissions, author_permissions, created_at, updated_at) SELECT %s FROM users_old',
                implode(', ', $selects)
            ));

            Schema::drop('users_old');
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS users_email_unique ON users (email)');

            return;
        }

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(50) NOT NULL DEFAULT 'user'");
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(50)");
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            Schema::rename('users', 'users_old');
            DB::statement('DROP INDEX IF EXISTS users_email_unique');

            $existingColumns = collect(DB::select("PRAGMA table_info('users_old')"))
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->all();

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->enum('role', ['user', 'editor', 'admin', 'author'])->default('user');
                $table->string('password');
                $table->rememberToken();
                $table->boolean('can_access_surat')->default(false);
                $table->json('surat_permissions')->nullable();
                $table->json('dashboard_permissions')->nullable();
                $table->json('author_permissions')->nullable();
                $table->timestamps();
            });

            $selects = [
                'id',
                'name',
                'email',
                'email_verified_at',
                'role',
                'password',
                'remember_token',
                in_array('can_access_surat', $existingColumns, true) ? 'can_access_surat' : '0 AS can_access_surat',
                in_array('surat_permissions', $existingColumns, true) ? 'surat_permissions' : 'NULL AS surat_permissions',
                in_array('dashboard_permissions', $existingColumns, true) ? 'dashboard_permissions' : 'NULL AS dashboard_permissions',
                in_array('author_permissions', $existingColumns, true) ? 'author_permissions' : 'NULL AS author_permissions',
                'created_at',
                'updated_at',
            ];

            DB::statement(sprintf(
                'INSERT INTO users (id, name, email, email_verified_at, role, password, remember_token, can_access_surat, surat_permissions, dashboard_permissions, author_permissions, created_at, updated_at) SELECT %s FROM users_old',
                implode(', ', $selects)
            ));

            Schema::drop('users_old');
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS users_email_unique ON users (email)');

            return;
        }

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('user','editor','admin','author') NOT NULL DEFAULT 'user'");
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(50)");
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
        }
    }
};
