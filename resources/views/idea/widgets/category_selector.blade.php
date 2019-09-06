@if($categories)
<div class="container">
<div class="card mt-4 mb-4 bg-light">
    @isset($activeCategory)
        <div class="card-header">

            <a href="{{route('ideas.index')}}">{{__('idea.title')}}</a><span> /</span>
            @isset($subCategory)
                <a href="{{route('ideas.index',$subCategory->pathToCategory())}}">{{$subCategory->title}}</a><span> / </span>
            @endisset
            <a href="{{route('ideas.index',$activeCategory->pathToCategory())}}">{{$activeCategory->title}}</a>

            @can('create', App\Category::class)<a class="float-right" href="{{route('category.create')}}">{{__('category.create')}}</a>@endcan
        </div>
    @endisset
<div class="card-body">
    <div class="row">
        @foreach($categories as $category)
            @if($category->title !== null)
                <div class="col-md-3">
                    <a href="{{route('ideas.index', [$category->pathToCategory()])}}">{{$category->title}}</a>
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