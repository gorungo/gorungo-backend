<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategoryTitle extends Model
{
    protected $table = 'post_category_titles';
    public $timestamps = false;
    protected $fillable = [ 'post_category_id', 'locale_id', 'title', 'intro'];

    protected $touches = ['category'];

    public function postCategory()
    {
        return $this->belongsTo('App\Category', 'post_category_id');
    }
}
