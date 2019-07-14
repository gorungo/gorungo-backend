@extends ('layouts.app')

@isset($page)
@section('title', htmlspecialchars(strip_tags($page->title)))
@section('description', htmlspecialchars(strip_tags($page->description)))
@section('keywords', htmlspecialchars(strip_tags($page->keywords)))
@endisset

@section('header')
    @include('parts.header')
    @include('parts.section_title', [
    'sectionTitle' => __('idea.title'),
    'addItemURL' => route('ideas.create'),
    'addItemTitle' => __('idea.create'),
    ])
    @include('idea.widgets.category_selector')
    @include('widgets.menu.main_filters')
@endsection

@section('content')
@include('idea.listing')
@endsection
