<div class="section-wrap bg-gray pt-4">
    <div class="container">
        @hasanyrole('moderator|super-admin')
        <div id="place-sort" class="dropdown">
            @sortablelink('title', __('sort.title'))
            @sortablelink('rating', __('sort.rating'))
        </div>
        @endhasanyrole
        @if($places->count())
            <div class="row">
                @foreach($places as $place)
                    @include('place.widgets.list_item_12-4', ['item' => $place])
                @endforeach
            </div>
            <div style="text-align: center;">{{ $places->links() }}</div>
        @else
            @include('place.widgets.no_items')
        @endif
    </div>
</div>
