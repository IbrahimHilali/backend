<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'Grimm\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        if (!$this->app->runningInConsole()) {
            $this->registerRolesAsGates($gate);
        }
    }

    private function registerRolesAsGates(GateContract $gate)
    {
        // TODO: define a gate for each permission

        $gate->before(function ($user, $abillity) {
            return true; // TODO: implement roles and permissions
        });
    }
}
