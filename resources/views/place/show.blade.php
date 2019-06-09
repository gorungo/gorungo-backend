@extends ('layouts.app')
@section('title', strip_tags($item->title))
@section('header')
    @include('parts.header')
@endsection
@section('content')
    <div class="content-wrap bg-white py-4">
        <div class="container">
            <div class="row item-heading">
                <div class="col-sm-3">
                    <div class="card my-3">
                        @include('photo.tmb.16x9_fullsize', ['imgUrl' => $item->TmbImgPath])
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="mt-4 text-uppercase text-secondary">
                        <a href="{{route('places.index')}}">{{__('place.title')}}</a>
                    </div>
                    <h1>
                        {{$item->title}}
                    </h1>
                    <p class="text-secondary item-intro">
                        {!! $item->intro !!}
                    </p>
                </div>
            </div>
            <hr>
            <p class="item-description">
                {!! $item->description !!}
            </p>
        </div>
    </div>

    @include('action.widgets.idea_actions')
@endsection