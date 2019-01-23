@php
    $categoriesCount = 0;
@endphp
<div id="category-selector-block">
    @isset($item)
        @foreach($item->ideaCategories as $categoryIndex => $category)
            <div class="category-item @if($item->main_category_id != $category->id) main-category @endif" id="category-item-{{$categoryIndex}}" ondblclick="setMainCategory({{$categoryIndex}})">
                <input type="hidden" name="categories[{{$categoryIndex}}][id]" id="frm-category-{{$categoryIndex}}" value="{{$category->id}}" />
                <span  id="category-item-{{$categoryIndex}}-title">{{$category->title}}</span>
                <button type="button" class="btn btn-category" onclick="editCategory({{$categoryIndex}});" title="{{__('editor.edit_category')}}">
                    <span class="text-capitalize">{{__('editor.edit')}}</span>
                </button>
                <button type="button" class="btn btn-category" onclick="removeCategory({{$categoryIndex}});" title="{{__('editor.remove_category')}}"><span class="text-capitalize">{{__('editor.delete')}}</span></button>
            </div>
            @php
                $categoriesCount = $categoryIndex;
            @endphp
        @endforeach
    @endisset
</div>
<input type="hidden" id="frm_main_category_id" name="main_category_id" @isset($item)value="{{$item->main_category_id}}"@else value="0"@endif />
<script>
    categoriesCount = <?php echo $categoriesCount; ?>;
</script>
<button type="button" class="btn btn-category" data-toggle="modal" data-target="#category-selector" onclick="addCategory();">
    {{__('editor.new_category')}}
</button>
@push('scripts')
    <script src="{{asset('/js/category.js')}}"></script>
@endpush