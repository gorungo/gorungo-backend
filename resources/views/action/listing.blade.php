<div class="section-wrap bg-gray pt-4">
    <div class="container">
        <div class="row">
            @foreach($items as $item)
                @include('action.widgets.list_item_12-4', ['item' => $item, $categoriesUrl])
            @endforeach
        </div>
        <div style="text-align: center;">{{ $items->links() }}</div>
    </div>
</div>
