@isset($backgroundImage)
    <div class="header-image header-image-short bg-dark" style="background-image: url({{$backgroundImage}});">
        @include('parts.section_title', [
        'activePlace' => $activePlace,
        'sectionTitle' => $sectionTitle,
        'sectionDescription' => __('place.description'),
        'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Place::class) ? route('places.create') : null,
        'addItemTitle' => __('place.create'),
        'style' => 'dark',
        ])
        @include('place.widgets.place_filter')
    </div>
@else
    @include('parts.section_title', [
        'activePlace' => $activePlace,
        'sectionTitle' => $sectionTitle,
        'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Place::class) ? route('places.create') : null,
        'addItemTitle' => __('place.create'),
        ])
    @include('place.widgets.place_filter')
    @include('place.widgets.place_type_selector')
@endisset