<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressDescription extends Model
{
    protected $table = 'address_descriptions';
    protected $guarded = [];
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(!$this->id){
            $this->attributes['address'] = 'sdfds';
            $this->attributes['country'] = 'russia';
            $this->attributes['region'] = 'prim';
            $this->attributes['city'] = 'vladivostok';

        }
    }

    public function address()
    {
        return $this->belongsTo('App\Address', 'address_id');
    }
}
