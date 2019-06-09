<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\User  as UserResource;

class Profile extends JsonResource
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
            'type' => 'profiles',
            'id' => $this->id ? $this->id : null,
            'locale' => LocaleMiddleware::getLocale(),

            'attributes' => [
                'url' => $this->url,
                'editUrl' => $this->editUrl,
                'imageUrl' => $this->imageUrl,
                'name' => $this->name ?? '',
                'description' => $this->description ?? '',
                'phone' => $this->phone ?? '',
                'site' => $this->site ?? '',
                'sex' => $this->sex ?? '',
            ],

            'relationships' => [
                'user' => new UserResource($this->user),
            ],
        ];
    }
}
