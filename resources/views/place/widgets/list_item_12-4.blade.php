
@if($item->title !== null)
    <div class="col-md-4">
        <div class="card list-item mb-4">
            <a href="{{$item->FullUrl}}">
                @include('photo.tmb.16x9_fullsize', ['imgUrl' => $item->TmbImgPath])
                <div class="card-body">
                    <h5 class="card-title text-first-uppercase">{{$item->title}}</h5>
                    <p class="card-text text-first-uppercase">{{$item->intro}}</p>
                </div>
            </a>
            <div class="list-item-dropdown">
                @include('place.widgets.item_dropdown')
            </div>
        </div>
    </div>
@endif
