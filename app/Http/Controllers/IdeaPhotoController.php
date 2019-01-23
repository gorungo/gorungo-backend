<?php

namespace App\Http\Controllers;

use App\Idea;
use App\Photo;
use App\Http\Requests\UploadPhoto;
use App\Http\Requests\SetMainPhoto;
use Illuminate\Http\Request;

class IdeaPhotoController extends Controller
{

    protected $idea;

    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * Get photos list
     * @param Idea $idea
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Idea $idea)
    {
        return response()->json(['files' => $idea->ideaPhotos()->get()]);
    }

    /**
     * Upload new photo
     * @param UploadPhoto $request
     * @param Idea $idea
     * @return \Illuminate\Http\JsonResponse
     */

    public function upload(UploadPhoto $request, Idea $idea)
    {
        return response()->json(['file' => $idea->uploadPhoto($request)]);
    }

    /**
     * Set image as main
     * @param SetMainPhoto $request
     * @param Idea $idea
     * @param Photo $photo
     * @return \Illuminate\Http\JsonResponse
     */

    public function setMain(SetMainPhoto $request, Idea $idea, Photo $photo)
    {
        return response()->json($photo->setMain());
    }

    /**
     * Set image as main
     * @param SetMainPhoto $request
     * @param Idea $idea
     * @param Photo $photo
     * @throws \Exception
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(SetMainPhoto $request, Idea $idea, Photo $photo)
    {

        if ($photo->deletePhoto()) {
            $photo->delete();
            return response()->json(['type' => 'ok']);
        }

        return response()->json(['type' => 'error']);

    }

}
