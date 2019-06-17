<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ExtendedTagController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $categories = null)
    {

    }

    /**
     * Show the form for creating a new resource.
     * @param  Idea $idea
     * @return IdeaResource
     */
    public function create(Idea $idea)
    {
        return new IdeaResource($idea);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreIdea $request
     * @param  Idea $idea
     * @return IdeaResource
     */
    public function store(StoreIdea $request, Idea $idea)
    {
        return new IdeaResource($idea->createAndSync($request));
    }

    /**
     * Display the specified resource.
     *
     * @param Idea $idea
     * @return IdeaResource
     */
    public function show(Idea $idea)
    {
        return new IdeaResource($idea);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Idea $idea
     * @return IdeaResource
     */
    public function edit(Idea $idea)
    {
        return new IdeaResource($idea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreIdea $request
     * @param  Idea $idea
     * @return IdeaResource
     */
    public function update(StoreIdea $request, Idea $idea)
    {
        return new IdeaResource($idea->updateAndSync($request));
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