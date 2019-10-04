
@if($item->title !== null)
    <div class="col-md-4">
        <div class="card list-item mb-4">
            <a href="{{$item->FullUrl}}">
                @include('photo.tmb.16x9_fullsize', ['imgUrl' => $item->TmbImgPath])
            </a>
            <div class="card-body">
                <a href="{{$item->FullUrl}}">
                <h4 class="card-title">{{$item->title}}</h4>
                </a>
                <p class="card-text text-secondary">{{$item->intro}} @auth @if(Auth()->user()->hasRole('super-admin')){{$item->id}}@endif @endauth</p>
            </div>
            <div class="list-item-dropdown">
                @include('idea.widgets.item_dropdown')
            </div>
        </div>
    </div>
@endif
