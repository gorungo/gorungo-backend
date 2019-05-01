<?php

namespace App\Traits;

use Conner\Tagging\Model\Tag;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Tag as TagResource;


trait TagInfo
{


    public function getAllTags(){
        // season tags
        $tagsSeasonsGroup = Cache::remember('tagsSeasonsGroup', 10, function ()  {
            return  Tag::inGroup('seasonsgroup')->get();
        });

        // season tags
        $tagsAgeGroupGroup = Cache::remember('tagsAgeGroup', 10, function ()  {
            return  Tag::inGroup('agegroup')->get();
        });

        // season tags
        $tagsDayTimeGroup = Cache::remember('tagsDayTimeGroup', 10, function ()  {
            return  Tag::inGroup('daytimegroup')->get();
        });

        return collect([
            'tagsSeasonsGroup' => TagResource::collection($tagsSeasonsGroup),
            'tagsAgeGroupGroup' => TagResource::collection($tagsAgeGroupGroup),
            'tagsDayTimeGroup' => TagResource::collection($tagsDayTimeGroup),
        ]);
    }

    public function getItemTags(){
        // негруппированные тэги ч-з запятую
        $simpleTagsText = '';

        // item grouped tags
        $itemSeasonsGroupTags = []; $itemAgeGroupTags = []; $itemDayTimeGroupTags = [];

        $tags = $this->tags;

        // загружаем тэги элемента и вносим их в группы
        foreach($tags as $tag){

            if($tag->tag_group_id == ''){

                // строка тэгов, ч-з запятую
                $simpleTagsText == '' ? $simpleTagsText = $tag->name : $simpleTagsText = $simpleTagsText . ',' . $tag->name ;

            }elseif($tag->tag_group_id == 1){
                $itemSeasonsGroupTags[] = $tag;
            }elseif($tag->tag_group_id == 2){
                $itemAgeGroupTags[] = $tag;
            }elseif($tag->tag_group_id == 3){
                $itemDayTimeGroupTags[] = $tag;
            }
        }

        return [
            'tagsText' => $simpleTagsText,
            'tagsSeasonsGroup' => TagResource::collection(collect($itemSeasonsGroupTags)),
            'tagsAgeGroup' => TagResource::collection(collect($itemAgeGroupTags)),
            'tagsDayTimeGroup' => TagResource::collection(collect($itemDayTimeGroupTags)),
        ];

    }

}