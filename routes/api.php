<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {

    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/test', function (Request $request) {
            return ['result' => 'ok'];
        });

        Route::post('/login', 'AuthController@login');
        Route::post('/register', 'AuthController@register');

        // profiles
        Route::get('/profiles/create', 'API\ProfileController@create')
            ->name('api.profiles.create');
        Route::get('/profiles/{profile}/edit', 'API\ProfileController@edit')
            ->middleware(['can:update,profile'])
            ->name('api.profiles.edit');
        Route::post('/profiles', 'API\ProfileController@store')
            ->name('api.profiles.store')
            ->middleware(['can:update,profile'])
            ->name('api.profiles.edit');
        Route::patch('/profiles/{profile}', 'API\ProfileController@update')
            ->middleware(['can:update,profile'])
            ->name('api.profiles.update');
        Route::delete('/profiles/{profile}', 'API\ProfileController@destroy')
            ->name('api.profiles.destroy');

        Route::patch('/users/{user}/setNewPassword', 'API\UserController@setNewPassword')
            ->middleware(['auth','can:update,user'])
            ->name('api.profiles.set_new_password');

        //Get user ideas
        Route::get('/users/{user}/ideas', "API\UserController@ideas")
            ->name('api.user.ideas');

        // posts
        Route::get('/posts/create', 'API\PostController@create')->name('api.posts.create');
        Route::get('/posts/{post}/edit', 'API\PostController@edit')->name('api.posts.edit');
        Route::post('/posts', 'API\PostController@store')->name('api.posts.store');
        Route::patch('/posts/{post}', 'API\PostController@update')->name('api.posts.update');
        Route::delete('/posts/{post}', 'API\PostController@destroy')->name('api.posts.destroy');

        // actions
        Route::get('/actions/create', 'API\ActionController@create')->name('api.actions.create');
        Route::get('/actions/{action}/edit', 'API\ActionController@edit')->name('api.actions.edit');
        Route::post('/actions', 'API\ActionController@store')->name('api.actions.store');
        Route::patch('/actions/{action}', 'API\ActionController@update')->name('api.actions.update');
        Route::delete('/actions/{action}', 'API\ActionController@destroy')->name('api.actions.destroy');

        // ideas
        Route::get('/ideas/create', 'API\IdeaController@create')->name('api.ideas.create');
        Route::get('/ideas/{idea}/edit', 'API\IdeaController@edit')->name('api.ideas.edit');
        Route::post('/ideas', 'API\IdeaController@store')->name('api.ideas.store');

        Route::patch('/ideas/{idea}', 'API\IdeaController@update')->name('api.ideas.update');
        Route::delete('/ideas/{idea}', 'API\IdeaController@destroy')->name('api.ideas.destroy');

        // places
        Route::get('/places/create', 'API\PlaceController@create')->name('api.places.create');
        Route::get('/places/{place}/edit', 'API\PlaceController@edit')->name('api.places.edit');
        Route::post('/places', 'API\PlaceController@store')->name('api.places.store');
        Route::patch('/places/{place}', 'API\PlaceController@update')->name('api.places.update');
        Route::delete('/places/{place}', 'API\PlaceController@destroy')->name('api.places.destroy');


        // categories
        Route::get('/categories/create', 'API\CategoryController@create')->name('api.category.create');
        Route::get('/categories/{category}/edit', 'API\CategoryController@edit')->name('api.category.edit');
        Route::post('/categories', 'API\CategoryController@store')->name('api.category.store');
        Route::patch('/categories/{category}', 'API\CategoryController@update')->name('api.category.update');
        Route::delete('/categories/{category}', 'API\CategoryController@destroy')->name('api.category.destroy');

        Route::get('/categories', 'API\CategoryController@index')->name('api.category.index');
        Route::get('/categories/children', 'API\CategoryController@lastChildren')->name('api.category.last_children');
        Route::get('/categories/{category}', 'API\CategoryController@show')->name('api.category.show');
        Route::get('/categories/{categoryId}/fullcategorieslisting', 'Api\CategoryController@fullCategoriesListing')->name('api.category.fullcategorieslisting');
        Route::get('/categories/{categoryId}/child', 'API\CategoryController@child')->name('api.category.child');


        // tags
        Route::get('/tags/allMain', 'API\TagController@allMainTagsCollection')->name('api.tags.all_main_tags_collection');


        /*
         * -------------------------------------------------------------------------
         * ACTIONS PHOTOS ROUTING
         * -------------------------------------------------------------------------
         */

        //Get listing of photos
        Route::get('/posts/{post}/photos', "API\Photo\ActionController@index")
            ->name('api.posts.photos_index');

        //Upload photo
        Route::post('/posts/{post}/photos', 'API\Photo\ActionController@upload')
            ->name('api.posts.photos_upload');

        //Set item main photos
        Route::patch('/posts/{post}/photos/{photo}/set_main', 'API\Photo\ActionController@setMain')
            ->name('api.posts.photos_set_main');

        //Delete item main photos
        Route::delete('/posts/{post}/photos/{photo}', 'API\Photo\ActionController@destroy')
            ->name('api.posts.photos_destroy');
        /*
         * -------------------------------------------------------------------------
         * ACTIONS PHOTOS ROUTING
         * -------------------------------------------------------------------------
         */

        //Get listing of photos
        Route::get('/actions/{action}/photos', "API\Photo\ActionController@index")
            ->name('api.actions.photos_index');

        //Upload photo
        Route::post('/actions/{action}/photos', 'API\Photo\ActionController@upload')
            ->name('api.actions.photos_upload');

        //Set item main photos
        Route::patch('/actions/{action}/photos/{photo}/set_main', 'API\Photo\ActionController@setMain')
            ->name('api.actions.photos_set_main');

        //Delete item main photos
        Route::delete('/actions/{action}/photos/{photo}', 'API\Photo\ActionController@destroy')
            ->name('api.actions.photos_destroy');

        /*
         * -------------------------------------------------------------------------
         * IDEAS PHOTOS ROUTING
         * -------------------------------------------------------------------------
         */

        //Get listing of photos
        Route::get('/ideas/{idea}/photos', "API\Photo\IdeaController@index")
            ->name('api.ideas.photos_index');

        //Upload photo
        Route::post('/ideas/{idea}/photos', 'API\Photo\IdeaController@upload')
            ->name('api.ideas.photos_upload');

        //Set item main photos
        Route::patch('/ideas/{idea}/photos/{photo}/set_main', 'API\Photo\IdeaController@setMain')
            ->name('api.ideas.photos_set_main');

        //Delete item main photos
        Route::delete('/ideas/{idea}/photos/{photo}', 'API\Photo\IdeaController@destroy')
            ->name('api.ideas.photos_destroy');

        /*
         * -------------------------------------------------------------------------
         * IDEA ITINERARY PHOTOS ROUTING
         * -------------------------------------------------------------------------
         */

        //Get listing of photos
        Route::get('/ideas/{idea}/itineraries/{itinerary}/photos', "API\Photo\IdeaItineraryController@index")
            ->name('api.ideas.photos_index');

        //Upload photo
        Route::post('/ideas/{idea}/itineraries/{itinerary}/photos', 'API\Photo\IdeaItineraryController@upload')
            ->name('api.ideas.photos_upload');

        //Upload and set main photo
        Route::post('/ideas/{idea}/itineraries/{itinerary}/photo', 'API\Photo\IdeaItineraryController@uploadMain')
            ->name('api.ideas.photos_upload');

        //Set item main photos
        Route::patch('/ideas/{idea}/itineraries/{itinerary}/photos/{photo}/set_main', 'API\Photo\IdeaItineraryController@setMain')
            ->name('api.ideas.photos_set_main');

        //Delete item main photos
        Route::delete('/ideas/{idea}/itineraries/{itinerary}/photos/{photo}', 'API\Photo\IdeaItineraryController@destroy')
            ->name('api.ideas.photos_destroy');

        /*
         * -------------------------------------------------------------------------
         * PLACES PHOTOS ROUTING
         * -------------------------------------------------------------------------
         */

        //Get listing of photos
        Route::get('/places/{place}/photos', "API\Photo\PlaceController@index")
            ->name('api.ideas.photos_index');

        //Upload photo
        Route::post('/places/{place}/photos', 'API\Photo\PlaceController@upload')
            ->name('api.ideas.photos_upload');

        //Set item main photos
        Route::patch('/places/{place}/photos/{photo}/set_main', 'API\Photo\PlaceController@setMain')
            ->name('api.ideas.photos_set_main');

        //Delete item main photos
        Route::delete('/places/{place}/photos/{photo}', 'API\Photo\PlaceController@destroy')
            ->name('api.ideas.photos_destroy');


        /*
         * -------------------------------------------------------------------------
         * PROFILES PHOTOS ROUTING
         * -------------------------------------------------------------------------
         */

        //Get listing of photos
        Route::get('/profiles/{profile}/photos', "API\Photo\ProfileController@index")
            ->name('api.profiles.photos_index');

        //Upload photo
        Route::post('/profiles/{profile}/photos', 'API\Photo\ProfileController@upload')
            ->name('api.profiles.photos_upload');

        //Set item main photos
        Route::patch('/profiles/{profile}/photos/{photo}/set_main', 'API\Photo\ProfileController@setMain')
            ->name('api.profiles.photos_set_main');

        //Delete item main photos
        Route::delete('/profiles/{profile}/photos/{photo}', 'API\Photo\ProfileController@destroy')
            ->name('api.profiles.photos_destroy');



    });

        /*
         * --------------------------------------------------------------------------
         * PLACES
         * --------------------------------------------------------------------------
         */

    //Get listing of places by title
    Route::get('/places/getByTitle', "API\PlaceController@getByTitle")
        ->name('api.place.get_by_title');

    //Get listing of regions and cities by title
    Route::get('/places/getRegionOrCityByTitle', "API\PlaceController@getRegionOrCityByTitle")
        ->name('api.place.get_region_or_city_by_title');

    //Get listing of places by title
    Route::get('/ideas/getByTitle', "API\IdeaController@getByTitle")
        ->name('api.idea.get_by_title');

    //Get listing of places by title
    Route::get('/ideas/main', "API\IdeaController@getMain")
        ->name('api.idea.main');

    Route::get('/ideas/randomIdea', 'API\IdeaController@randomIdea')->name('api.ideas.random_idea');

    // filters

    Route::get('/filters/{filter}/activeItems', "API\FilterController@activeItems")
        ->name('api.filters.active_items');

    // currencies
    Route::get('/currencies/active', "API\CurrencyController@active")
        ->name('api.currencies.active');
});
