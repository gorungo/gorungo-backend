<?php

namespace App\Traits;

use App\Photo;
use App\Http\Requests\Photo\UploadPhoto;


trait Imageble
{

    public function photos()
    {
        return $this->morphMany('App\Photo', 'item');
    }

    public function uploadPhoto(UploadPhoto $request)
    {
        $photo = New Photo();
        return $photo->createAndStore($request, $this);
    }

}