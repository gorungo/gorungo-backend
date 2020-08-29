@if($item->photos)
<div class="grid-container grid-columns-gallery-1">
    @foreach($item->photos as $photo)
        <div class="img-wrap @if($loop->iteration !== 3 && $loop->iteration !== 4)vertical @endif i{{$loop->iteration}}"><img src="{{$photo->url}}" /></div>
        @if($loop->iteration === 5) @break @endif
    @endforeach
</div>
@endif
