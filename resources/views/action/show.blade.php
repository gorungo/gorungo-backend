@extends ('layouts.app')
@section('title', strip_tags($action->title))
@section('header')
    @include('parts.header')
@endsection
@section('content')
    <div class="content-wrap bg-white py-4">
        <div class="container">
            @include('widgets.back_title_vs_img', ['breadCrumbs' => [
                ['sectionTitle' => __('idea.title'), 'itemUrl'=> $idea->url, 'itemTitle'=> $idea->title, 'imgUrl' => $idea->TmbImgPath],
                ['sectionTitle' => __('action.title'), 'itemUrl'=> route('ideas.actions_index', ['categories' => $categories, 'idea' => $idea->slug])]
            ]])
            <hr/>
            <div class="row item-heading">
                <div class="col-sm-3">
                    <div class="card my-3">
                        @include('photo.tmb.16x9_fullsize', ['imgUrl' => $action->TmbImgPath])
                    </div>
                </div>
                <div class="col-sm-8">
                    <h1 class="mt-4">{{$action->title}}</h1>
                    @include('action.widgets.dates_block')
                    @if($action->actionPlace() != null)
                        <p><img class="mr-2" alt="" src="/images/interface/icos/location_ico.svg" style="height: 16px;"/>{{$action->actionPlace()->title}}</p>
                    @endif
                    <p class="text-secondary item-intro">{!! $action->intro !!}</p>
                </div>
            </div>
            <hr>
            <p class="item-description">{!! $action->description !!}</p>
        </div>
    </div>

@endsection
