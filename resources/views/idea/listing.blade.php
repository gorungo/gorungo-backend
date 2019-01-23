<div class="section-wrap bg-gray pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    <a href="{{route('ideas.create')}}">{{__('idea.create')}}</a>
                </div>
            </div>
            @foreach($ideas as $idea)
                @include('idea.widgets.list_item_12-4', ['item' => $idea, $categoriesUrl])
            @endforeach
        </div>
        <div style="text-align: center;">{{ $ideas->links() }}</div>
    </div>
</div>
