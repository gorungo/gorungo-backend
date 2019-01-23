<?php

namespace App\Traits;

use App\Photo;
use Conner\Tagging\Model\Tag;
use Illuminate\Support\Facades\Cache;


trait PhotoTrait
{

    public function photos()
    {
        return $this->morphMany('App\Photo', 'item');
    }

}