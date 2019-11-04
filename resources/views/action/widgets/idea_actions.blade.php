@isset($ideaActions)
    <div class="section-wrap bg-gray py-4">
        <div class="container">
            @if($ideaActions->count())
                <h2 class="mt-4 text-first-uppercase">
                    {{__('action.title')}} {{__('texts.for')}} "{{$item->title}}"
                    <a href="{{route('ideas.actions_index', [
            'categories' => $category,
            'idea' => $item->slug
            ])}}" class="btn btn-link float-right text-first-uppercase">{{__('idea.see_all_actions')}}<span>{{' (' .  $item->ideaActions->count() . ')'}}</span></a>
                </h2>
                <div class="row mt-4">
                    @foreach($ideaActions as $ideaAction)
                        @include('action.widgets.list_item_12-4', ['item' => $ideaAction])
                    @endforeach
                </div>
            @else
                <h3 class="text-first-uppercase">{{__('action.no_items')}} {{__('texts.for')}} "{{$item->title}}"</h3>
            @endif

        </div>
    </div>
@endisset