@extends ('layouts.app')

@isset($page)
@section('title', htmlspecialchars(strip_tags($page->title)) or '')
@section('description', htmlspecialchars(strip_tags($page->description)) or '')
@section('keywords', htmlspecialchars(strip_tags($page->keywords)) or '')
@endif

@section('header')
    @include('parts.header')
    @include('parts.section_title', [
    'sectionTitle' => __('action.title'),
    'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Action::class) ? route('actions.create'): null,
    'addItemTitle' => __('action.create'),
    ])
    @include('action.widgets.category_selector')
    @include('widgets.menu.main_filters')
@endsection

@section('content')
@include('action.listing')
@endsection
