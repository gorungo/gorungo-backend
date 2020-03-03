@if($breadCrumbs)
    <div class="container">
        <div class="back-item d-flex flex-row align-items-center">
            @foreach($breadCrumbs as $breadCrumb)
            @isset($breadCrumb['imgUrl'])
                <a href="{{$breadCrumb['itemUrl']}}">
                    <img class="rounded mr-4" src="{{asset($breadCrumb['imgUrl'])}}" height="40px">
                </a>
            @endisset
            <div class="mb-0">
                @if($loop->last)
                    @isset($breadCrumb['itemTitle'])<span class="text-secondary">{{$breadCrumb['itemTitle']}}</span>@endisset
                    @else
                    <a href="{{$breadCrumb['itemUrl']}}">
                        @isset($breadCrumb['itemTitle']){{$breadCrumb['itemTitle']}}@endisset
                    </a>
                    <span class="mr-1">&bull;</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <hr>
@endif