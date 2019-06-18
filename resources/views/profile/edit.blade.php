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
    <profile-editor  :prop-item-id="@isset($user->profile->id){{$user->profile->id}}@else null @endisset" :user="{{$profileResource->toJson()}}"></profile-editor>
@endsection

