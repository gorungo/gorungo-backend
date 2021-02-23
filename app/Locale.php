<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $table = 'locales';
    protected $guarded = [];
    public $timestamps = false;

    public function address()
    {
        return $this->belongsTo('App\Address', 'address_id');
    }
}
