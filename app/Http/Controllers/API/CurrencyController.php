<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Currency;
use App\Http\Resources\Currency as CurrencyResource;



class CurrencyController extends Controller
{
    public function active(Request $request)
    {
        return response(CurrencyResource::collection(Currency::all()));
    }

}
