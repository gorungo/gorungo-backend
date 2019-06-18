<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 4,
                'slug' => 'sport',
                'created_at' => NULL,
                'updated_at' => '2019-05-12 03:47:56',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 7,
                'slug' => 'hobby',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 0,
                'order' => 0,
                'slug' => 'spirit',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 0,
                'order' => 0,
                'slug' => 'mind',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 5,
                'slug' => 'relax',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 6,
                'slug' => 'skills',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 8,
                'slug' => 'impression',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 9,
                'slug' => 'entertainment',
                'created_at' => NULL,
                'updated_at' => '2019-05-12 04:06:24',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 2,
                'slug' => 'home',
                'created_at' => NULL,
                'updated_at' => '2018-05-22 11:44:50',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 1,
                'slug' => 'family',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 0,
                'order' => 0,
                'slug' => 'cat11',
                'created_at' => NULL,
                'updated_at' => '2019-05-12 04:19:42',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 0,
                'order' => 0,
                'slug' => 'cat12',
                'created_at' => NULL,
                'updated_at' => '2019-05-12 07:23:08',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 1,
                'order' => 0,
                'slug' => 'skiing',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 1,
                'order' => 0,
                'slug' => 'skates',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 1,
                'order' => 0,
                'slug' => 'running',
                'created_at' => NULL,
                'updated_at' => '2018-05-22 11:53:22',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 1,
                'order' => 0,
                'slug' => 'workout',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'author_id' => 1,
                'parent_id' => 3,
                'active' => 1,
                'order' => 0,
                'slug' => 'active-rest',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 25,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 0,
                'order' => 0,
                'slug' => 'novaya-kategoriya',
                'created_at' => '2018-04-14 07:54:24',
                'updated_at' => '2019-05-12 04:05:10',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 26,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 3,
                'slug' => 'play-games',
                'created_at' => '2018-05-22 11:42:20',
                'updated_at' => '2018-06-04 11:17:29',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 27,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 1,
                'order' => 0,
                'slug' => 'antirun',
                'created_at' => '2018-05-22 12:18:39',
                'updated_at' => '2018-05-26 11:30:41',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 29,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 0,
                'order' => 0,
                'slug' => 'ride-a-bicycle',
                'created_at' => '2018-05-26 01:53:30',
                'updated_at' => '2018-05-26 01:54:01',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 30,
                'author_id' => 1,
                'parent_id' => 7,
                'active' => 0,
                'order' => 0,
                'slug' => 'sign-up-for-an-excursion',
                'created_at' => '2018-05-26 02:04:08',
                'updated_at' => '2019-05-12 04:14:48',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 31,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 1,
                'order' => 0,
                'slug' => 'gym',
                'created_at' => '2018-05-26 02:20:10',
                'updated_at' => '2018-05-26 02:21:59',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 39,
                'author_id' => 1,
                'parent_id' => 1,
                'active' => 1,
                'order' => 0,
                'slug' => 'autosport',
                'created_at' => '2018-05-26 11:25:03',
                'updated_at' => '2018-05-26 11:26:39',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 40,
                'author_id' => 1,
                'parent_id' => 39,
                'active' => 1,
                'order' => 0,
                'slug' => 'ride-on-atvs',
                'created_at' => '2018-05-26 11:34:03',
                'updated_at' => '2018-05-26 11:34:42',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 41,
                'author_id' => 1,
                'parent_id' => 6,
                'active' => 1,
                'order' => 0,
                'slug' => 'the-art-of-photography',
                'created_at' => '2018-06-13 10:56:55',
                'updated_at' => '2018-06-13 10:57:37',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 42,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 1,
                'order' => 10,
                'slug' => 'traveling',
                'created_at' => '2019-05-12 07:57:47',
                'updated_at' => '2019-05-12 07:57:47',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 43,
                'author_id' => 1,
                'parent_id' => 0,
                'active' => 0,
                'order' => 0,
                'slug' => 'test',
                'created_at' => '2019-05-12 09:09:25',
                'updated_at' => '2019-05-12 09:11:44',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}