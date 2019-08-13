<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\User;
use App\Http\Requests\User\SetNewPassword;
use App\Profile;
use App\Http\Resources\Profile as ProfileResource;
use Illuminate\Http\Request;
use App\Http\Requests\Profile\StoreProfile;
use App\Http\Requests\Photo\UploadPhoto;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function setNewPassword(SetNewPassword $request, User $user){
        $result = $user->setNewPassword($request);
        return response([
            'type' => $result,
            'message' => $result ? __('profile.password_set'):__('profile.password_not_set')
        ]);
    }
}
