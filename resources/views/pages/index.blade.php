@extends ('layouts.app')

@isset($page)
@section('title', strip_tags($page->title))
@section('description', strip_tags($page->description))
@section('keywords', strip_tags($page->keywords))
@endisset

@section('header')
    @include('parts.header')
    @include('idea.widgets.title_vs_filters')
@endsection

@section('content')
    <div class="section-wrap bg-white pt-5">
        <div class="container">
            @foreach($ideaSections as $section)
                @if($section['sectionTitle'])
                    <h3 class="text-first-uppercase">{{$section['sectionTitle']}}</h3>
                @endif
                <div class="grid-container grid-columns-5">
                    @foreach($section['ideas'] as $idea)
                        @if($idea->title !== null)
                            @can('view', $idea)
                                @if($idea->idea_id)
                                    @include('idea.covers.action_deep', ['item' => $idea, $categoriesUrl])
                                @else
                                    @if($idea->hasIdeas)
                                        @include('idea.covers.action_deep', ['item' => $idea, $categoriesUrl])
                                    @else
                                        @include('idea.covers.action_deep', ['item' => $idea, $categoriesUrl])
                                    @endif
                                @endif
                            @endcan
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection

