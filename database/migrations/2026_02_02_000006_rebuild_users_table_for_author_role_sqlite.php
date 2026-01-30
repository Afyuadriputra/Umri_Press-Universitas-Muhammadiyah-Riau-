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

        $hasUsers = Schema::hasTable('users');
        $hasUsersOld = Schema::hasTable('users_old');

        if (! $hasUsers && ! $hasUsersOld) {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');

        if ($hasUsersOld && $hasUsers) {
            $existingColumns = collect(DB::select("PRAGMA table_info('users_old')"))
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->all();

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
                'created_at',
                'updated_at',
            ];

            DB::statement(sprintf(
                'INSERT OR IGNORE INTO users (id, name, email, email_verified_at, role, password, remember_token, can_access_surat, surat_permissions, created_at, updated_at) SELECT %s FROM users_old',
                implode(', ', $selects)
            ));

            Schema::drop('users_old');
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS users_email_unique ON users (email)');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        if ($hasUsersOld && ! $hasUsers) {
            DB::statement('DROP INDEX IF EXISTS users_email_unique');

            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->enum('role', ['user', 'editor', 'admin', 'author'])->default('user');
                $table->string('password');
                $table->rememberToken();
                $table->boolean('can_access_surat')->default(false);
                $table->text('surat_permissions')->nullable();
                $table->timestamps();
            });

            $existingColumns = collect(DB::select("PRAGMA table_info('users_old')"))
                ->pluck('name')
                ->map(fn ($name) => (string) $name)
                ->all();

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
                'created_at',
                'updated_at',
            ];

            DB::statement(sprintf(
                'INSERT INTO users (id, name, email, email_verified_at, role, password, remember_token, can_access_surat, surat_permissions, created_at, updated_at) SELECT %s FROM users_old',
                implode(', ', $selects)
            ));

            Schema::drop('users_old');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        Schema::rename('users', 'users_old');
        DB::statement('DROP INDEX IF EXISTS users_email_unique');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['user', 'editor', 'admin', 'author'])->default('user');
            $table->string('password');
            $table->rememberToken();
            $table->boolean('can_access_surat')->default(false);
            $table->text('surat_permissions')->nullable();
            $table->timestamps();
        });

        $existingColumns = collect(DB::select("PRAGMA table_info('users_old')"))
            ->pluck('name')
            ->map(fn ($name) => (string) $name)
            ->all();

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
            'created_at',
            'updated_at',
        ];

        DB::statement(sprintf(
            'INSERT INTO users (id, name, email, email_verified_at, role, password, remember_token, can_access_surat, surat_permissions, created_at, updated_at) SELECT %s FROM users_old',
            implode(', ', $selects)
        ));

        Schema::drop('users_old');

        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }
    }
};
