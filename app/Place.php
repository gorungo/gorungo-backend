<?php

namespace App;

use App\Traits\Imageble;
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
use Kyslik\ColumnSortable\Sortable;

class Place extends Model
{
    use SoftDeletes, SpatialTrait, Imageble, Sortable;

    protected $table = 'places';

    protected $perPage = 60;

    protected $dates = ['deleted_at'];

    protected $fillable = ['place_type_id','coordinates'];

    protected $with = ['localisedPlaceDescription', 'placeDescriptions'];

    public $timestamps = false;

    protected $spatialFields = [
        'coordinates',
    ];

    public $sortable = [
        'updated_at',
        'rating',
        'distance',
        'title'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function placeType()
    {
        return $this->belongsTo('App\PlaceType', 'place_type_id');
    }

    public function placeActions()
    {
        return $this->belongsToMany('App\Action', 'action_place');
    }

    public function placeAddress()
    {
        return $this->hasOne('App\Address');
    }

    public function placeDescriptions()
    {
        return $this->hasMany('App\PlaceDescription', 'place_id', 'id');
    }

    public function localisedPlaceDescription()
    {
        return $this
            ->hasOne('App\PlaceDescription', 'place_id', 'id')
            ->where('locale_id', LocaleMiddleware::getLocaleId());
    }


    public function getUrlAttribute()
    {
        return route('places.show', [$this->id]);
    }

    public function getEditUrlAttribute()
    {
        return route('places.edit', [$this->id]);
    }

    Public function getTitleAttribute()
    {

            if($this->localisedPlaceDescription != null){
                return $this->localisedPlaceDescription->title;
            }else if($this->placeDescriptions()->first()){
                return $this->placeDescriptions()->first()->title;
            }


        return '';
    }

    Public function getIntroAttribute()
    {

        if($this->localisedPlaceDescription != null){
            return $this->localisedPlaceDescription->intro;
        }else if($this->placeDescriptions()->first()){
            return $this->placeDescriptions()->first()->intro;
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

    /**
     * Get path to tmb img of category item
     * @return string
     */
    Public function getTmbImgPathAttribute2()
    {
        $defaultTmb = 'images/interface/placeholders/location.png';
        return $defaultTmb;
    }

    /**
     * Get path to tmb img of category item
     * @return string
     */
    Public function getTmbImgPathAttribute() {

        $defaultTmb = 'images/interface/placeholders/idea.png';

        if ( $this->thmb_file_name != null ) {
            //если есть картинка вакансии
            $src = 'storage/images/place/' . $this->id . '/' . htmlspecialchars( strip_tags( $this->thmb_file_name ) );

        } else {
            //если есть картинка вакансии
            $src = $defaultTmb;
        }

        if ( !file_exists( $src ) ) {
            $src = $defaultTmb;
        }

        return $src;
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

    public static function itemsList(Request $request, $maxDistance = 50)
    {
        // получаем список активных идей с учетом города, страницы, локали
        return Cache::remember('places_' . LocaleMiddleware::getLocale() . '_page_' . request()->page, 0, function () use ($maxDistance) {
            return self::distance('coordinates', User::startingPoint(), $maxDistance)
                ->joinDescription()
                ->sortable()
                ->paginate();
        });
    }

    public function createAndSync( StorePlace $request ){

        $createResult = DB::transaction(function () use ($request) {

            $localeId = LocaleMiddleware::getLocaleId();

            $storeData = [
                'place_type_id' => $request->input('relationships.placeType.id'),
                'coordinates' => new Point(
                    $request->input('attributes.coordinates.coordinates')[1],
                    $request->input('attributes.coordinates.coordinates')[0]
                ),
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
                'place_type_id' => $request->input('relationships.placeType.id'),
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

        $localeId = LocaleMiddleware::getLocaleId();
        $address['country_code'] = 'RU';
        //$address['country_code'] = $request->input('relationships.address.attributes.country_code');

        $address['postal_code'] = $request->input('relationships.address.attributes.postal_code');


        $addressDescription['locale_id'] = $request->input('relationships.address.locale_id') !== null ? $request->input('relationships.address.locale_id') : $localeId;
        $addressDescription['address'] = $request->input('relationships.address.attributes.address');
        $addressDescription['region'] = $request->input('relationships.address.attributes.region');
        $addressDescription['city'] = $request->input('relationships.address.attributes.city');
        $addressDescription['country'] = $request->input('relationships.address.attributes.country');

        if($request->input('relationships.address.id')){
            $address = $this
                ->placeAddress()
                ->where('id', (int)$request->input('relationships.address.id'))
                ->update($address);

            if($this->placeAddress->localisedAddressDescription){
                $this->placeAddress->localisedAddressDescription()->update($addressDescription);
            }else{
                $this->placeAddress->localisedAddressDescription()->create($addressDescription);
            }


        }else{


            $address = $this
                ->placeAddress()
                ->create($address);

            $address
                ->localisedAddressDescription()
                ->create($addressDescription);
        }

    }

    public function scopeJoinDescription($query)
    {
        return $query->join('place_descriptions', function ($join) {
            $join->on('places.id', '=', 'place_descriptions.place_id')
                ->where('locale_id', LocaleMiddleware::getLocaleId());
        })->select('places.*', 'place_descriptions.title','place_descriptions.intro' );
    }

    public function scopeIsActive($query){
        return $query;
    }

    public function distanceSortable($query, $direction)
    {
        return $query->orderByDistance('coordinates', User::startingPoint(), $direction);
    }

    public function titleSortable($query, $direction)
    {
        return $query->orderBy('place_descriptions.title', $direction);
    }

    public function ratingSortable($query, $direction)
    {
        return $query->orderBy('place_descriptions.title', $direction);
    }
}