<?php

namespace App\Console\Commands;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create a new user with role selection';

    public function handle(): int
    {
        $this->info('Creating a new user...');
        $this->newLine();

        // Get user name
        $name = $this->ask('Name');
        if (empty($name)) {
            $this->error('Name is required');
            return self::FAILURE;
        }

        // Get email
        $email = $this->ask('Email');
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'));
            return self::FAILURE;
        }

        // Get password
        $password = $this->secret('Password');
        if (empty($password)) {
            $this->error('Password is required');
            return self::FAILURE;
        }

        // Display available roles
        $this->newLine();
        $this->info('Available roles:');
        $roles = Role::cases();
        $roleChoices = [];
        
        foreach ($roles as $index => $role) {
            $roleChoices[$index] = $role->value;
            $label = Role::labels()[$role->value] ?? $role->value;
            $this->line(sprintf('  [%d] %s', $index, $label));
        }

        $this->newLine();
        $roleIndex = $this->ask('Select role (enter number)', '0');

        if (!isset($roleChoices[$roleIndex])) {
            $this->error('Invalid role selection');
            return self::FAILURE;
        }

        $selectedRole = $roleChoices[$roleIndex];

        // Create the user
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $selectedRole,
                'is_active' => true,
            ]);

            $this->newLine();
            $this->info('User created successfully!');
            $this->line(sprintf('  Name: %s', $user->name));
            $this->line(sprintf('  Email: %s', $user->email));
            $this->line(sprintf('  Role: %s', Role::labels()[$user->role->value] ?? $user->role->value));
            $this->newLine();

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to create user: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
