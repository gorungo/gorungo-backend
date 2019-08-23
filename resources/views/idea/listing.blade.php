<div class="section-wrap bg-gray pt-5">
    <div class="container">
        @if($ideas->count())
            <div class="row">
                @foreach($ideas as $idea)
                    @include('idea.widgets.list_item_12-4', ['item' => $idea, $categoriesUrl])
                @endforeach
            </div>
            <div style="text-align: center;">{{ $ideas->links() }}</div>
        @else
            @include('idea.widgets.no_items')
        @endif
    </div>
</div>
