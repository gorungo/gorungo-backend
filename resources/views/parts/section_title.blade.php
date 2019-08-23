@php
    $textColorClass = 'text-primary';
    if(isset($style) && $style=='dark') $textColorClass = 'text-white';
@endphp

<div class="container">
    <div class="row mt-4">
        @if(isset($addItemURL) && isset($addItemTitle) )
            <div class="col-md-10">
                <h1 class="{{$textColorClass}} text-center">@isset($activeCategory){{$sectionTitle}} / {{$activeCategory->title}}@else{{$sectionDescription ?? $sectionTitle}}@endisset</h1>
            </div>
            <div class="col-md-2">
                <a class="btn btn-outline-primary float-right" href="{{$addItemURL}}">{{$addItemTitle}}</a>
            </div>
        @else
            <div class="col-md-12">
                <h1 class="{{$textColorClass}} text-center">@isset($activeCategory){{$sectionTitle}} / {{$activeCategory->title}}@else{{$sectionDescription ?? $sectionTitle}}@endisset</h1>
            </div>
        @endif
    </div>
</div>