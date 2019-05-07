<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'address',
            'id' => $this->id,
            'locale' => LocaleMiddleware::getLocale(),

            'attributes' => [
                'country_code' => $this->country_code,
                'city' => $this->city,
                'postal_code' => $this->postal_code,
                'address' => $this->address,
            ],

            'relationships' => [
            ],
        ];
    }
}
