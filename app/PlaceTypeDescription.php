<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceTypeDescription extends Model
{
    protected $table = 'place_type_descriptions';

    protected $fillable = ['locale_id', 'title', 'place_type_id'];

    protected $touches = [];

    public $timestamps = false;

    public function place()
    {
        return $this->belongsTo('App\PlaceType', 'place_type_id');
    }
}
