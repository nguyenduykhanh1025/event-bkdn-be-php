<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $this->createRoleIfMissing(config('constants.role.ADMIN'));
        $this->createRoleIfMissing(config('constants.role.PARTICIPANT'));
    }

    protected function createRoleIfMissing($name)
    {
        if (empty(Role::findByName($name))) {
            Role::create(['name' => $name]);
        }
    }
}
