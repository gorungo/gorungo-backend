<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use App\Http\Resources\Address as AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Address;
use App\Http\Resources\PlaceType as PlaceTypeResource;
use App\PlaceType;

class Itinerary extends JsonResource
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
            'type' => 'Itinerary',
            'id' => $this->id ,
            'locale' => LocaleMiddleware::getLocale() ,

            'attributes' => [
                'title' => $this->title,
                'dayNum' => $this->day_num,
                'dayOrder' => $this->day_order,
                'startTime' => $this->start_time,
                'description' => $this->description,
                'whatIncluded' => $this->whatIncluded,
                'willVisit' => $this->willVisit,
                'fullTmbImgPath' => $this->fullTmbImgPath,
            ],

            'relationships' => [
            ],

        ];
    }
}
