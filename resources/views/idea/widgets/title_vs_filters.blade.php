@isset($backgroundImage)
    <div class="header-image" style="background-image: url({{$backgroundImage}});">
        @include('parts.section_title', [
            'sectionTitle' => __('idea.title'),
            'sectionDescription' => __('idea.description'),
            'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Idea::class) ? route('ideas.create'): null,
            'addItemTitle' => __('idea.create'),
            'style' => 'dark'
            ])
        @include('idea.widgets.category_selector')
        @include('widgets.menu.main_filters', ['style' => 'dark'])
    </div>
@else
    @include('parts.section_title', [
            'sectionTitle' => __('idea.description'),
            'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Idea::class) ? route('ideas.create'): null,
            'addItemTitle' => __('idea.create'),
            ])
    @include('idea.widgets.category_selector')
    @include('widgets.menu.main_filters')
@endisset