<?php

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

/*
 * -------------------------------------------------------------------------
 */
Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function() {

    Auth::routes();
    Auth::routes(['verify' => true]);

    //social login

    Route::get('/login/{provider}', 'SocialController@redirectToProvider');
    Route::get('/login/{provider}/callback', 'SocialController@handleProviderCallback');


    // idea crud routes ------------------------------------------------------------------------------------
    Route::get('/ideas/create', 'IdeaController@create')->name('ideas.create');
    Route::get('/ideas/{idea}/edit', 'IdeaController@edit')->name('ideas.edit');
    Route::post('/ideas', 'IdeaController@store')->name('ideas.store');
    Route::patch('/ideas/{idea}', 'IdeaController@update')->name('ideas.update');
    Route::delete('/ideas/{idea}', 'IdeaController@destroy')->name('ideas.destroy');
    //------------------------------------------------------------------------------------------------------

    // actions crud routes ------------------------------------------------------------------------------------
    Route::get('/actions/create/{idea}', 'ActionController@create')->name('actions.create');
    Route::get('/actions/{action}/edit', 'ActionController@edit')->name('actions.edit');
    Route::post('/actions', 'ActionController@store')->name('actions.store');
    Route::patch('/actions/{action}', 'ActionController@update')->name('actions.update');
    Route::delete('/actions/{action}', 'ActionController@destroy')->name('actions.destroy');
    //------------------------------------------------------------------------------------------------------

    // place crud routes ------------------------------------------------------------------------------------
    Route::get('/places/create', 'PlaceController@create')->name('places.create');
    Route::get('/places/{place}/edit', 'PlaceController@edit')->name('places.edit');
    Route::post('/places', 'PlaceController@store')->name('places.store');
    Route::patch('/places/{place}', 'PlaceController@update')->name('places.update');
    Route::delete('/places/{place}', 'PlaceController@destroy')->name('places.destroy');
    //------------------------------------------------------------------------------------------------------


    // routes with city

    Route::group(['prefix' => App\Http\Middleware\LocationMiddleware::getLocation()], function () {

        Route::get('/', 'PagesController@index')->name('index');

        //Route::get('/posts', 'PostController@getPosts')->name('posts');
        //Route::get('/home', 'HomeController@index')->name('home');

        // Actions show route
        Route::get('ideas/{categories?}/-{idea}/actions/{action}', 'IdeaActionController@show')
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

        //------------------------------------------------------------------------------------------------------


        // idea index, show routes -----------------------------------------------------------------------------------------
        Route::get('actions/{categories?}', 'ActionController@index')
            ->name('actions.index');

        Route::group(['prefix' => 'admin'], function () {

        });
    });



    // pages routes

    //Route::get('/info/{alias?}', "PagesController@show_info")->where(['alias' =>'rules|confidential-policy|rules'])->name('pages.show');


    // category routes

    Route::get('category', 'CategoryController@create')->name('category.index');
    Route::get('category/create', 'CategoryController@create')->name('category.create');
    Route::get('category/{category}/edit', 'CategoryController@edit')->name('category.edit');
    Route::get('category/{category}', 'CategoryController@show')->name('category.show');
    Route::post('category', 'CategoryController@store')->name('category.store');
    Route::patch('category/{category}', 'CategoryController@update')->name('category.update');
    Route::delete('category/{category}', 'CategoryController@destroy')->name('category.destroy');


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




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
