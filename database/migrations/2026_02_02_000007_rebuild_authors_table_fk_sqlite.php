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

        $hasAuthors = Schema::hasTable('authors');
        $hasAuthorsOld = Schema::hasTable('authors_old');

        if (! $hasAuthors && ! $hasAuthorsOld) {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');

        if ($hasAuthorsOld && $hasAuthors) {
            DB::statement("
                INSERT OR IGNORE INTO authors (id, user_id, image, name, slug, description, bank_name, bank_account_name, bank_account_number, created_at, updated_at)
                SELECT id, user_id, image, name, slug, description, bank_name, bank_account_name, bank_account_number, created_at, updated_at
                FROM authors_old
            ");

            Schema::drop('authors_old');
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS authors_user_id_unique ON authors (user_id)');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        if ($hasAuthorsOld && ! $hasAuthors) {
            DB::statement('DROP INDEX IF EXISTS authors_user_id_unique');
            DB::statement('DROP INDEX IF EXISTS authors_slug_unique');

            Schema::create('authors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
                $table->string('image')->nullable();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description');
                $table->string('bank_name')->nullable();
                $table->string('bank_account_name')->nullable();
                $table->string('bank_account_number', 50)->nullable();
                $table->timestamps();
            });

            DB::statement("
                INSERT INTO authors (id, user_id, image, name, slug, description, bank_name, bank_account_name, bank_account_number, created_at, updated_at)
                SELECT id, user_id, image, name, slug, description, bank_name, bank_account_name, bank_account_number, created_at, updated_at
                FROM authors_old
            ");

            Schema::drop('authors_old');
            DB::statement('PRAGMA foreign_keys=ON');
            return;
        }

        Schema::rename('authors', 'authors_old');
        DB::statement('DROP INDEX IF EXISTS authors_user_id_unique');
        DB::statement('DROP INDEX IF EXISTS authors_slug_unique');

        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->timestamps();
        });

        DB::statement("
            INSERT INTO authors (id, user_id, image, name, slug, description, bank_name, bank_account_name, bank_account_number, created_at, updated_at)
            SELECT id, user_id, image, name, slug, description, bank_name, bank_account_name, bank_account_number, created_at, updated_at
            FROM authors_old
        ");

        Schema::drop('authors_old');

        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }
    }
};
