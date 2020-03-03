<div class="idea-cover mb-5">
    <div class="idea-cover__box-wrap">
        <div class="idea-cover__tmb">
            <div class="idea-cover__tmb-container vertical">
                <a href="{{$item->fullUrl}}">
                    <img src="{{asset($item->tmbImgPath)}}" alt="idea cover"/>
                </a>
            </div>
        </div>
        <div class="idea-cover__content text-first-uppercase">
            @auth @if(Auth()->user()->hasRole('super-admin'))id:{{$item->id}}@endif @endauth

        </div>
        @auth
        <div class="list-item-dropdown">
            @include('idea.widgets.item_dropdown')
        </div>
        @endauth
    </div>
    <div class="idea-cover__footer mt-2">
        <div>
            <span class="idea-cover__title">{{str_limit($item->title, 50)}}</span>
        </div>
        @isset($item->ideaPrice)
            @if($item->ideaPrice->price !== 0)
                <span class="price">{{$item->ideaPrice->FormattedPrice}} <span class="price-currency">{{$item->ideaPrice->currency->shortTitle}}</span></span>
            @endif
        @endisset
        @if(!$item->ideaAuthor->hasrole('super-admin'))
        <div class="author">
            <img class="author-tmb mr-1" src="{{asset($item->ideaAuthor->TmbImgPath)}}" alt="">
            <span class="author-title">{{$item->ideaAuthor->displayName}}</span>
        </div>
        @endif
    </div>
</div>
