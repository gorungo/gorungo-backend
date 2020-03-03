<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItineraryDescription extends Model
{
    protected $table = 'itinerary_descriptions';

    protected $fillable = ['title', 'description', 'what_included', 'will_visit', 'locale_id'];

    protected $touches = ['itinerary'];

    public $timestamps = false;

    public function itinerary()
    {
        return $this->belongsTo('App\Itinerary', 'itinerary_id');
    }

}
