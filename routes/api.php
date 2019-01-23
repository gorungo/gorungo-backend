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


    Route::get('categories', 'Api\CategoryController@index')->name('category.index');
    Route::get('categories/{category}', 'Api\CategoryController@show')->name('category.show');
    Route::get('categories/{categoryId}/fullcategorieslisting', 'Api\CategoryController@fullCategoriesListing')->name('category.fullcategorieslisting');
    Route::get('categories/{categoryId}/child', 'Api\CategoryController@child')->name('category.child');

    /*
     * -------------------------------------------------------------------------
     * IDEAS PHOTOS ROUTING
     * -------------------------------------------------------------------------
     */

    //Get listing of photos
    Route::get('/ideas/{idea}/photos', "IdeaPhotoController@index")
        ->name('ideas.photos_index');

    //Upload photo
    Route::post('/ideas/{idea}/photos', 'IdeaPhotoController@upload')
        ->name('ideas.photos_upload');

    //Set item main photos
    Route::patch('/ideas/{idea}/photos/{photo}/set_main', 'IdeaPhotoController@setMain')
        ->name('ideas.photos_set_main');

    //Delete item main photos
    Route::delete('/ideas/{idea}/photos/{photo}', 'IdeaPhotoController@destroy')
        ->name('photos.photos_destroy');

});
