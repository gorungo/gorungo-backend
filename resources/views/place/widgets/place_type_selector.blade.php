@if($placeTypes)
    <div class="container">
        <div class="card mt-4 mb-4 bg-light">
            <div class="card-header">
                @isset($activePlaceType)
                    <a href="{{route('places.index')}}">{{__('place.title')}}</a><span> /</span>
                    <a href="{{route('places.index', $activePlaceType->slug)}}">{{$activePlaceType->title}}</a>
                @endisset
                @can('create', App\Place::class)<a class="float-right" href="{{route('places.create')}}">{{__('place.create')}}</a>@endcan
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($placeTypes as $placeType)
                        @if($placeType->title !== null)
                            <div class="col-md-3">
                                <a href="{{route('places.index', $placeType->slug)}}">{{$placeType->title}}</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif