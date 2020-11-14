<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\OSM;
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

    public function store(StoreOSM $request)
    {
        $omsData = $request->input();
        OSM::create($omsData);
        return response()->json('Created', 201);
    }
}
