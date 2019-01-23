@extends ('layouts.app')
@section('title', strip_tags($item->title))
@section('header')
    @include('parts.header')
@endsection
@section('content')
    <div class="container mt-4">
        <h1>{{$item->title}}</h1>
        <p>{!! $item->description !!}</p>
    </div>
@endsection