<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Only the administrator can manage staff accounts.
        Gate::define('manage-staff', function (User $user): bool {
            return $user->username === 'admin';
        });
    }
}
