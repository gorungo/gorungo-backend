<div class="section-wrap bg-gray pt-4">
    <div class="container">
        <div id="place-sort" class="dropdown">
            @sortablelink('title', __('sort.title'),['rel' => 'nofollow', 'class' => 'dropdown-item'])
            @sortablelink('rating', __('sort.rating'),['rel' => 'nofollow', 'class' => 'dropdown-item'])
            @sortablelink('distance', __('sort.distance'),['rel' => 'nofollow', 'class' => 'dropdown-item'])
        </div>
        <div class="row">
            @foreach($places as $place)
                @include('place.widgets.list_item_12-4', ['item' => $place])
            @endforeach
        </div>
        <div style="text-align: center;">{{ $places->links() }}</div>
    </div>
</div>
