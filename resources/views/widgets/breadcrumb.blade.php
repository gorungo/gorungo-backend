@if(isset($breadcrumb_array))
    <div class="container margin-top">
        <ol class="breadcrumb">
    @foreach($breadcrumb_array as $bread_item)

    @if($loop->last)
        <li class="active"><span><a href="{{$bread_item['url']}}" title="{{$bread_item['title']}}">{{$bread_item['title']}}</a></span></li>
    @else
        <li><span><a href="{{$bread_item['url']}}" title="{{$bread_item['title']}}">{{$bread_item['title']}}</a></span></li>
    @endif
    @endforeach
        </ol>
    </div>
@endif