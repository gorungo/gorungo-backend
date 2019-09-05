@extends ('layouts.app')

@isset($page)
@section('title', htmlspecialchars(strip_tags($page->title)) or '')
@section('description', htmlspecialchars(strip_tags($page->description)) or '')
@section('keywords', htmlspecialchars(strip_tags($page->keywords)) or '')
@endif

@section('header')
    @include('parts.header')
    @include('place.widgets.title_vs_filters')
@endsection

@section('content')
@include('place.listing')
@endsection
