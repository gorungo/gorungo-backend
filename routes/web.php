<?php

use App\Http\Middleware\LocaleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('/prestart', function(){

});

/*
 * -------------------------------------------------------------------------
 */
Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function() {

    Auth::routes();
    Auth::routes(['verify' => true]);

    //social login

    Route::get('/login/{provider}', 'SocialController@redirectToProvider');
    Route::get('/login/{provider}/callback', 'SocialController@handleProviderCallback');

    //pages
    Route::get('/policies', 'PageController@policies')->name('policies');
    Route::get('/confidential', 'PageController@confidential')->name('confidential');



    // idea crud routes ------------------------------------------------------------------------------------
    Route::get('/ideas/create', 'IdeaController@create')
        ->middleware(['auth','can:create,App\Idea'])
        ->name('ideas.create');
    Route::get('/ideas/{idea}/edit', 'IdeaController@edit')
        ->middleware(['auth','can:update,idea'])
        ->name('ideas.edit');
    Route::post('/ideas', 'IdeaController@store')
        ->middleware(['auth','can:update,idea'])
        ->name('ideas.store');
    Route::patch('/ideas/{idea}', 'IdeaController@update')
        ->middleware(['auth','can:update,idea'])
        ->name('ideas.update');
    Route::delete('/ideas/{idea}', 'IdeaController@destroy')
        ->middleware(['auth','can:delete,idea'])
        ->name('ideas.destroy');
    //------------------------------------------------------------------------------------------------------

    // actions crud routes ------------------------------------------------------------------------------------
    Route::get('/actions/create/{idea?}', 'ActionController@create')
        ->middleware(['auth','can:create,App\Action'])
        ->name('actions.create');
    Route::get('/actions/{action}/edit', 'ActionController@edit')
        ->middleware(['auth','can:update,action'])
        ->name('actions.edit');

    //------------------------------------------------------------------------------------------------------

    // place crud routes ------------------------------------------------------------------------------------
    Route::get('/places/create', 'PlaceController@create')
        ->middleware(['auth','can:create,App\Place'])
        ->name('places.create');
    Route::get('/places/{place}/edit', 'PlaceController@edit')
        ->middleware(['auth','can:update,place'])
        ->name('places.edit');
    //------------------------------------------------------------------------------------------------------


    // blog crud routes ------------------------------------------------------------------------------------
    Route::get('/blog/create', 'PostController@create')
        ->middleware(['auth','can:create,App\Post'])
        ->name('posts.create');
    Route::get('/blog/{post}/edit', 'PostController@edit')
        ->middleware(['auth','can:update,post'])
        ->name('posts.edit');
    //------------------------------------------------------------------------------------------------------

    // profile

    Route::get('/users/{user}/profile', 'ProfileController@edit')
        ->middleware(['auth','can:updateProfile,user'])
        ->name('profile.edit');

    // routes with city

    Route::group(['prefix' => App\Http\Middleware\LocationMiddleware::getLocation()], function () {

        Route::get('/', 'PageController@index')->name('index');

        //Route::get('/posts', 'PostController@getPosts')->name('posts');
        //Route::get('/home', 'HomeController@index')->name('home');

        // Actions show route
        Route::get('ideas/{categories}/-{idea}/actions/{action}', 'IdeaActionController@show')
            ->where(['categories' => '^[a-zA-Z0-9-_\/]+$', 'idea' => '^[a-zA-Z0-9-_\/]+$', 'action' => '^[a-zA-Z0-9-_\/]+$'])
            ->name('actions.show');

        // idea index, show routes -----------------------------------------------------------------------------------------
        Route::get('ideas/{categories?}/-{idea}/actions', 'IdeaActionController@index')
            ->where(['categories' => '^[a-zA-Z0-9-_\/]+$', 'idea' => '^[a-zA-Z0-9-_\/]+$'])
            ->name('ideas.actions_index');
        Route::get('ideas/{categories}/-{idea}', 'IdeaController@show')
            ->where(['categories' => '^[a-zA-Z0-9-_\/]+$', 'idea' => '^[a-zA-Z0-9-_\/]+$'])
            ->name('ideas.show');
        Route::get('ideas/{categories?}', 'IdeaController@index')
            ->where('categories', '^[a-zA-Z0-9-_\/]+$')
            ->name('ideas.index');

        // place ------------------------------------------------------------------------------------------------------

        Route::get('/places/{placeType?}', 'PlaceController@index')
            ->name('places.index');

        // blog -----------------------------------------------

        Route::get('/blog', 'PostController@index')
            ->name('posts.index');

        Route::get('/blog/{post}', 'PostController@show')
            ->name('posts.show');

        // actions  -----------------------------------------------------------------------------------------
        Route::get('actions/{categories?}', 'ActionController@index')
            ->where('categories', '^[a-zA-Z0-9-_\/]+$')
            ->name('actions.index');

        Route::group(['prefix' => 'admin'], function () {

        });
    });



    // pages routes

    //Route::get('/info/{alias?}', "PagesController@show_info")->where(['alias' =>'rules|confidential-policy|rules'])->name('page.show');


    // category routes

    Route::get('category', 'CategoryController@index')
        ->name('category.index');
    Route::get('category/create', 'CategoryController@create')
        ->middleware(['auth','can:create,App\Category'])
        ->name('category.create');
    Route::get('category/{category}/edit', 'CategoryController@edit')
        ->middleware(['auth','can:update,category'])
        ->name('category.edit');
    Route::get('category/{category}', 'CategoryController@show')
        ->middleware(['auth','can:view,category'])
        ->name('category.show');
    Route::post('category', 'CategoryController@store')
        ->middleware(['auth','can:update,category'])
        ->name('category.store');
    Route::patch('category/{category}', 'CategoryController@update')
        ->middleware(['auth','can:update,category'])
        ->name('category.update');
    Route::delete('category/{category}', 'CategoryController@destroy')
        ->middleware(['auth','can:delete,category'])
        ->name('category.destroy');

    // place show
    Route::get('places/{place}', 'PlaceController@show')
        ->name('places.show');


});

//Переключение языков
Route::get('setlocale/{lang}', function ($lang) {

    $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
    $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

    //разбиваем на массив по разделителю
    $segments = explode('/', $parse_url);

    //Если URL (где нажали на переключение языка) содержал корректную метку языка
    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {

        unset($segments[1]); //удаляем метку
    }

    //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
    if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
        array_splice($segments, 1, 0, $lang);
    }

    //формируем полный URL
    $url = Request::root().implode("/", $segments);

    //если были еще GET-параметры - добавляем их
    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url); //Перенаправляем назад на ту же страницу

})->name('setlocale');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

