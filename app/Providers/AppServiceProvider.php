<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-platform', function ($user) {
            return in_array($user->role, [
                User::ROLE_EMPLOYEE,
                User::ROLE_MANAGER,
                User::ROLE_ADMIN
            ]);
        });

        Gate::define('manage-users', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('manage-products', function ($user) {
            return in_array($user->role, [
                User::ROLE_MANAGER,
                User::ROLE_ADMIN
            ]);
        });

        Gate::define('manage-categories', function ($user) {
            return in_array($user->role, [
                User::ROLE_MANAGER,
                User::ROLE_ADMIN
            ]);
        });

        Gate::define('manage-requests', function ($user) {
            return in_array($user->role, [
                User::ROLE_EMPLOYEE,
                User::ROLE_MANAGER,
                User::ROLE_ADMIN
            ]);
        });

        Gate::define('approve-requests', function ($user) {
            return in_array($user->role, [
                User::ROLE_MANAGER,
                User::ROLE_ADMIN
            ]);
        });
    }
}
