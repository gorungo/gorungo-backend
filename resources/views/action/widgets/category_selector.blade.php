@if($categories)
    <div class="container">
        <div class="card mt-4 mb-4 bg-light">
            <div class="card-header">
                @isset($activeCategory)
                    <a href="{{route('actions.index').MainFilter::queryString()}}">{{__('action.title')}}</a><span> /</span>
                    @isset($subCategory)
                        <a href="{{route('actions.index',$subCategory->pathToCategory()).MainFilter::queryString()}}">{{$subCategory->title}}</a><span> / </span>
                    @endisset
                    <a href="{{route('actions.index',$activeCategory->pathToCategory()).MainFilter::queryString()}}">{{$activeCategory->title}}</a>
                @endisset
                @can('create', App\Category::class)<a class="float-right" href="{{route('category.create')}}">{{__('category.create')}}</a>@endcan
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($categories as $category)
                        @if($category->title !== null)
                            <div class="col-md-3">
                                <a href="{{route('actions.index', [$category->pathToCategory().MainFilter::queryString()])}}">{{$category->title}}</a>
                                @can('update', $category)
                                    <a href="{{route('category.edit', $category->slug)}}" class="float-right" style="color: grey;">{{__('category.edit_short')}}</a>
                                @endcan
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>

    </div>
@endif