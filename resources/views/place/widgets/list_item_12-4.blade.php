<div class="list-item mb-4">
    <a class="card-title text-first-uppercase" href="{{$item->FullUrl}}">
        @include('photo.tmb.16x9_fullsize', ['imgUrl' => $item->TmbImgPath])
        <span class="mt-2">{{$item->title}}</span>
        <span class="d-inline-block text-first-uppercase">{{$item->intro}}</span>
    </a>
    <div class="list-item-dropdown">
        @include('place.widgets.item_dropdown')
    </div>
</div>


