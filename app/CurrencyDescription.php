<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyDescription extends Model
{
    protected $table = 'currency_descriptions';
    protected $guarded = [];

    public $timestamps = false;
}
