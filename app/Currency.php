<?php

namespace App;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    protected $guarded = [];

    public $timestamps = false;

    public function currencyDescriptions()
    {
        return $this->hasMany('App\CurrencyDescription', 'currency_id', 'id');
    }

    public function localisedCurrencyDescription()
    {
        return $this
            ->hasOne('App\CurrencyDescription', 'currency_id', 'id')
            ->where('locale_id', LocaleMiddleware::getLocaleId());
    }

    Public function getLongTitleAttribute()
    {
        if ($this->localisedCurrencyDescription != null) {
            return $this->localisedCurrencyDescription->title;
        } else {
            $description = $this->localisedCurrencyDescription()->first();
            if ($description) {
                return $description->title;
            }
        }

        return $this->title;
    }

    Public function getShortTitleAttribute()
    {
        if ($this->localisedCurrencyDescription != null) {
            return $this->localisedCurrencyDescription->short_title;
        } else {
            $description = $this->localisedCurrencyDescription()->first();
            if ($description) {
                return $description->short_title;
            }
        }

        return $this->title;
    }
}
