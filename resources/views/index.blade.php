@extends ('layouts.app')

@section('title', 'Тудуся знает, как хорошо провести время')
@section('description', '')
@section('keywords', '')

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

