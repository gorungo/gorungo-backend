<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         //$this->call(RolesAndPermissions::class);
        //$this->call(PlaceTypesTableSeeder::class);
        //$this->call(PlaceTypeGroupsTableSeeder::class);
        //$this->call(PlacesTableSeeder::class);
        //$this->call(PlaceDescriptionsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}
