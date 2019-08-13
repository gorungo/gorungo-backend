<?php

use Illuminate\Database\Seeder;

class PlaceTypeDescriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('place_type_descriptions')->delete();
        
        \DB::table('place_type_descriptions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'place_type_id' => 1,
                'locale_id' => 2,
                'title' => 'Континент',
            ),
            1 => 
            array (
                'id' => 2,
                'place_type_id' => 2,
                'locale_id' => 2,
                'title' => 'Океан',
            ),
            2 => 
            array (
                'id' => 3,
                'place_type_id' => 3,
                'locale_id' => 2,
                'title' => 'Море',
            ),
            3 => 
            array (
                'id' => 4,
                'place_type_id' => 4,
                'locale_id' => 2,
                'title' => 'Бухта',
            ),
            4 => 
            array (
                'id' => 5,
                'place_type_id' => 5,
                'locale_id' => 2,
                'title' => 'Пролив',
            ),
            5 => 
            array (
                'id' => 6,
                'place_type_id' => 6,
                'locale_id' => 2,
                'title' => 'Остров',
            ),
            6 => 
            array (
                'id' => 7,
                'place_type_id' => 7,
                'locale_id' => 2,
                'title' => 'Река',
            ),
            7 => 
            array (
                'id' => 8,
                'place_type_id' => 8,
                'locale_id' => 2,
                'title' => 'Озеро',
            ),
            8 => 
            array (
                'id' => 9,
                'place_type_id' => 9,
                'locale_id' => 2,
                'title' => 'Ледник',
            ),
            9 => 
            array (
                'id' => 10,
                'place_type_id' => 10,
                'locale_id' => 2,
                'title' => 'Пустыня',
            ),
            10 => 
            array (
                'id' => 11,
                'place_type_id' => 11,
                'locale_id' => 2,
                'title' => 'Гора',
            ),
            11 => 
            array (
                'id' => 12,
                'place_type_id' => 12,
                'locale_id' => 2,
                'title' => 'Водопад',
            ),
            12 => 
            array (
                'id' => 13,
                'place_type_id' => 13,
                'locale_id' => 2,
                'title' => 'Публичный пляж',
            ),
            13 => 
            array (
                'id' => 14,
                'place_type_id' => 14,
                'locale_id' => 2,
                'title' => 'Мыс',
            ),
            14 => 
            array (
                'id' => 15,
                'place_type_id' => 15,
                'locale_id' => 2,
                'title' => 'Пик',
            ),
            15 => 
            array (
                'id' => 16,
                'place_type_id' => 16,
                'locale_id' => 2,
                'title' => 'Достопримечательность',
            ),
            16 => 
            array (
                'id' => 17,
                'place_type_id' => 17,
                'locale_id' => 2,
                'title' => 'Набережная',
            ),
            17 => 
            array (
                'id' => 18,
                'place_type_id' => 18,
                'locale_id' => 2,
                'title' => 'Маяк',
            ),
            18 => 
            array (
                'id' => 19,
                'place_type_id' => 19,
                'locale_id' => 2,
                'title' => 'Видовая площадка',
            ),
            19 => 
            array (
                'id' => 20,
                'place_type_id' => 20,
                'locale_id' => 2,
                'title' => 'Лыжный курорт',
            ),
            20 => 
            array (
                'id' => 21,
                'place_type_id' => 21,
                'locale_id' => 2,
                'title' => 'Музей',
            ),
            21 => 
            array (
                'id' => 22,
                'place_type_id' => 1,
                'locale_id' => 1,
                'title' => 'Continent',
            ),
            22 => 
            array (
                'id' => 23,
                'place_type_id' => 2,
                'locale_id' => 1,
                'title' => 'Ocean',
            ),
            23 => 
            array (
                'id' => 24,
                'place_type_id' => 3,
                'locale_id' => 1,
                'title' => 'Sea',
            ),
            24 => 
            array (
                'id' => 25,
                'place_type_id' => 4,
                'locale_id' => 1,
                'title' => 'Bay',
            ),
            25 => 
            array (
                'id' => 26,
                'place_type_id' => 5,
                'locale_id' => 1,
                'title' => 'Strait',
            ),
            26 => 
            array (
                'id' => 27,
                'place_type_id' => 6,
                'locale_id' => 1,
                'title' => 'Island',
            ),
            27 => 
            array (
                'id' => 28,
                'place_type_id' => 7,
                'locale_id' => 1,
                'title' => 'River',
            ),
            28 => 
            array (
                'id' => 29,
                'place_type_id' => 8,
                'locale_id' => 1,
                'title' => 'Lake',
            ),
            29 => 
            array (
                'id' => 30,
                'place_type_id' => 9,
                'locale_id' => 1,
                'title' => 'Glacier',
            ),
            30 => 
            array (
                'id' => 31,
                'place_type_id' => 10,
                'locale_id' => 1,
                'title' => 'Desert',
            ),
            31 => 
            array (
                'id' => 32,
                'place_type_id' => 11,
                'locale_id' => 1,
                'title' => 'Mountain',
            ),
            32 => 
            array (
                'id' => 33,
                'place_type_id' => 12,
                'locale_id' => 1,
                'title' => 'Waterfall',
            ),
            33 => 
            array (
                'id' => 34,
                'place_type_id' => 13,
                'locale_id' => 1,
                'title' => 'Public beach',
            ),
            34 => 
            array (
                'id' => 35,
                'place_type_id' => 14,
                'locale_id' => 1,
                'title' => 'Cape',
            ),
            35 => 
            array (
                'id' => 36,
                'place_type_id' => 15,
                'locale_id' => 1,
                'title' => 'Peak',
            ),
            36 => 
            array (
                'id' => 37,
                'place_type_id' => 16,
                'locale_id' => 1,
                'title' => 'Sight',
            ),
            37 => 
            array (
                'id' => 38,
                'place_type_id' => 17,
                'locale_id' => 1,
                'title' => 'Seafront',
            ),
            38 => 
            array (
                'id' => 39,
                'place_type_id' => 18,
                'locale_id' => 1,
                'title' => 'Lighthouse',
            ),
            39 => 
            array (
                'id' => 40,
                'place_type_id' => 19,
                'locale_id' => 1,
                'title' => 'Observation deck',
            ),
            40 => 
            array (
                'id' => 41,
                'place_type_id' => 20,
                'locale_id' => 1,
                'title' => 'Ski resort',
            ),
            41 => 
            array (
                'id' => 42,
                'place_type_id' => 21,
                'locale_id' => 1,
                'title' => 'Museum',
            ),
        ));
        
        
    }
}