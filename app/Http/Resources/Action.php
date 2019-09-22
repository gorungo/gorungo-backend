<?php

namespace App\Http\Resources;

use App\Idea;
use App\Http\Resources\Idea as IdeaResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\Date as DateResource;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Http\Resources\Json\JsonResource;

class Action extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $idea = null;

        if(!$this->id && request()->has('idea_id')){
            $idea = Idea::find(request()->input('idea_id'));
        }
        if(!$idea){
            $idea = $this->actionIdea;
        }


        return [
            'type' => 'Actions',
            'id' => $this->id ? $this->id : null,
            'locale' => LocaleMiddleware::getLocale(),

            'attributes' => [
                'url' => $this->url,
                'edit_url' => $this->editUrl,

                'slug' => $this->id ? $this->slug : '',
                'active' => $this->id ? $this->active : 0,
                'main_category_id' => $this->id ? $this->main_category_id : null,

                // localized information
                'title' => $this->id ? $this->title : '',
                'intro' => $this->id ? $this->intro : '',
                'description' => $this->id ? $this->description : '',
            ],

            'relationships' => [
                'idea' => new IdeaResource($idea),
                'author' => new UserResource($this->author),
                'places' => PlaceResource::collection($this->actionPlaces),
                'dates' => DateResource::collection($this->actionDates)
            ],
        ];
    }
}
