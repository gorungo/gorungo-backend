@extends ('layouts.app')
@section('title', strip_tags($user->displayName))
@section('header')
    @include('parts.header')
@endsection
@section('content')
    <div id="user-page">
        <div class="content-wrap bg-white py-4">
            <div class="container">
                <div class="item-heading">
                    <div class="user-image-block mr-4">
                        <div class="card">
                            @include('photo.tmb.sqr', ['imgUrl' => $user->TmbImgPath])
                        </div>
                    </div>
                    <div class="user-info-block">
                        <h1>
                            {{$user->displayName}} <span class="text-secondary">(@&nbsp;{{$user->name}})</span>
                        </h1>
                        @if($user->profile->description)
                            <p class="text-secondary">{{$user->profile->description}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('parts.section_title', [
            'sectionTitle' => __('idea.title'),
            'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Idea::class) ? route('ideas.create'): null,
            'addItemTitle' => __('idea.create'),
            ])
        @include('action.listing')
    </div>
@endsection
@push('styles')
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
@endpush