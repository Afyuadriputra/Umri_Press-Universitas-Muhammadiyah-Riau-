<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_system')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('can_access_surat')->default(false);
            $table->json('surat_permissions')->nullable();
            $table->json('dashboard_permissions')->nullable();
            $table->json('author_permissions')->nullable();
            $table->timestamps();
        });

        $now = now();
        $roles = [
            [
                'key' => 'admin',
                'name' => 'Admin',
                'description' => 'Akses penuh ke sistem',
                'is_system' => true,
                'is_admin' => true,
                'can_access_surat' => true,
                'surat_permissions' => json_encode([]),
                'dashboard_permissions' => json_encode([]),
                'author_permissions' => json_encode([]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'author',
                'name' => 'Author',
                'description' => 'Akses dashboard penulis',
                'is_system' => true,
                'is_admin' => false,
                'can_access_surat' => false,
                'surat_permissions' => json_encode([]),
                'dashboard_permissions' => json_encode([]),
                'author_permissions' => json_encode([
                    'author.dashboard.view',
                    'author.sales.view',
                    'author.payouts.view',
                    'author.payouts.create',
                    'author.settings.view',
                    'author.settings.update',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'editor',
                'name' => 'Editor',
                'description' => 'Akses terbatas untuk editor',
                'is_system' => true,
                'is_admin' => false,
                'can_access_surat' => false,
                'surat_permissions' => json_encode([]),
                'dashboard_permissions' => json_encode([]),
                'author_permissions' => json_encode([]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'user',
                'name' => 'User',
                'description' => 'Akses dasar',
                'is_system' => true,
                'is_admin' => false,
                'can_access_surat' => false,
                'surat_permissions' => json_encode([]),
                'dashboard_permissions' => json_encode([]),
                'author_permissions' => json_encode([]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('roles')->insert($roles);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
