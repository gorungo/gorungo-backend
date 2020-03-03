<div class="list-item idea mb-4">
    <a href="{{$item->FullUrl}}">
        @if($item->TmbImgPath !== '')
            <div class="img-wrap vertical">
                <img src="{{asset($item->TmbImgPath)}}"/>
            </div>
        @endif
    </a>
    <div class="list-item-body">
        <a class="card-title text-first-uppercase" href="{{$item->FullUrl}}">
            {{$item->title}}
            @auth @if(Auth()->user()->hasRole('super-admin'))id:{{$item->id}}@endif @endauth
        </a>
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
