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
<action-editor
        :prop-idea-id="@isset($idea->id){{$idea->id}}@else null @endisset"
        :prop-item-id="@isset($action->id){{$action->id}}@else null @endisset"
        :user="{{json_encode(Auth()->user())}}"
>
</action-editor>
@endsection

