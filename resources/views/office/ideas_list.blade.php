@extends ('layouts.app')
@section('title', strip_tags($page->title))
@section('header')
    @include('parts.header')
@endsection
@section('content')
    <div class="content-wrap bg-white py-4">
        <div class="container">
            <office-ideas-list></office-ideas-list>
        </div>
    </div>
@endsection