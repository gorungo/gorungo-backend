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

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price ? number_format($this->price, 2, '.', '') : number_format(0, 2, '.', '');
    }
}
