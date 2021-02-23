<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdeaPrice extends Model
{
    protected $table = 'idea_prices';
    protected $guarded = [];

    public $timestamps = false;

    protected $attributes = [
        'price' => 0,
        'currency_id' => 3,
    ];

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function idea(){
        return $this->belongsTo('App\Idea');
    }

    public function ideaDate(){
        return $this->belongsTo('App\IdeaDate');
    }


    public function getFormattedPriceAttribute()
    {
        return $this->price ? number_format($this->price / 100, 2, '.', '') : number_format(0, 2, '.', '');
    }
}
