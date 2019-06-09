<?php
namespace App\Http\Middleware;

use Closure;
use App;
use Request;
use App\Locale;

class LocaleMiddleware
{
    public static $mainLanguage = 'ru'; //основной язык, который не должен отображаться в URl
    public static $languages = ['en', 'ru', 'ch']; // Указываем, какие языки будем использовать в приложении.


    public function __construct()
    {

    }

    /*
     * Проверяет наличие корректной метки языка в текущем URL
     * Возвращает метку или значеие null, если нет метки
     */
    public static function getLocale()
    {
        $uri = Request::path(); //получаем URI

        $request = Request::input();

        if(isset($request['locale']) && in_array($request['locale'], self::$languages)){
            return $request['locale'] !== self::$mainLanguage ? $request['locale']:null;
        }else{

            $segmentsURI = explode('/', $uri); //делим на части по разделителю "/"

            //Проверяем метку языка  - есть ли она среди доступных языков
            if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::$languages)) {
                if ($segmentsURI[0] != self::$mainLanguage) return $segmentsURI[0];
            }
        }


        return null;
    }

    /*
 * Проверяет наличие корректной метки языка в текущем URL
 * Возвращает id метки или значеие 1, если нет метки (значит дифолтный локэил)
 */
    public static function getLocaleId($localeName = '')
    {
        if($localeName === '') {
            $locale = self::getLocale();
        }else{
            $locale = $localeName;
        }

        if($locale){
            $key = array_search($locale, self::$languages);

            if($key !== Null){
                return $key + 1;
            }
        }else{
            $key = array_search(self::$mainLanguage, self::$languages);

            if($key !== Null){
                return $key + 1;
            }
        };

        return 1;
    }

    public function isValidLocaleSymbol($localeSymbol){
        return in_array($localeSymbol, self::$languages);
    }

    /**
    * Устанавливает язык приложения в зависимости от метки языка из URL
    */
    public function handle($request, Closure $next)
    {
        $locale = self::getLocale();

        if($locale) App::setLocale($locale);
        //если метки нет - устанавливаем основной язык $mainLanguage
        else App::setLocale(self::$mainLanguage);

        return $next($request); //пропускаем дальше - передаем в следующий посредник
    }

    /**
     * Имя пользовательской локали из запроса
     */
    public function getUserLanguageFromRequest(){
        // parsing string like this 'en-GB,en;q=0.8'
        return explode(explode(request()->server('HTTP_ACCEPT_LANGUAGE'), ';')[0],',')[0];
    }

}