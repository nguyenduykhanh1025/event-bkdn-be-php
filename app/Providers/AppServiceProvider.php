<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->initialRolesIfNotExists();
    }

    private function initialRolesIfNotExists()
    {
        if (Schema::hasTable('roles')) {
            $allRolesInDatabase = Role::all()->pluck('name');
            $rolesInitial = config('constants.role');
            $keys = array_keys($rolesInitial);

            foreach ($keys as $key) {
                $roleName =  $rolesInitial[$key];
                if (!$allRolesInDatabase->contains($roleName)) {
                    Role::create(['name' => $roleName]);
                }
            }
        }
    }
}
