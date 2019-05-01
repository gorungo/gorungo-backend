@extends ('layouts.app')
@section('title', strip_tags($idea->title))
@section('header')
    @include('parts.header')
@endsection
@section('content')
    <div class="content-wrap bg-white py-4">
        <div class="container">
            @include('widgets.back_title_vs_img', ['breadCrumbs' => [
                ['sectionTitle' => __('idea.title'), 'itemUrl'=> $idea->url, 'itemTitle'=> $idea->title, 'imgUrl' => $idea->TmbImgPath],
            ]])
        </div>
    </div>
    @include('action.listing')
@endsection