<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'US Dollar',
                'code' => 'USD',
                'number' => '840',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Euro',
                'code' => 'EUR',
                'number' => '978',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Russian Ruble',
                'code' => 'RUB',
                'number' => '643',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Hong Kong Dollar',
                'code' => 'HKD',
                'number' => '344',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Rupiah',
                'code' => 'IDR',
                'number' => '360',
            ),
        ));
        
        
    }
}