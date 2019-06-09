
@php $dates_count=0; @endphp
@foreach($action->actionDates as $date)
    @if(strtotime($date->start_datetime_utc) > date('m-d-Y'))
        @php $dates_count++; @endphp

        @if($dates_count == 1)
            <div class="item-date-time">
                <div class="clearfix">
                    <img class="mr-2" alt="" src="/images/interface/icos/calendar_ico.svg" style="height: 16px;"/>
                    {{str_replace(', 00:00','',Helper::rDate("j M, H:i", strtotime($date->start_datetime_utc)))}},
                    <span>{{Helper::dayOfWeekShort(date("w", strtotime($date->start_datetime_utc)))}}</span>
                    @if(count($action->actionDates)>1)
                        <a class="other-date-time" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Еще даты: {{count($action->actionDates) - 1}}
                            <span class="icomoon"></span>
                        </a>
                    @endif
                </div>
            </div>
        @else
            @if($dates_count == 2)
                <div id="collapseOne" class="panel-collapse collapse"><div class="panel-body dop-dates-wrap">
            @endif
                <span class="item-date-time-future"><span class="icomoon color-icon-grey"></span> {{str_replace(', 00:00','',Helper::rdate("j M, H:i", strtotime($date->start_datetime_utc)))}}, <span>{{Helper::dayOfWeekShort(date("w", strtotime($date->start_datetime_utc)))}}</span></span class="item-date-time-future">
        @endif

    @endif
@endforeach

@if($dates_count > 1)
        </div>
    </div>
@endif