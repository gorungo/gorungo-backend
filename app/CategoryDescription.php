<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDescription extends Model
{
    protected $table = 'category_descriptions';
    public $timestamps = false;

    protected $fillable = [ 'category_id', 'locale_id', 'description'];

    protected $touches = ['category'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
