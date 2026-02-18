<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Enums\SkillTrade;
use App\Models\Trade;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleName::values() as $role) {
            Role::findOrCreate($role, 'web');
        }

        foreach (SkillTrade::values() as $tradeName) {
            Trade::firstOrCreate(['name' => $tradeName]);
        }
    }
}
