<?php

namespace App\Traits;

use Conner\Tagging\Model\Tag;
use Illuminate\Support\Facades\Cache;


trait TagInfo
{


    public function getTagInfo(){

        // негруппированные тэги ч-з запятую
        $simpleTagsText = '';

        // item grouped tags
        $itemSeasonsGroupTags = []; $itemAgeGroupTags = []; $itemDayTimeGroupTags = [];

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

        $tags = $this->tags;

        // загружаем тэги элемента и вносим их в группы
        foreach($tags as $tag){

            if($tag->tag_group_id == ''){

                // строка тэгов, ч-з запятую
                $simpleTagsText == '' ? $simpleTagsText = $tag->name : $simpleTagsText = $simpleTagsText . ',' . $tag->name ;

            }elseif($tag->tag_group_id == 1){
                $itemSeasonsGroupTags[] = $tag->name;
            }elseif($tag->tag_group_id == 2){
                $itemAgeGroupTags[] = $tag->name;
            }elseif($tag->tag_group_id == 3){
                $itemDayTimeGroupTags[] = $tag->name;
            }
        }

        return collect([
            'simpleTagsText' => $simpleTagsText,

            'tagsSeasonsGroup' => $tagsSeasonsGroup,
            'tagsAgeGroupGroup' => $tagsAgeGroupGroup,
            'tagsDayTimeGroup' => $tagsDayTimeGroup,

            'itemSeasonsGroupTags' => $itemSeasonsGroupTags,
            'itemAgeGroupTags' => $itemAgeGroupTags,
            'itemDayTimeGroupTags' => $itemDayTimeGroupTags,
        ]);

    }

}