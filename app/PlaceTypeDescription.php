<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceTypeDescription extends Model
{
    protected $table = 'place_type_descriptions';

    protected $fillable = ['locale_id', 'title'];

    protected $touches = [];

    public $timestamps = false;

    public function place()
    {
        return $this->belongsTo('App\PlaceType', 'place_type_id');
    }
}
