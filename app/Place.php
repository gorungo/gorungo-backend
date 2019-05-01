<?php

namespace App;

use DB;
use GeoJson\Geometry\Geometry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use App\Http\Requests\StorePlace;
use App\Http\Middleware\LocaleMiddleware;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Support\Jsonable;

class Place extends Model
{
    use SoftDeletes, SpatialTrait;

    protected $table = 'places';

    protected $perPage = 60;

    protected $dates = ['deleted_at'];

    protected $fillable = ['coordinates'];

    protected $with = ['localisedPlaceDescription'];

    public $timestamps = false;

    protected $spatialFields = [
        'coordinates',
    ];

    public function placeActions()
    {
        return $this->belongsToMany('App\Action', 'action_place');
    }

    public function placeAddress()
    {
        return $this->belongsTo('App\Address', 'address_id');
    }

    public function placePhotos()
    {
        return $this->morphMany('App\Photo', 'item');
    }

    public function placeDescriptions()
    {
        return $this->hasMany('App\PlaceDescription', 'place_id', 'id');
    }


    public function localisedPlaceDescription()
    {
        return $this
            ->hasOne('App\PlaceDescription', 'place_id', 'id')
            ->where('place_id', LocaleMiddleware::getLocaleId());
    }

    Public function getTitleAttribute()
    {
        if ( $this->placeDescriptions()->count() ) {
            if($this->localisedPlaceDescription != null){
                return $this->localisedPlaceDescription->title;
            }else if($this->placeDescriptions()->first()){
                return $this->placeDescriptions()->first()->title;
            }

        }
        return '';
    }

    Public function getIntroAttribute()
    {
        if ( $this->placeDescriptions()->count() ) {
            if($this->localisedPlaceDescription != null){
                return $this->localisedPlaceDescription->intro;
            }else if($this->placeDescriptions()->first()){
                return $this->placeDescriptions()->first()->intro;
            }

        }
        return '';
    }

    Public function getDescriptionAttribute()
    {
        if ( $this->placeDescriptions()->count() ) {
            if($this->localisedPlaceDescription != null){
                return $this->localisedPlaceDescription->description;
            }else if($this->placeDescriptions()->first()){
                return $this->placeDescriptions()->first()->description;
            }

        }
        return '';
    }

    Public function getUrlAttribute()
    {
        return route('locations.show', [$this->id]);
    }

    /**
     * Get path to tmb img of category item
     * @return string
     */
    Public function getTmbImgPathAttribute()
    {
        $defaultTmb = 'images/interface/placeholders/location.png';
        return $defaultTmb;
    }


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    public static function getByTitle(String $title){
        return self::whereHas('placeDescriptions', function ($query) use ($title) {
            $query->where('title', 'like' , '%' . $title . '%');
        })->take(20)->get();
    }

    public function createAndSync( StorePlace $request ){

        $createResult = DB::transaction(function () use ($request) {

            $localeId = LocaleMiddleware::getLocaleId();

            $storeData = [
                'coordinates' => new Point(
                    $request->input('attributes.coordinates.coordinates')[1],
                    $request->input('attributes.coordinates.coordinates')[0]
                ),

                'address_id' => $request->input('attributes.address_id'),
            ];

            $descriptionStoreData = [
                'title' => $request->input('attributes.title'),
                'intro' => $request->input('attributes.intro'),
                'description' => $request->input('attributes.description'),
                'locale_id' => $localeId,
            ];

            $place = self::create($storeData);
            $place->localisedPlaceDescription()->create($descriptionStoreData);

            $place->updateRelationships( $request );

            return $place;

        });

        return $createResult;
    }

    public function updateAndSync( StorePlace $request ) {

        $updateResult = DB::transaction( function () use ( $request ) {

            $localeId = LocaleMiddleware::getLocaleId();

            $storeData = [
                'coordinates' => new Point(
                    $request->input('attributes.coordinates.coordinates')[1],
                    $request->input('attributes.coordinates.coordinates')[0]),
            ];

            $descriptionStoreData = [
                'title' => $request->input('attributes.title'),
                'intro' => $request->input('attributes.intro'),
                'description' => $request->input('attributes.description'),
                'locale_id' => $localeId,
            ];

            $this->update( $storeData );
            $this->localisedPlaceDescription()->update($descriptionStoreData);
            $this->updateRelationships( $request );


            return $this;

        } );

        return $updateResult;

    }

    private function updateRelationships( StorePlace $request ) : void
    {
        $this->saveAddress( $request );
    }

    private function saveAddress( $request )
    {

    }
}
