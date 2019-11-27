<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdeaDate extends Model
{
    protected $table = 'idea_dates';
    protected $guarded = [];

    public $timestamps = false;

    public function idea(){
        return $this->belongsTo('App\Idea');
    }
}
