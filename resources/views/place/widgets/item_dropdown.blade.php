@can('update', $item)
<div class="btn-group pull-right user_menu_btn">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-option-horizontal"></span>
    </button>
    <div class="dropdown-menu">
        @can('update', $item)
        <a class="dropdown-item capitalize" href ="{{route('places.edit', $item->id)}}"><span class="glyphicon glyphicon-pencil"></span> {{__('editor.edit_place')}}</a>
        <div class="dropdown-divider"></div>
        @endcan

        @hasanyrole('moderator|super-admin')
        @if($item->status != 1)
            <span class="dropdown-item capitalize" href ="#" onclick="activate_item({{$item->id}},'place');"><span class="glyphicon glyphicon-play"></span> {{__('editor.activate')}}...</span>
        @else
            <span class="dropdown-item capitalize" href ="#" onclick="deactivate_item({{$item->id}},'place');"><span class="glyphicon glyphicon-pause"></span> {{__('editor.deactivate')}}...</span>
        @endif
        @endhasanyrole

        <span class="dropdown-item" id="dropdown_delete_{{$item->id}}" class="noclose" onclick="show_dropdown_delete_confirm({{$item->id}});"><span class="glyphicon glyphicon-trash"></span> Удалить...</span></span>
        <span class="dropdown-item" style="display: none;" id="dropdown_delete_confirm_{{$item->id}}" onclick="document.frm_delete{{$item->id}}.submit()"><span><span class="glyphicon glyphicon-ok"></span> Да, удалить...</span></span>
        <form action="/places/{{$item->id}}" name="frm_delete{{$item->id}}" method="post" style="display:none;">
            {{csrf_field()}}
            {!! method_field('delete') !!}
        </form>
    </div>
</div>
@endcan

