@isset($ideaActions)
    <div class="section-wrap bg-gray pt-4">
        <div class="container">
            <h2 class="mt-4">
                {{__('action.title')}} for "{{$item->title}}"
                <a href="{{route('ideas.actions_index', [
            'categories' => $category,
            'idea' => $item->slug
            ])}}" class="btn btn-link float-right">{{__('idea.see_all_actions')}}<span>{{' (' .  $item->ideaActions->count() . ')'}}</span></a>
            </h2>

            @if($ideaActions->count())
            <div class="row mt-4">
                @foreach($ideaActions as $ideaAction)
                    @include('action.widgets.list_item_12-4', ['item' => $ideaAction])
                @endforeach
            </div>
            @else
                {{__('action.no_items')}}
            @endif

        </div>
    </div>
@endisset