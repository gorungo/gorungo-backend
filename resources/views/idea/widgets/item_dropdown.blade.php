@can('update', $item)
<idea-item-dropdown hid="{{$item->hid}}" edit-url="{{$item->editUrl}}" :can-edit="true"></idea-item-dropdown>
@endcan
@cannot('update', $item)
    <idea-item-dropdown hid="{{$item->hid}}" :can-edit="false"></idea-item-dropdown>
@endcannot