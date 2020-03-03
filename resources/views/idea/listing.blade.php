<div class="section-wrap bg-white pt-5">
    <div class="container">
        @if($ideas->count())
            <div class="grid-container grid-columns-5">
                @foreach($ideas as $idea)
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
            <div style="text-align: center;">{{ $ideas->links() }}</div>
        @else
            @include('idea.widgets.no_items')
        @endif
    </div>
</div>
