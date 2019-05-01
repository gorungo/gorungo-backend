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

    Route::get('/test', function (Request $request) {
        return ['result' => 'ok'];
    });

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');

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

    Route::get('/ideas/extended_tags', 'API\IdeaController@getAllAvailableTags')->name('api.ideas.get_all_available_tags');

    // places
    Route::get('/places/create', 'API\PlaceController@create')->name('api.places.create');
    Route::get('/places/{place}/edit', 'API\PlaceController@edit')->name('api.places.edit');
    Route::post('/places', 'API\PlaceController@store')->name('api.places.store');
    Route::patch('/places/{place}', 'API\PlaceController@update')->name('api.places.update');
    Route::delete('/places/{place}', 'API\PlaceController@destroy')->name('api.places.destroy');



    Route::get('categories', 'API\CategoryController@index')->name('category.index');
    Route::get('categories/children', 'API\CategoryController@lastChildren')->name('category.last_children');
    Route::get('categories/{category}', 'API\CategoryController@show')->name('category.show');
    Route::get('categories/{categoryId}/fullcategorieslisting', 'Api\CategoryController@fullCategoriesListing')->name('category.fullcategorieslisting');
    Route::get('categories/{categoryId}/child', 'API\CategoryController@child')->name('category.child');



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
     * --------------------------------------------------------------------------
     * PLACES
     * --------------------------------------------------------------------------
     */

    //Get listing of places by title
    Route::get('/places/get_by_title', "API\PlaceController@getByTitle")
        ->name('api.place.get_by_title');



});
