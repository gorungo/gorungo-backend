@isset($backgroundImage)
    <div class="header-image bg-dark" style="background-image: url({{$backgroundImage}});">
        @include('parts.section_title', [
            'sectionTitle' => ucfirst(__('idea.title')),
            'sectionDescription' => ucfirst(__('idea.description')),
            'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Idea::class) ? route('ideas.new'): null,
            'addItemTitle' => __('idea.create'),
            'style' => 'dark'
            ])
<div style="height:60px;">
    @include('idea.widgets.category_selector')
    @include('widgets.menu.main_filters', ['style' => 'dark'])
</div>
@else
    <div class="header bg-white py-4 border-bottom">
    @include('parts.section_title', [
            'sectionTitle' => __('idea.description'),
            'addItemURL' => Auth()->user() && Auth()->user()->can('create', App\Idea::class) ? route('ideas.new'): null,
            'addItemTitle' => __('idea.create'),
            ])
        <random-idea></random-idea>
    @include('idea.widgets.category_selector')
    @include('widgets.menu.main_filters')
    </div>
@endisset
