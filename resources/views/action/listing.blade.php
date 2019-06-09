<div class="section-wrap bg-gray pt-4">
    <div class="container">
        @if($actions->count())
            <div class="row">
                @foreach($actions as $action)
                    @include('action.widgets.list_item_12-4', ['item' => $action, $categories])
                @endforeach
            </div>
            <div style="text-align: center;">{{ $actions->links() }}</div>
        @else
            @include('action.widgets.no_items')
        @endif
    </div>
</div>
