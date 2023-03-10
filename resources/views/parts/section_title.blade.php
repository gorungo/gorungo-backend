@php
    $textColorClass = '';
    if(isset($style) && $style=='dark') $textColorClass = 'text-white';
@endphp

<div class="container">
    <div class="row mt-4">
        @if(isset($addItemURL) && isset($addItemTitle) && $addItemTitle !== '' )
            <div class="col-md-12">
                <h1 class="{{$textColorClass}} text-center text-first-uppercase">@isset($activeCategory){{$sectionTitle}} / {{$activeCategory->title}}@else{{$sectionDescription ?? $sectionTitle}}@endisset<a class="btn btn-lg btn-outline-success ml-2" href="{{$addItemURL}}"><i class="fas fa-plus mr-2"></i>{{$addItemTitle}}</a></h1>
            </div>
        @else
            <div class="col-md-12">
                <h1 class="{{$textColorClass}} text-center text-first-uppercase">@isset($activeCategory){{$sectionTitle}} / {{$activeCategory->title}}@else{{$sectionDescription ?? $sectionTitle}}@endisset</h1>
            </div>
        @endif
    </div>
</div>