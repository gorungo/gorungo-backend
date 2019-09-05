<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use App\Http\Resources\Address as AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Address;
use App\Http\Resources\PlaceType as PlaceTypeResource;
use App\PlaceType;

class PlaceNoRelationships extends JsonResource
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
                'place_type_id' => $this->place_type_id,

                'edit_url' => $this->editUrl,
                'description' => $this->description,
                'intro' => $this->intro,
                'coordinates' =>$this->id ? $this->coordinates : [
                    'coordinates' => [null,null]
                ],

                'rating' => $this->rating ?? 0,
            ],

            'relationships' => [
            ],
        ];
    }
}
