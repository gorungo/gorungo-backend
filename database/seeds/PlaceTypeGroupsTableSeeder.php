<?php

use Illuminate\Database\Seeder;

class PlaceTypeGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('place_type_groups')->delete();
        
        \DB::table('place_type_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => 'settlement',
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => 'administrative units',
            ),
            2 => 
            array (
                'id' => 3,
                'slug' => 'natural objects',
            ),
            3 => 
            array (
                'id' => 4,
                'slug' => 'artificial constructions',
            ),
            4 => 
            array (
                'id' => 5,
                'slug' => 'other facilities',
            ),
        ));
        
        
    }
}