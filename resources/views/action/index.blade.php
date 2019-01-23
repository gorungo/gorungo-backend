@extends ('layouts.app')

@isset($page)
@section('title', htmlspecialchars(strip_tags($page->title)) or '')
@section('description', htmlspecialchars(strip_tags($page->description)) or '')
@section('keywords', htmlspecialchars(strip_tags($page->keywords)) or '')
@endif

@section('header')
    @include('parts.header')
    <div class="container">
        @include('parts.section_title', ['sectionTitile' => __('action.title')])
    </div>
@endsection

@section('content')
@include('action.listing')
@endsection
