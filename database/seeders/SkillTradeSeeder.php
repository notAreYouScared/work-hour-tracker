<?php

namespace Database\Seeders;

use App\Models\SkillTrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillTradeSeeder extends Seeder
{
    public function run(): void
    {
        $trades = [
            'Die Maker',
            'Metal Model Maker',
            'Wood Model Maker',
            'Experimental Auto',
            'Auto Inspector',
            'Tool & Die Welder',
            'Electrician',
            'Machine Repair',
            'Millwright',
            'Pipefitter',
        ];

        foreach ($trades as $trade) {
            SkillTrade::query()->firstOrCreate([
                'slug' => Str::slug($trade),
            ], [
                'name' => $trade,
            ]);
        }
    }
}
