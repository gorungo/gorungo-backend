<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request){
        $http = new \GuzzleHttp\Client;

        try {
            $response = $http->post(config('app.url').config('auth.passport.login_endpoint'),[
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('auth.passport.client_id'),
                    'client_secret' => config('auth.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);

            return $response->getBody();

        } catch (\GuzzleHttp\Exception\BadResponseException $e){
            if($e->getCode() == 400){
                return response()->json([
                    'type' => 'error',
                    'code' => $e->getCode(),
                    'description' => 'Invalif Request. Please enter a username or a password. ', $e->getCode(),
                ]);
            } else if($e->getCode() == 401){
                return response()->json();
            }
        }
    }

    public function logout()
    {
        Auth()->user()->tokens->each(function($token, $key){
            $token->delete();
        });

        return response()->json(['type'=>'ok']);
    }
}
