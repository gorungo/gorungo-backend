
<div class="btn-group pull-right user_menu_btn">
    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-option-horizontal"></span>
    </button>
    <ul class="dropdown-menu" >
        <li><a href ="{{route('actions.edit', $item->slug)}}"><span class="glyphicon glyphicon-pencil"></span> {{__('editor.edit_idea')}}</a></li>
        <li role="separator" class="divider"></li>

        @if($item->status != 1)
            <li><span href ="#" onclick="activate_item({{$item->id}},'ideas');"><span class="glyphicon glyphicon-play"></span> {{__('editor.activate')}}...</span></li>
        @else
            <li><span href ="#" onclick="deactivate_item({{$item->id}},'ideas');"><span class="glyphicon glyphicon-pause"></span> {{__('editor.deactivate')}}...</span></li>
        @endif

        <li id="dropdown_delete_{{$item->id}}" class="noclose" onclick="show_dropdown_delete_confirm({{$item->id}});"><span class="glyphicon glyphicon-trash"></span> Удалить...</span></li>
        <li style="display: none;" id="dropdown_delete_confirm_{{$item->id}}" onclick="document.frm_delete{{$item->id}}.submit()"><span><span class="glyphicon glyphicon-ok"></span> Да, удалить...</span></li>
        <form action="/actions/{{$item->id}}" name="frm_delete{{$item->id}}" method="post" style="display:none;">
            {{csrf_field()}}
            {!! method_field('delete') !!}
        </form>
    </ul>

</div>

