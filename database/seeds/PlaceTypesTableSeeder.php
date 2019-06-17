<?php

use Illuminate\Database\Seeder;

class PlaceTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('place_types')->delete();
        
        \DB::table('place_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'place_type_group_id' => 3,
                'slug' => 'continent',
            ),
            1 => 
            array (
                'id' => 2,
                'place_type_group_id' => 3,
                'slug' => 'ocean',
            ),
            2 => 
            array (
                'id' => 3,
                'place_type_group_id' => 3,
                'slug' => 'sea',
            ),
            3 => 
            array (
                'id' => 4,
                'place_type_group_id' => 3,
                'slug' => 'bay',
            ),
            4 => 
            array (
                'id' => 5,
                'place_type_group_id' => 3,
                'slug' => 'strait',
            ),
            5 => 
            array (
                'id' => 6,
                'place_type_group_id' => 3,
                'slug' => 'island',
            ),
            6 => 
            array (
                'id' => 7,
                'place_type_group_id' => 3,
                'slug' => 'river',
            ),
            7 => 
            array (
                'id' => 8,
                'place_type_group_id' => 3,
                'slug' => 'lake',
            ),
            8 => 
            array (
                'id' => 9,
                'place_type_group_id' => 3,
                'slug' => 'glacier',
            ),
            9 => 
            array (
                'id' => 10,
                'place_type_group_id' => 3,
                'slug' => 'desert',
            ),
            10 => 
            array (
                'id' => 11,
                'place_type_group_id' => 3,
                'slug' => 'mountain',
            ),
            11 => 
            array (
                'id' => 12,
                'place_type_group_id' => 3,
                'slug' => 'waterfall',
            ),
            12 => 
            array (
                'id' => 13,
                'place_type_group_id' => 3,
                'slug' => 'public beach',
            ),
            13 => 
            array (
                'id' => 14,
                'place_type_group_id' => 3,
                'slug' => 'cape',
            ),
            14 => 
            array (
                'id' => 15,
                'place_type_group_id' => 3,
                'slug' => 'peak',
            ),
            15 => 
            array (
                'id' => 16,
                'place_type_group_id' => 2,
                'slug' => 'sight',
            ),
            16 => 
            array (
                'id' => 17,
                'place_type_group_id' => 3,
                'slug' => 'seafront',
            ),
            17 => 
            array (
                'id' => 18,
                'place_type_group_id' => 4,
                'slug' => 'lighthouse',
            ),
            18 => 
            array (
                'id' => 19,
                'place_type_group_id' => 4,
                'slug' => 'observation deck',
            ),
            19 => 
            array (
                'id' => 20,
                'place_type_group_id' => 5,
                'slug' => 'ski resort',
            ),
            20 => 
            array (
                'id' => 21,
                'place_type_group_id' => 2,
                'slug' => 'museum',
            ),
        ));
        
        
    }
}