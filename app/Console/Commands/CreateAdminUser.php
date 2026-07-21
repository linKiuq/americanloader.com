<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {email} {password?} {--name=Admin}';

    protected $description = 'Create or update an admin user with the given email and password';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password') ?: $this->secret('New admin password');
        $name = $this->option('name');

        if (! is_string($password) || strlen($password) < 8) {
            $this->error('The admin password must be at least 8 characters.');

            return self::FAILURE;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]
        );

        $this->info("Admin user {$email} has been created or updated successfully!");

        return self::SUCCESS;
    }
}
