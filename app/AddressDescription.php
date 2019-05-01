<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressDescription extends Model
{
    protected $table = 'address_descriptions';
    protected $guarded = [];
    protected $touches = ['address'];

    public $timestamps = false;

    public function address()
    {
        return $this->belongsTo('App\Address', 'address_id');
    }
}
