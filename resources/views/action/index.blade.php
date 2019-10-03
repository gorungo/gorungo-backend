@extends ('layouts.app')

@isset($page)
@section('title', strip_tags($page->title))
@section('description', strip_tags($page->description))
@section('keywords', strip_tags($page->keywords))
@endisset

@section('header')
    @include('parts.header')
    @include('action.widgets.title_vs_filters')
@endsection

@section('content')
@include('action.listing')
@endsection
