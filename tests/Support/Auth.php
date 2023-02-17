<?php

namespace Tests\Support;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait Auth
{
    protected static $adminRole = 'admin';

    protected static $adminPass = 'admin';

    protected function setUp(): void
    {
        parent::setUp();

        // create permissions
        Permission::create(['name' => self::$adminRole]);

        // create roles and assign created permissions
        $adminRole = Role::create(['name' => self::$adminRole]);
        $adminRole->givePermissionTo(Permission::all());
    }

    protected function adminUser()
    {
        $admin = User::factory()->create([
            'password' => bcrypt(self::$adminPass),
        ]);
        $admin->assignRole(self::$adminRole);

        return $admin;
    }

    protected function normalUser()
    {
        return User::factory()->create();
    }
}
