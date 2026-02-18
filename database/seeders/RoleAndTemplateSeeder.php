<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\SkillTrade;
use App\Models\HourSection;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as PermissionRole;

class RoleAndTemplateSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Role::cases() as $role) {
            PermissionRole::findOrCreate($role->value, 'web');
        }

        $sections = [
            [
                'skill_trade' => SkillTrade::Electrician->value,
                'name' => 'GMS - Global Maintenance Process',
                'target_hours' => 300,
                'categories' => [
                    ['name' => 'Predictive & Diagnostic Technologies', 'area_affected' => 'GF', 'target_hours' => 200],
                    ['name' => 'CMMS System', 'area_affected' => 'GF', 'target_hours' => 100],
                ],
            ],
            [
                'skill_trade' => SkillTrade::Electrician->value,
                'name' => 'Commissioning, Maintenance, Repair & Troubleshooting',
                'target_hours' => 3580,
                'categories' => [
                    ['name' => 'Layout, Fabrication & Electrical Raceways', 'area_affected' => 'PPON, GA, MTS, Design', 'target_hours' => 1200],
                    ['name' => 'Automatic & Production Machines', 'area_affected' => 'PPON, GA, MTS, Design', 'target_hours' => 300],
                    ['name' => 'Welding Systems', 'area_affected' => 'PPON', 'target_hours' => 180],
                ],
            ],
            [
                'skill_trade' => SkillTrade::Electrician->value,
                'name' => 'General Machinery Fundamentals',
                'target_hours' => 640,
                'categories' => [
                    ['name' => 'Tool Room Equipment & Process Related Equipment', 'area_affected' => 'PPON, GA, MTS, Design', 'target_hours' => 640],
                ],
            ],
        ];

        foreach ($sections as $sectionIndex => $payload) {
            $section = HourSection::updateOrCreate(
                [
                    'skill_trade' => $payload['skill_trade'],
                    'name' => $payload['name'],
                ],
                [
                    'display_order' => $sectionIndex + 1,
                    'target_hours' => $payload['target_hours'],
                    'active' => true,
                ]
            );

            foreach ($payload['categories'] as $categoryIndex => $category) {
                $section->categories()->updateOrCreate(
                    ['name' => $category['name']],
                    [
                        'details' => $category['name'],
                        'area_affected' => $category['area_affected'],
                        'target_hours' => $category['target_hours'],
                        'display_order' => $categoryIndex + 1,
                    ]
                );
            }
        }
    }
}
