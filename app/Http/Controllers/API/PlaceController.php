<?php

namespace App\Http\Controllers\API;



use App\Place;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlace;
use App\Http\Requests\UploadPhoto;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Controllers\Controller;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{

    protected $place;

    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     * @param  Place $place
     * @return PlaceResource
     */
    public function create(Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePlace $request
     * @param  Place $place
     * @return PlaceResource
     */
    public function store(StorePlace $request, Place $place)
    {
        return new PlaceResource($place->createAndSync($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Place $place
     * @return PlaceResource
     */
    public function show(Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Place $place
     * @return PlaceResource
     */
    public function edit(Place $place)
    {
        return new PlaceResource($place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StorePlace $request
     * @param  Place $place
     * @return PlaceResource
     */
    public function update(StorePlace $request, Place $place)
    {
        return new PlaceResource($place->updateAndSync($request));
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

    public function getByTitle(Request $request){
        return PlaceResource::collection(Place::getByTitle($request->title));
    }



    /**
     * Return list of items photo
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPhotosListJson(){
        return response()->json($this->idea->ideaPhotos()->isActive()->get());
    }

    /**
     * Return list of items photo
     * @param UploadPhoto $request
     * @param $itemId
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhoto(UploadPhoto $request, $itemId){

        $idea = Idea::where('id', $itemId)->first();
        if($idea) return response()->json($idea->uploadPhoto($request));

        return response()->json(['type' => 'error', 'itemId' => $itemId]);
    }
}
