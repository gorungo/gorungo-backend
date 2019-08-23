@extends ('layouts.app')

@isset($page)
@section('title', htmlspecialchars(strip_tags($page->title)) or '')
@section('description', htmlspecialchars(strip_tags($page->description)) or '')
@section('keywords', htmlspecialchars(strip_tags($page->keywords)) or '')
@endif

@section('header')
    @include('parts.header')
    @include('parts.section_title', [
    'currentPlace' => $currentPlace,
    'sectionTitle' => $sectionTitle,
    'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Place::class) ? route('places.create') : null,
    'addItemTitle' => __('place.create'),
    ])
@endsection

@section('content')
@include('place.widgets.place_type_selector')
@include('place.listing')
@endsection
