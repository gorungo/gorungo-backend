<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'add to favorite']);

        Permission::create(['name' => 'edit own profiles']);
        Permission::create(['name' => 'edit profiles']);
        Permission::create(['name' => 'view profiles']);
        Permission::create(['name' => 'view own profiles']);

        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'edit own articles']);
        Permission::create(['name' => 'view articles']);
        Permission::create(['name' => 'view unpublished articles']);
        Permission::create(['name' => 'view unpublished own articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'delete own articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'publish own articles']);
        Permission::create(['name' => 'unpublish articles']);
        Permission::create(['name' => 'unpublish own articles']);

        Permission::create(['name' => 'edit ideas']);
        Permission::create(['name' => 'edit own ideas']);
        Permission::create(['name' => 'view ideas']);
        Permission::create(['name' => 'view unpublished ideas']);
        Permission::create(['name' => 'view unpublished own ideas']);
        Permission::create(['name' => 'delete ideas']);
        Permission::create(['name' => 'delete own ideas']);
        Permission::create(['name' => 'publish ideas']);
        Permission::create(['name' => 'publish own ideas']);
        Permission::create(['name' => 'unpublish ideas']);

        Permission::create(['name' => 'edit actions']);
        Permission::create(['name' => 'edit own actions']);
        Permission::create(['name' => 'view actions']);
        Permission::create(['name' => 'view unpublished actions']);
        Permission::create(['name' => 'view unpublished own actions']);
        Permission::create(['name' => 'delete actions']);
        Permission::create(['name' => 'delete own actions']);
        Permission::create(['name' => 'publish actions']);
        Permission::create(['name' => 'publish own actions']);
        Permission::create(['name' => 'unpublish actions']);
        Permission::create(['name' => 'unpublish own actions']);

        Permission::create(['name' => 'edit places']);
        Permission::create(['name' => 'edit own places']);
        Permission::create(['name' => 'view places']);
        Permission::create(['name' => 'view unpublished places']);
        Permission::create(['name' => 'view unpublished own places']);
        Permission::create(['name' => 'delete places']);
        Permission::create(['name' => 'delete own places']);
        Permission::create(['name' => 'publish places']);
        Permission::create(['name' => 'publish own places']);
        Permission::create(['name' => 'unpublish places']);
        Permission::create(['name' => 'unpublish own places']);

        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'view unpublished categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'delete own categories']);
        Permission::create(['name' => 'publish categories']);
        Permission::create(['name' => 'unpublish categories']);



        // create roles and assign created permissions

        $role = Role::create(['name' => 'explorer']);
        $role->givePermissionTo([
            'view articles',
            'view actions',
            'view ideas',
            'view places',
            'view own profiles',
            'edit own profiles',
            'add to favorite',
        ]);

        // this can be done as separate statements
        $role = Role::create(['name' => 'writer']);
        $role->givePermissionTo([
            'edit own articles',
            'publish own articles',
            'unpublish own articles',
            'view unpublished own articles',
            'delete own articles',

            'edit own ideas',
            'view unpublished ideas',
            'publish ideas',
            'unpublish ideas',
            'delete own ideas',
        ]);

        // this can be done as separate statements
        $role = Role::create(['name' => 'company-owner']);
        $role->givePermissionTo([
            'edit own actions',
            'publish own actions',
            'view unpublished own actions',
            'unpublish own actions',
            'delete own actions',
        ]);

        // or may be done by chaining
        $role = Role::create(['name' => 'moderator']);
        $role->givePermissionTo([
                'view unpublished articles',
                'publish articles',
                'unpublish articles',
                'view unpublished ideas',
                'publish ideas',
                'unpublish ideas',
                'publish actions',
                'unpublish actions',
                'publish places',
                'unpublish places',
                'view profiles',
                'view own profiles',

            ]);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
