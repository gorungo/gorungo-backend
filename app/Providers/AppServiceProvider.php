<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Relation::morphMap([
            'Category' => 'App\Category',
            'Idea' => 'App\Idea',
            'Photo' => 'App\Photo',
            'Action' => 'App\Action',
            'Place' => 'App\Place',
            'Profile' => 'App\Profile',
            'User' => 'App\User',
            'Helper' => 'App\Helper',

            // 'как-храним' => 'класс',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
