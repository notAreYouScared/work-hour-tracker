<?php

namespace App\Providers;

use App\Models\EmployeeProfile;
use App\Observers\EmployeeProfileObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        EmployeeProfile::observe(EmployeeProfileObserver::class);
    }
}
