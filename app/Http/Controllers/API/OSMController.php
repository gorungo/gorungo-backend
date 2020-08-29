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
}
