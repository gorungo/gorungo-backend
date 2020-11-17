<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Middleware\LocaleMiddleware;
use App\OSM;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use App\Http\Requests\Place\StoreOSM;

class OSMController extends Controller
{
    protected $osm;

    public function __construct(OSM $osm)
    {
        $this->osm = $osm;
    }

    public function search(Request $request)
    {
        return response()->json($this->osm->search($request));
    }

    public function saveSelected(StoreOSM $request)
    {
        if(!$request->id && OSM::createAndStore($request)){
            return response()->json('Created', 201);
        } else {
            return response()->json('Already exist, not modified', 200);
        }
    }
}
