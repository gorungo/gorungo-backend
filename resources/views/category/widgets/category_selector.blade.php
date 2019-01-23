@if($categories)
<div class="container mt-4 mb-4">
<div class="card">
<div class="card-header">категории <a href="{{route('category.create')}}">{{__('category.create')}}</a></div>
    <div class="card-body">
        <div class="row">
            @foreach($categories as $category)
                @if($category->title !== null)
                    <div class="col-md-3">
                        <a href="{{route('ideas.index', [$categoriesUrl ? $categoriesUrl . '/' . $category->slug : $category->slug])}}">{{$category->title}}</a>
                        <a href="{{route('category.edit', $category->slug)}}" style="color: grey;">edit</a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</div>

</div>
@endif