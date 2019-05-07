<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\LocaleMiddleware;
use App\Category;
use App\Idea;
use Auth;



class PagesController extends Controller
{
    public function index(Request $request){

        // получаем список главных категорий
        $mainCategories = Cache::remember('mainCategories_'.LocaleMiddleware::getLocale(), 10, function () {
            return Category::MainCategory()->IsActive()->get();
        });

        if(!session()->has('prestart')){
            return view('prestart');
        }
        return view('index', compact(['mainCategories']));
    }

    /**
     * Show information from pages by alias
     *
     * @return \Illuminate\Http\Response
     */
    public function show_info($alias = ''){

        //устанавливаем текущий адрес как валидный для возврата
        $this->set_last_valid_url();

        if($alias != ''){
            $item = Pages::where('alias', $alias)->first();

        }else{
            $item = Pages::where('alias', 'info')->first();
        }
        if(!$item){
            abort('404');
        }
        return view('pages.index', compact(['item']));
    }

    public function success()
    {
        if(isset(Auth()->user()->id)){

            // только зарегистрировались, и еще не отправляли информацию об успешной регистрации
            $user = Auth()->user();

            if(config('app.send_mail_notification') == 'true' ){
                if($user->status == 0){
                    try {

                        log:debug('Заходили в блок отправки сообщений');

                        // Уведомляем пользователя о регистрации, а также админа.
                        Auth()->user()->notify(new UserRegister());

                        Notification::send(User::find(1), new UserRegister());

                    }catch(\Exception $e){
                        //Если письмо не отправилось
                        Log::error('Письмо о регистрации не отправилось: '. $e);

                    }

                    // сохраняем инфу, что юзеру выслали
                    $user->status = 1;
                    $user->save();

                }else{
                    Log::debug('Не отправили письмо при регистрации т.к. статус пользователя уже 1');
                }

            }else{
                Log::debug('Не отправили письмо при регистрации т.к. отправка уведомлений выключена');
            }

            return view('auth.success');

        }

        abort('404');


    }

    public function mailtest(){

        $data = array('name'=>"Virat Gandhi");

        $mailer = app()['mailer'];

        $mailer->send('email.email', $data, function($message) {
            $message->to('inkas_art@mail.ru', 'Denis Petrov')->subject
            ('Laravel Basic Testing Mail');
            $message->from('hello@dvstaff.ru','Denis Petrov');
        });

        echo "Проверяй почту";
    }

    public function redirect_todvstaff(){
        return redirect()->to('http://dvstaff.ru');

    }

}
