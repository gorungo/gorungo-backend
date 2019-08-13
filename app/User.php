<?php

namespace App;

use App\Http\Requests\User\SetNewPassword;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable  implements MustVerifyEmail
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

    public function profile(){
        return $this->hasOne('App\Profile');
    }

    /**
     * Current geo position of user
     * @return Point
     */
    public static function currentPosition(){
        return new Point('131.9233817', '43.1159235');
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

}
