<div class="section-wrap bg-gray pt-4">
    @include('place.widgets.search_position')
    <div class="container">
        @hasanyrole('moderator|super-admin')
        <div id="place-sort" class="dropdown">
            @sortablelink('title', __('sort.title'))
            @sortablelink('rating', __('sort.rating'))
        </div>
        @endhasanyrole
        @if($places->count())
            <div class="grid-container grid-columns-4">
                @foreach($places as $place)
                    @if($place->title !== null)
                        @include('place.widgets.list_item_12-4', ['item' => $place])
                    @endif
                @endforeach
            </div>
            <div style="text-align: center;">{{ $places->links() }}</div>
        @else
            @include('place.widgets.no_items')
        @endif
    </div>
</div>
