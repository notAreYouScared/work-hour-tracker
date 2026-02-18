<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\SkillTrade;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleAndTemplateSeeder::class);

        $root = User::updateOrCreate(
            ['email' => 'root@tracker.test'],
            [
                'name' => 'Root Admin',
                'password' => 'password',
                'active' => true,
            ]
        );

        $root->syncRoles([Role::RootAdmin->value]);

        $manager = User::updateOrCreate(
            ['email' => 'manager@tracker.test'],
            [
                'name' => 'Manager One',
                'password' => 'password',
                'active' => true,
            ]
        );
        $manager->syncRoles([Role::Manager->value]);

        $employee = User::updateOrCreate(
            ['email' => 'employee@tracker.test'],
            [
                'name' => 'Electrician Apprentice',
                'password' => 'password',
                'skill_trade' => SkillTrade::Electrician->value,
                'active' => true,
            ]
        );
        $employee->syncRoles([Role::Employee->value]);
        $manager->managedEmployees()->syncWithoutDetaching([$employee->id]);
    }
}
