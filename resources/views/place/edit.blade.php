@extends ('layouts.app')

@isset($page)
@section('title', htmlspecialchars(strip_tags($page->title)) or '')
@section('description', htmlspecialchars(strip_tags($page->description)) or '')
@section('keywords', htmlspecialchars(strip_tags($page->keywords)) or '')
@endif

@section('header')
    @include('parts.header', ['fixed' => false])
@endsection

@section('content')
<place-editor  :prop-item-id="@isset($place->id){{$place->id}}@else null @endisset" ></place-editor>
@endsection

