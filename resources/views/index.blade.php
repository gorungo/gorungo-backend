@extends ('layouts.app')

@section('title', __('general.description'))
@section('description', __('general.full_description'))
@section('keywords', __('general.keywords'))

@section('header')
    @include('parts.header')
    @include('widgets.menu.main_filters')
@endsection

@section('content')
    <div class="container">
        @foreach($mainCategories as $category)
            @if($category->localisedTitle !== null)
            <div class="col-md-3">
            {{$category->localisedTitle->title}}
            </div>
            @endif
        @endforeach
    </div>
@endsection

