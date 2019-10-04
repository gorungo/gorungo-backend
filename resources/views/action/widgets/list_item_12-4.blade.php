
@if($item->title !== null)
    <div class="col-md-4">
        <div class="card list-item mb-4">
            <a href="{{$item->FullUrl}}">
                @include('photo.tmb.16x9_fullsize', ['imgUrl' => $item->TmbImgPath])
                <div class="card-body">
                    <h5 class="card-title">{{$item->title}}</h5>
                    <p class="card-text">{{$item->intro}} {{$item->id}}</p>
                    @isset($item->actionPrice)
                        @if($item->actionPrice->price !== 0)
                            <span class="price">{{$item->actionPrice->FormattedPrice}} <span class="price-currency">{{$item->actionPrice->currency->shortTitle}}</span></span>
                        @endif
                    @endisset
                </div>
            </a>
            <div class="list-item-dropdown">
                @include('action.widgets.item_dropdown')
            </div>
        </div>
    </div>
@endif
