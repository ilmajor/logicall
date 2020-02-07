<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Project' => 'App\Policies\ProjectPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app['auth']->provider('custom', function ($app, array $config) {
            $model = $app['config']['auth.providers.users.model'];
            return new CustomUserProvider($app['hash'], $model);
        });
    }
}
