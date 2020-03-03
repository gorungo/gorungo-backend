@extends ('layouts.edit')

@isset($page)
    @section('title', htmlspecialchars(strip_tags($page->title)) or '')
    @section('description', htmlspecialchars(strip_tags($page->description)) or '')
    @section('keywords', htmlspecialchars(strip_tags($page->keywords)) or '')
@endif

@section('header')
    @include('parts.header', ['fixed' => false])
@endsection

@section('content')
    <idea-editor prop-hid="@isset($idea->hid){{$idea->hid}}@else null @endisset"  :prop-item-id="@isset($idea->id){{$idea->id}}@else null @endisset" :prop-user="{{json_encode(Auth()->user())}}"></idea-editor>
@endsection



