<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::if('role', function (...$roles) {
            return auth()->check()
                && auth()->user()->role
                && in_array(auth()->user()->role->slug, $roles, true);
        });

        Blade::if('permission', function ($permission) {
            return auth()->check()
                && auth()->user()->hasPermission($permission);
        });
    }
}
