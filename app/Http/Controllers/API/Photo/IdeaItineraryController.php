<?php

namespace App\Http\Controllers\API\Photo;

use App\Idea;
use App\Itinerary;
use App\Photo;
use App\Http\Requests\Photo\UploadPhoto;
use App\Http\Requests\Photo\DestroyPhoto;
use App\Http\Requests\Photo\SetMainPhoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IdeaItineraryController extends Controller
{

    protected $idea;
    protected $itinerary;

    public function __construct(Idea $idea, Itinerary $itinerary)
    {
        $this->idea = $idea;
        $this->itinerary = $itinerary;
    }

    /**
     * Get photos list
     * @param Idea $idea
     * @param Itinerary $itinerary
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Idea $idea, Itinerary $itinerary)
    {
        return response()->json(['files' => $itinerary->photos()->get()]);
    }

    /**
     * Upload new photo
     * @param UploadPhoto $request
     * @param Idea $idea
     * @param Itinerary $itinerary
     * @return \Illuminate\Http\JsonResponse
     */

    public function uploadMain(UploadPhoto $request, Idea $idea, Itinerary $itinerary)
    {
        return response()->json(['file' => $itinerary->uploadPhoto($request)]);
    }

    /**
     * Upload new photo
     * @param UploadPhoto $request
     * @param Idea $idea
     * @param Itinerary $itinerary
     * @return \Illuminate\Http\JsonResponse
     */

    public function upload(UploadPhoto $request, Idea $idea, Itinerary $itinerary)
    {
        return response()->json(['file' => $itinerary->uploadPhoto($request)]);
    }

    /**
     * Set image as main
     * @param SetMainPhoto $request
     * @param Idea $idea
     * @param Itinerary $itinerary
     * @param Photo $photo
     * @return \Illuminate\Http\JsonResponse
     */

    public function setMain(SetMainPhoto $request, Idea $idea, Itinerary $itinerary, Photo $photo)
    {
        return response()->json($photo->setMain());
    }

    /**
     * Set image as main
     * @param DestroyPhoto $request
     * @param Itinerary $itinerary
     * @param Photo $photo
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(DestroyPhoto $request, Idea $idea, Itinerary $itinerary, Photo $photo)
    {

        if ($photo->deletePhoto()) {
            $photo->delete();
            return response()->json(['type' => 'ok']);
        }

        return response()->json(['type' => 'error']);

    }

}
