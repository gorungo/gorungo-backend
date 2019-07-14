<div class="container">
    <div class="row mt-4">
        @if(isset($addItemURL) && isset($addItemTitle))
            @can('create', App\Idea::class)
                <div class="col-md-10">
                    <h1 class="text-primary">{{$sectionTitle}}@isset($activeCategory) / {{$activeCategory->title}}@endisset</h1>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-outline-primary float-right" href="{{$addItemURL}}">{{$addItemTitle}}</a>
                </div>
            @endcan
        @else
            <div class="col-md-12">
                <h1 class="text-primary">{{$sectionTitle}}@isset($activeCategory) / {{$activeCategory->title}}@endisset</h1>
            </div>
        @endif
    </div>

</div>