<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryMeta extends Model
{

    protected $table = 'category_metas';
    public $timestamps = false;

    protected $fillable = [ 'category_id', 'locale_id', 'keywords', 'description'];

    protected $touches = ['category'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
