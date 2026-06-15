<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {email} {password} {--name=Admin}';

    protected $description = 'Create or update an admin user with the given email and password';

    public function handle(): void
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->option('name');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        $this->info("Admin user {$email} has been created or updated successfully!");
    }
}
