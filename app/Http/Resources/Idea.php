<?php

namespace App\Http\Resources;

use App\Idea as IdeaModel;
use App\Http\Middleware\LocaleMiddleware;
use App\Http\Resources\Category as CategoryResource;
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
                'slug' => $this->id ? $this->slug : '',
                'active' => $this->id ? $this->active : 1,
                'main_category_id' => $this->id ? $this->main_category_id : null,
                'title' => $this->id ? $this->title : '',
                'intro' => $this->id ? $this->intro : '',
                'description' => $this->id ? $this->description : '',
            ],

            'relationships' => [
                'categories' => $this->id ? CategoryResource::collection($this->ideaCategories) : [],
                'tags' => $this->id ? $this->getItemTags() : IdeaModel::emptyTagsArray(),
            ],
        ];
    }
}
