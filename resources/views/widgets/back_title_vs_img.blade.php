<div class="back-item d-flex flex-row align-items-center">
    @foreach($breadCrumbs as $breadCrumb)
    @isset($breadCrumb['imgUrl'])
        <a href="{{$breadCrumb['itemUrl']}}">
            <img class="rounded mr-4" src="{{asset($breadCrumb['imgUrl'])}}" height="40px">
        </a>
    @endisset
    <div class="mb-0">
        <a href="{{$breadCrumb['itemUrl']}}">{{$breadCrumb['sectionTitle']}}@isset($breadCrumb['itemTitle']): {{$breadCrumb['itemTitle']}}@endisset</a>
        @if(!$loop->last)<span class="mr-1">&bull;</span>@endif
    </div>
    @endforeach
</div>