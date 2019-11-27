<?php

namespace App\Http\Resources;


use App\Idea as IdeaModel;
use App\Http\Middleware\LocaleMiddleware;

use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\IdeaPrice as IdeaPriceResource;
use App\Http\Resources\Date as DateResource;
use App\Http\Resources\Idea as IdeaResource;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\User as UserResource;
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
            'id' => $this->id ? $this->id : null,
            'locale' => LocaleMiddleware::getLocale(),

            'attributes' => [
                'url' => $this->url,
                'edit_url' => $this->editUrl,

                'slug' => $this->id ? $this->slug : '',
                'active' => $this->id ? $this->active : 1,
                'title' => $this->id ? $this->title : '',
                'intro' => $this->id ? $this->intro : '',
                'description' => $this->id ? $this->description : '',
                'imageUrl' => asset($this->TmbImgPath)
            ],

            'relationships' => [
                'idea' => new IdeaResource($this->whenLoaded('ideaParentIdea')),
                'categories' => $this->id ? CategoryResource::collection($this->whenLoaded('ideaCategories')) : [],
                'author' => new UserResource($this->whenLoaded('author')),
                'price' => new IdeaPriceResource($this->whenLoaded('ideaPrice')),
                'places' => PlaceResource::collection($this->whenLoaded('ideaPlaces')),
                'dates' => DateResource::collection($this->whenLoaded('ideaDates')),
                'tags' => $this->id ? $this->getItemTags() : IdeaModel::emptyTagsArray(),
            ],
        ];
    }
}
