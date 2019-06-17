<div class="container">
    <div class="row mt-4">
        @if(isset($addItemURL) && isset($addItemTitle))
            @can('create', App\Idea::class)
                <div class="col-md-10">
                    <h1 class="text-primary">{{$sectionTitile}}@isset($activeCategory) / <a href="{{$activeCategory->url}}">{{$activeCategory->title}}</a>@endisset</h1>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-primary float-right" href="{{$addItemURL}}">{{$addItemTitle}}</a>
                </div>
            @else
                <div class="col-md-12">
                    <h1>{{$sectionTitile}}</h1>
                </div>
            @endcan
        @else
            <div class="col-md-12">
                <h1>{{$sectionTitile}}</h1>
            </div>
        @endif
    </div>

</div>