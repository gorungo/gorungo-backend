<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Idea;
use App\Http\Resources\Idea as IdeaResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIdea;
use App\Http\Requests\UploadPhoto;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\DB;

class IdeaController extends Controller
{

    protected $idea;

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

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

    public function getAllAvailableTags(){
        return $this->idea->getAllTags();
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
