<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:admin-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password admin berdasarkan email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $newPassword = $this->argument('password');

        $admin = User::where('email', $email)->first();

        if (!$admin) {
            $this->error('Admin dengan email tersebut tidak ditemukan.');
            return;
        }

        $admin->password = Hash::make($newPassword);
        $admin->save();

        $this->info('Password admin berhasil direset.');
    }
}
