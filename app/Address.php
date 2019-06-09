<?php

namespace App;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $perPage = 60;
    protected $guarded = [];

    public $timestamps = false;


    Public function getLocalityAttribute() {
        if ( $this->addressDescriptions()->count() ) {
            if($this->localisedAddressDescription != null){
                return $this->localisedAddressDescription->locality;
            }else if($this->addressDescriptions()->first()){
                return $this->addressDescriptions()->first()->locality;
            }

        }
        return '';
    }

    Public function getFullAddressAttribute() {
        return $this->locality;
    }

    Public function getIntroAttribute() {
        if ( $this->addressDescriptions()->count() ) {
            if($this->localisedAddressDescription != null){
                return $this->localisedAddressDescription->intro;
            }else if($this->addressDescriptions()->first()){
                return $this->addressDescriptions()->first()->intro;
            }

        }
        return '';
    }

    Public function getDescriptionAttribute() {
        if ( $this->addressDescriptions()->count() ) {
            if($this->localisedAddressDescription != null){
                return $this->localisedAddressDescription->description;
            }else if($this->addressDescriptions()->first()){
                return $this->addressDescriptions()->first()->description;
            }

        }
        return '';
    }

    public function addressDescriptions() {
        return $this->hasMany( 'App\AddressDescription', 'address_id', 'id' );
    }


    public function localisedAddressDescription() {
        return $this
            ->hasOne( 'App\AddressDescription', 'address_id', 'id' )
            ->where( 'locale_id', LocaleMiddleware::getLocaleId() );
    }

    public function hasLocaleName( $localeName ) {
        return $this
            ->hasOne( 'App\AddressDescription', 'address_id', 'id' )
            ->where( 'locale_id', LocaleMiddleware::getLocaleId( $localeName ) )
            ->count();
    }

    public function hasLocaleId( $localeId ) {
        return $this
            ->hasOne( 'App\AddressDescription', 'address_id', 'id' )
            ->where( 'locale_id', $localeId )->count();

    }

}
