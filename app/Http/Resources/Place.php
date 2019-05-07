<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Address;
use App\Http\Resources\Address as AddressResource;
use App\Http\Resources\PlaceType as PlaceTypeResource;

class Place extends JsonResource
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
            'type' => 'Places',
            'id' => $this->id ,
            'locale' => LocaleMiddleware::getLocale() ,

            'attributes' => [
                'title' => $this->title,
                'url' => $this->url,
                'edit_url' => $this->editUrl,
                'description' => $this->description,
                'intro' => $this->intro,
                'coordinates' =>$this->id ? $this->coordinates : [
                    'coordinates' => [null,null]
                ],
            ],

            'relationships' => [
                'place_type' => new PlaceTypeResource($this->placeType),
                'address' => $this->placeAddress ? $this->placeAddress : new AddressResource(new Address),
            ],
        ];
    }
}
