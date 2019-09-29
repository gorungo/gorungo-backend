<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionPrice extends Model
{
    protected $table = 'action_prices';
    protected $guarded = [];

    public $timestamps = false;

    protected $attributes = [
        'price' => 0,
        'currency_id' => 3,
    ];

    public function Currency()
    {
        return $this->belongsTo('App\Currency');
    }
}
