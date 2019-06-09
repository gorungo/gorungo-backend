<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'type' => 'Users',
            'id' => $this->id,
            'locale' => LocaleMiddleware::getLocale(),

            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'displayName' => $this->displayName,
            ],

            'relationships' => [

            ],
        ];
    }
}
