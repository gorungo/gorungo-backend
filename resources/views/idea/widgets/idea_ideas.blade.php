@isset($ideaIdeas)
    <div class="section-wrap bg-gray py-4">
        <div class="container">
            @if($ideaIdeas->count())
                <h2 class="mt-4 text-first-uppercase">
                    {{__('action.title')}} {{__('texts.for')}} "{{$idea->title}}"
                    <a href="{{route('ideas.actions_index', [
                    'categories' => $category,
                    'idea' => $idea->slug
                    ])}}" class="btn btn-link float-right text-first-uppercase">{{__('idea.see_all_actions')}}<span>{{' (' .  $idea->ideaIdeas->count() . ')'}}</span></a>
                </h2>
                <div class="grid-container grid-columns-5 mt-4">
                    @foreach($ideaIdeas as $idea)
                        @if($idea->title !== null)
                            @can('view', $idea)
                                @if($idea->idea_id)
                                    @include('idea.covers.action_deep', ['item' => $idea, null])
                                @endif
                            @endcan
                        @endif
                    @endforeach
                </div>
            @else
                <h3 class="text-first-uppercase">{{__('idea.no_items')}} {{__('texts.for')}} "{{$idea->title}}"</h3>
            @endif
        </div>
    </div>
@endisset