<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Resources\Json\JsonResource;

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
                'description' => $this->description,
                'intro' => $this->intro,
                'coordinates' =>$this->coordinates,
            ],

            'relationships' => [
                'address' => $this->placeAddress,
            ],
        ];
    }
}
