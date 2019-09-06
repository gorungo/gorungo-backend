@can('update', $item)
<div class="btn-group pull-right user_menu_btn">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-option-horizontal"></span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item capitalize" href ="{{route('actions.create', ['idea' => $item->slug])}}"><span class="glyphicon glyphicon-pencil"></span> {{__('editor.new_action')}}</a>
        <a class="dropdown-item capitalize" href ="{{route('ideas.edit', $item->slug)}}"><span class="glyphicon glyphicon-pencil"></span> {{__('editor.edit_idea')}}</a>
        <div class="dropdown-divider"></div>
        <span class="dropdown-item" id="dropdown_delete_{{$item->id}}" class="noclose" onclick="show_dropdown_delete_confirm({{$item->id}});"><span class="glyphicon glyphicon-trash"></span> Удалить...</span></span>
        <span class="dropdown-item" style="display: none;" id="dropdown_delete_confirm_{{$item->id}}" onclick="document.frm_delete{{$item->id}}.submit()"><span><span class="glyphicon glyphicon-ok"></span> Да, удалить...</span></span>
        <form action="/ideas/{{$item->id}}" name="frm_delete{{$item->id}}" method="post" style="display:none;">
            {{csrf_field()}}
            {!! method_field('delete') !!}
        </form>
    </div>
</div>
@endcan


