<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdeaDate extends Model
{
    protected $table = 'idea_dates';
    protected $guarded = [];

    protected $with = ['ideaPrice'];

    public $timestamps = false;

    public function idea(){
        return $this->belongsTo('App\Idea');
    }

    public function ideaPrices(){
        return $this->hasMany('App\IdeaPrice');
    }

    public function ideaPrice(){
        return $this->hasOne('App\IdeaPrice');
    }

    public function scopeInFuture($query)
    {
        return $query->where(function ($query) {
            $query->whereRaw("TO_DAYS(NOW()) < TO_DAYS(`start_date`)");
        });
    }

}
