<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OSMDescription extends Model
{
    protected $table = 'osm_descriptions';
    public $timestamps = false;
    protected $fillable = ['place_id', 'locale_id', 'title', 'display_name'];
}
