<div class="idea-cover">
    <div class="idea-cover__box-wrap">
        <div class="idea-cover__tmb">
            <div class="idea-cover__tmb-container size-715 vertical">
                <a href="{{$item->fullUrl}}">
                    <img src="{{asset($item->tmbImgPath)}}" alt="idea cover"/>
                </a>
            </div>
        </div>
        <div class="idea-cover__content text-first-uppercase">
            <span class="idea-cover__title">{{str_limit($item->title, 65)}}</span>
            @auth @if(Auth()->user()->hasRole('super-admin'))id:{{$item->id}}@endif @endauth
            @if($item->dateToDisplay)
                {{$item->dateToDisplay}}
            @endif
            @if($item->canBeOrdered)
                <div class="row">
                    <div class="col-sm-8">
                        @isset($item->ideaPrice)
                            @if($item->ideaPrice->price !== 0)
                                <span class="price">{{$item->ideaPrice->FormattedPrice}} <span class="price-currency">{{$item->ideaPrice->currency->shortTitle}}</span></span>
                            @endif
                        @endisset
                    </div>
                    <div class="col-sm-4"><span class="btn btn-outline-primary">Заказать</span></div>
                </div>
            @else
                @isset($item->ideaPrice)
                    @if($item->ideaPrice->price !== 0)
                        <span class="price">{{$item->ideaPrice->FormattedPrice}} <span class="price-currency">{{$item->ideaPrice->currency->shortTitle}}</span></span>
                    @endif
                @endisset
            @endif
        </div>
        <div class="list-item-dropdown">
            @include('idea.widgets.item_dropdown')
        </div>
    </div>
</div>
