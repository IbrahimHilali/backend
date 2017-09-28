<?php

namespace App\Providers;

use Grimm\Permission;
use Grimm\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->runningInConsole()) {
            $this->registerRolesAsGates();
        }

        Passport::routes();
    }

    private function registerRolesAsGates()
    {
        $groups = Permission::selectRaw("SUBSTRING_INDEX(`name`, '.', 1) as topic, GROUP_CONCAT(name) as permissions")->groupBy('topic')->get();

        /** @var Permission $permission */
        foreach($groups as $permissionGroup) {
            $permissions = explode(",", $permissionGroup->permissions);
            foreach ($permissions as $permission) {
                Gate::define($permission, function (User $user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }

            Gate::define($permissionGroup->topic . '.*', function(User $user) use($permissions) {
                foreach ($permissions as $permission) {
                    if ($user->hasPermission($permission)) {
                        return true;
                    }
                }
                return false;
            });
        }
    }
}
