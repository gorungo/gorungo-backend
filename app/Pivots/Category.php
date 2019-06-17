<?php
namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;
class Category extends Pivot {

    public function idea()
    {
        return $this->belongsTo('App\Idea');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function actions()
    {
        return $this->hasManyThrough('App\Action', 'App\Idea');
    }

}