@can('update', $item)
<div class="btn-group pull-right user_menu_btn">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-option-horizontal"></span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item text-first-uppercase" href ="{{route('ideas.edit', $item)}}"><span class="glyphicon glyphicon-pencil"></span> {{__('editor.edit_idea')}}</a>
        <div class="dropdown-divider"></div>
        <span class="dropdown-item text-first-uppercase" id="dropdown_delete_{{$item->id}}" class="noclose" onclick="show_dropdown_delete_confirm({{$item->id}});"><span class="glyphicon glyphicon-trash"></span> {{__('editor.delete')}}...</span></span>
        <span class="dropdown-item text-first-uppercase" style="display: none;" id="dropdown_delete_confirm_{{$item->id}}" onclick="document.frm_delete{{$item->id}}.submit()"><span><span class="glyphicon glyphicon-ok"></span> {{__('editor.yes_delete')}}...</span></span>
        <form action="/ideas/{{$item->hid}}" name="frm_delete{{$item->id}}" method="post" style="display:none;">
            {{csrf_field()}}
            {!! method_field('delete') !!}
        </form>
    </div>
</div>
@endcan


