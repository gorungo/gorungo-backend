<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdeaDescription extends Model
{
    protected $table = 'idea_descriptions';

    protected $fillable = ['locale_id', 'title', 'intro', 'description'];

    protected $touches = ['idea'];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function idea()
    {
        return $this->belongsTo('App\Idea', 'idea_id');
    }
}
