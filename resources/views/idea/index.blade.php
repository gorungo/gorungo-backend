@extends ('layouts.app')

@isset($page)
@section('title', htmlspecialchars(strip_tags($page->title)))
@section('description', htmlspecialchars(strip_tags($page->description)))
@section('keywords', htmlspecialchars(strip_tags($page->keywords)))
@endisset

@section('header')
    @include('parts.header')
    @include('idea.widgets.title_vs_filters')
@endsection

@section('content')
@include('idea.listing')
@endsection
