<?php

namespace App\Http\Resources;

use App\Http\Middleware\LocaleMiddleware;

use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Date as DateResource;
use App\Http\Resources\Idea as IdeaResource;
use App\Http\Resources\Itinerary as ItineraryResource;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Tagged as TaggedResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Idea extends JsonResource
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
            'type' => 'ideas',
            'id' => $this->id,
            'hid' => $this->hid,
            'locale' => LocaleMiddleware::getLocale(),

            'attributes' => [
                'url' => $this->url,
                'editUrl' => $this->editUrl,
                'slug' => $this->id ? $this->slug : '',
                'active' => $this->id ? $this->active : 1,
                'is_approved' => $this->is_approved ? $this->is_approved : 0,
                'title' => $this->id ? $this->title : '',
                'intro' => $this->id ? $this->intro : '',
                'description' => $this->id ? $this->description : '',
                'imageUrl' => asset($this->TmbImgPath),
                'created_at' => $this->created_at ? (string)$this->created_at : null,
            ],

            'relationships' => [
                'idea' => new IdeaResource($this->whenLoaded('ideaParentIdea')),
                'categories' => $this->id ? CategoryResource::collection($this->whenLoaded('ideaCategories')) : [],
                'author' => new UserResource($this->whenLoaded('author')),
                'itineraries' => ItineraryResource::collection($this->whenLoaded('ideaItineraries')),
                'places' => PlaceResource::collection($this->whenLoaded('ideaPlaces')),
                'dates' => $this->id ? DateResource::collection($this->whenLoaded('ideaDates')) : [],
                'tags' => $this->id ? TaggedResource::collection($this->whenLoaded('tagged')) : [],
            ],
        ];
    }
}
