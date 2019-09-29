<?php

use Illuminate\Database\Seeder;

class CurrencyDescriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currency_descriptions')->delete();
        
        \DB::table('currency_descriptions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'currency_id' => 1,
                'locale_id' => 1,
                'title' => 'US Dollar',
                'short_title' => 'USD',
            ),
            1 => 
            array (
                'id' => 2,
                'currency_id' => 1,
                'locale_id' => 2,
                'title' => 'Американские доллары',
                'short_title' => 'дол.',
            ),
            2 => 
            array (
                'id' => 3,
                'currency_id' => 3,
                'locale_id' => 1,
                'title' => 'Russian Ruble',
                'short_title' => 'RUB',
            ),
            3 => 
            array (
                'id' => 4,
                'currency_id' => 3,
                'locale_id' => 2,
                'title' => 'Русский рубль',
                'short_title' => 'руб.',
            ),
        ));
        
        
    }
}