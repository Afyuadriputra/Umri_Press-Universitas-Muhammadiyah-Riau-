<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->seedAdmin([
            'name' => 'admin',
            'email' => 'umripres@umri.ac.id',
            'password' => 'umripress!@#)(*',
        ]);

        $this->seedAdmin([
            'name' => 'Afyu Admin',
            'email' => 'afyu@gmail.com',
            'password' => 'afyu@gmail.com',
        ]);

        $this->seedAdmin([
            'name' => 'Puput Admin',
            'email' => 'puput@gmail.com',
            'password' => 'puput@gmail.com',
        ]);

        $this->seedAdmin([
            'name' => 'Damar Admin',
            'email' => 'damar@gmail.com',
            'password' => 'damar@gmail.com',
        ]);
        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('admin123'),
        //     'role' => 'admin',
        // ]);

        Kategori::firstOrCreate(
            ['slug' => 'buku-ajar'],
            ['nama' => 'Buku Ajar']
        );
    }

    private function seedAdmin(array $data): void
    {
        $payload = [
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
        ];

        if (Schema::hasColumn('users', 'can_access_surat')) {
            $payload['can_access_surat'] = true;
        }
        if (Schema::hasColumn('users', 'surat_permissions')) {
            $payload['surat_permissions'] = [];
        }
        if (Schema::hasColumn('users', 'dashboard_permissions')) {
            $payload['dashboard_permissions'] = [];
        }
        if (Schema::hasColumn('users', 'author_permissions')) {
            $payload['author_permissions'] = [];
        }

        User::updateOrCreate(
            ['email' => $data['email']],
            $payload
        );
    }
}
