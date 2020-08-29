@extends ('layouts.app')
@section('title', strip_tags($idea->title))
@section('header')
    @include('parts.header')
@endsection
@section('content')
    <div id="idea-details" class="content-wrap bg-white py-4">
        @include('widgets.back_title_vs_img', ['breadCrumbs' => $breadCrumbs])
        <div class="container">
            @if($idea->ideaPlace() != null)
                <span>
                    <img class="mr-2" alt="" src="/images/interface/icos/location_ico.svg" style="height: 16px;"/>{{$idea->ideaPlace()->title}}
                </span>
            @endif
            <header>
                <div class="row item-heading">
                    <div class="col-sm-8">
                        <h1 class="text-first-uppercase mt-2">{{$idea->title}}</h1>
                        <p class="text-secondary item-intro">{!! $idea->intro !!}</p>
                        @can('update', $idea)
                            <a class="text-primary text-uppercase" href="{{route('ideas.edit', $idea)}}">{{__('editor.edit')}}</a>
                        @endcan
                    </div>
                    <div class="col-sm-3 offset-sm-1">
                        <div class="">
                            @if($idea->ideaPrice->price !== 0)
                                <div class="">
                                    <span class="price"><span class="from">{{__('idea.from')}}</span> {{$idea->ideaPrice->FormattedPrice}} <span class="price-currency">{{$idea->ideaPrice->currency->shortTitle}}</span></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>
            <section id="item-description-section" class="mt-2">
                @include('photo.viewer.gallery-grid-1', ['item' => $idea])
                <div class="row mt-4">
                    <div class="col-sm-4">
                        <h3 class="text-first-uppercase">{{__('idea.idea_description')}}</h3>
                    </div>
                    <div class="col-sm-8">
                        <p class="item-description">{!! $idea->description !!}</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-4">
                        <h3 class="text-first-uppercase">{{__('itinerary.itinerary')}}</h3>
                    </div>
                    <div class="col-sm-8">
                        @include('idea.widgets.itineraries')
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
