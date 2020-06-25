<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function($user) {
            return $user->type === 'super_admin';
        });

        Gate::define('isAdmin', function($user) {
            return $user->type === 'admin';
        });

        if(Gate::allows('isSuperAdmin') || Gate::allows('isAdmin')) {
            return User::latest()->paginate(10);
        }

        Gate::define('isRegistrar', function($user) {
            return $user->type === 'registrar';
        });

        Gate::define('isCashier', function($user) {
            return $user->type === 'cashier';
        });
    }
}
