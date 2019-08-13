<?php
namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;
class PostCategory extends Pivot {

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function postCategory()
    {
        return $this->belongsTo('App\PostCategory');
    }


}