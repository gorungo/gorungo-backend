<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Middleware\LocaleMiddleware;
use App\Http\Requests\OSM\Store;
use App\OSM;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;

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

    public function saveSelected(Store $request)
    {
        if(!$request->id && !OSM::where('place_id', $request->place_id)->first() && OSM::createAndStore($request)){
            return response()->json('Created', 201);
        } else {
            return response()->json('Already exists, not modified', 200);
        }
    }
}
