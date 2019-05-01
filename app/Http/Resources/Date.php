<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Resources\Json\JsonResource;

class Date extends JsonResource
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
            'type' => 'Dates',
            'id' => $this->id ,
            'locale' => LocaleMiddleware::getLocale() ,

            'attributes' => [
                'start_datetime_utc' => $this->start_datetime_utc,
                'end_datetime_utc' => $this->end_datetime_utc,
                'time_zone_offset' => $this->time_zone_offset,

                'is_all_day' => $this->is_all_day,
                'duration' => $this->duration,
                'is_recurring' => $this->is_recurring,
                'recurrence_pattern' => $this->recurrence_pattern,
            ],

            'relationships' => null
        ];
    }
}
