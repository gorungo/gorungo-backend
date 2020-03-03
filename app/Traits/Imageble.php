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

    public function uploadMainPhoto(UploadPhoto $request)
    {
        $photo = New Photo();
        return $photo->createAndStore($request, $this, true);
    }

    /**
     * Get path to tmb img of item
     * @return string
     */
    public function getTmbImgPathAttribute()
    {

        if ($this->thmb_file_name != null) {
            //если есть картинка вакансии
            $src = 'storage/images/'.class_basename(get_class($this)).'/'.$this->id.'/'.htmlspecialchars(strip_tags($this->thmb_file_name));
        } else {
            //если есть картинка вакансии
            $src = $this->defaultTmb;
        }

        if (!file_exists($src)) {
            $src = $this->defaultTmb;
        }

        return $src;
    }

    public function getFullTmbImgPathAttribute()
    {
        return asset($this->tmbImgPath);
    }

}