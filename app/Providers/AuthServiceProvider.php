<?php

namespace App\Providers;

use App\Models\WeeklySheet;
use App\Policies\WeeklySheetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        WeeklySheet::class => WeeklySheetPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
