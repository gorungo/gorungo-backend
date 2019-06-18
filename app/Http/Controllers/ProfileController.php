<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Profile as ProfileResource;

class ProfileController extends Controller
{
    public function edit(Request $request, User $user)
    {
        $profileResource = new ProfileResource($user->profile);
        return view('profile.edit' , compact(['user', 'profileResource']));
    }
}
