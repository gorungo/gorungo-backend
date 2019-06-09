@isset($tagInfo)
<div class="panel panel-default">
    <div class="panel-heading"><h3 style="margin:0;" class="color-icon-blue">{{__('editor.label_tags')}}</h3></div>
    <div class="panel-body">
        <div class="form-group{{ $errors->has('tag') ? ' has-error' : '' }}">
            <label for="tags">Слова, по которым можно найти компанию на сайте</label>
            <textarea id="tags" class="form-control" maxlength="255" name="tag">
                @if(old('tag')){{old('tag')}}@else
                    {{$tagInfo->get('simpleTagsText')}}
                @endif
            </textarea>
        </div>
    </div>
</div>
<div class="panel panel-default" >
    <div class="panel-heading">
        <h3 style="margin:0;" class="color-icon-blue">{{__('editor.label_more_information')}}</h3>
    </div>
    @if(count($tagInfo->get('tagsSeasonsGroup')))
    <div class="panel-body">
        <div class="form-group">
            <h3>{{__('tag.label_for_season')}}</h3>
            @foreach($tagInfo->get('tagsSeasonsGroup') as $tagSeasons)
                <input type="checkbox"
                       id="frm_tag_extra{{$tagSeasons->id}}"
                       name="tag_extra[{{$tagSeasons->id}}]"
                       value="{{$tagSeasons->name}}"
                       @if(old('tag_extra'. $tagSeasons->id)) checked
                       @elseif(is_array($tagInfo->get('itemSeasonsGroupTags'))
                       && in_array($tagSeasons->name, $tagInfo->get('itemSeasonsGroupTags'))) checked @endif
                />
                <label for="frm_tag_extra{{$tagSeasons->id}}" style="margin-left: 5px;">{{$tagSeasons->name}}</label>
            @endforeach
        </div>
    </div>
    @endif
    @if(count($tagInfo->get('tagsDayTimeGroup')))
        <div class="panel-body">
            <div class="form-group">
                <h3>{{__('tag.label_for_day_time')}}</h3>
                @foreach($tagInfo->get('tagsDayTimeGroup') as $tagDayTime)
                    <input type="checkbox"
                           id="frm_tag_extra{{$tagDayTime->id}}"
                           name="tag_extra[{{$tagDayTime->id}}]"
                           value="{{$tagDayTime->name}}"
                           @if(old('tag_extra'. $tagDayTime->id)) checked
                           @elseif(is_array($tagInfo->get('itemDayTimeGroupTags'))
                           && in_array($tagDayTime->name, $tagInfo->get('itemDayTimeGroupTags'))) checked @endif
                    />
                    <label for="frm_tag_extra{{$tagDayTime->id}}" style="margin-left: 5px;">{{$tagDayTime->name}}</label>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endisset