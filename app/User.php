<?php

namespace App;

use App\Http\Requests\User\SetNewPassword;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPUnit\Runner\Exception;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\User as UserResource;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function ideas()
    {
        return $this->hasMany('App\Idea', 'author_id');
    }

    public function actions()
    {
        return $this->hasMany('App\Action', 'author_id');
    }


    /**
     * User name to display at the screen
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        if(isset($this->profile) && $this->profile->name !== ''){
            return $this->profile->name;
        }
        return $this->name;

    }

    /**
     * Get path to tmb img of category item
     * @return string
     */
    Public function getTmbImgPathAttribute()
    {

        $defaultTmb = 'images/interface/placeholders/idea.png';

        if ($this->profile && $this->profile->thmb_file_name != null) {
            //если есть картинка вакансии
            $src = 'storage/images/profile/' . $this->profile->id . '/' . htmlspecialchars(strip_tags($this->profile->thmb_file_name));

        } else {
            //если есть картинка вакансии
            $src = $defaultTmb;
        }

        if (!file_exists($src)) {
            $src = $defaultTmb;
        }

        return $src;
    }

    /**
     * Current geo position of user
     * @return Point
     */
    public static function currentPosition(){

        $coordinates = null;
        $updatePeriod = 60*60*24; // 1 day
        $currentDateTime = date("Y-m-d H:i:s");

        // if we have request string like ?pl=lat897498327498lon9873495798
        if(Place::placeMode() === 'coordinates'){

            [$lat, $lon] = explode('lng', request()->pl);

            if($lon !== ''){
                $coordinates = [
                    'lat' => substr($lat, 3) ?? 0,
                    'lng' => $lon ?? 0,
                    'country' => $obj->country ?? null,
                    'city' => $obj->city ?? null,
                    'time' => date("Y-m-d H:i:s"),
                ];
                session()->put('current_user_position', $coordinates);
            }


        } else{
            if(session()->has('current_user_position')){
                $coordinates = session()->get('current_user_position');
                if(strtotime($currentDateTime) - strtotime($coordinates['time'] > $updatePeriod)){
                    $coordinates = null;
                }
            }

            if(!$coordinates){
                // Получаем координаты пользователя если их нет в сессии

                $ip = request()->ip() == '127.0.0.1' ? '5.100.94.143' : request()->ip();

                try{
                    $client = new \GuzzleHttp\Client();
                    $body = $client->get('https://ipinfo.io/'. $ip .'/geo')->getBody();
                    $obj = json_decode($body);

                    [$lat, $lang] = explode(',', $obj->loc);

                    $coordinates = [
                        'lat' => $lat ?? 0,
                        'lng' => $lang ?? 0,
                        'country' => $obj->country ?? null,
                        'city' => $obj->city ?? null,
                        'time' => date("Y-m-d H:i:s"),
                    ];

                    session()->put('current_user_position', $coordinates);
                    Log::info('Position Updated @'.$coordinates['lat'].' '.$coordinates['lng']);

                }catch(\Exception $exception){
                    Log::info('https://ipinfo.io/geo service unavailable');
                }


            }
        }



        return new Point($coordinates['lng'], $coordinates['lat']);
    }


    /**
     * saving new user pwd
     * @var SetNewPassword $request
     * @return boolean
     */
    public function setNewPassword(SetNewPassword $request)
    {
        $this->password = bcrypt($request->input('password.new'));
        return $this->save();
    }

    public static function activeUser()
    {
        return Auth()->guest() ? null : self::find(Auth()->User()->id);
    }

    public static function activeUserResource()
    {
        return Auth()->guest() ? null : new UserResource(self::activeUser());
    }

    public function hasDraftIdeas()
    {
        return self::ideas()->where('is_approved', 0)->count();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
