<div class="container">

    <form id="frm_MainFilters" name="MainFilters" method="get">
        <input type="hidden" id="frm_season" name="season" value="{{request()->season}}"/>
        <input type="hidden" id="frm_daytime" name="daytime" value="{{request()->daytime}}"/>
        <input type="hidden" id="frm_distance" name="distance" value="{{request()->distance}}"/>
    </form>

    <div class="row w-100 justify-content-md-center">
        <div class="col-sm-2 text-center">
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownSeason" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="filer-title">{{MainFilter::getFilterTitle('season')}}</span>
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownSeason">
                    <span class="dropdown-item" onclick="toggleFilter('season', '')">{{__('menu.season_')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('season', 'spring')" >{{__('menu.season_spring')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('season', 'summer')" >{{__('menu.season_summer')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('season', 'autumn')" >{{__('menu.season_autumn')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('season', 'winter')" >{{__('menu.season_winter')}}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-2 text-center">
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownDayTime" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="filer-title">{{MainFilter::getFilterTitle('daytime')}}</span>
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownDayTime">
                    <span class="dropdown-item" onclick="toggleFilter('daytime', '')" >{{__('menu.daytime_')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('daytime', 'morning')" >{{__('menu.daytime_morning')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('daytime', 'day')" >{{__('menu.daytime_day')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('daytime', 'evening')"  >{{__('menu.daytime_evening')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('daytime', 'night')" >{{__('menu.daytime_night')}}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-2 text-center">
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownPlace" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="filer-title">{{MainFilter::getFilterTitle('distance')}}</span>
                    <span class="caret"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownPlace">
                    <span class="dropdown-item" onclick="toggleFilter('distance', '')" >{{__('menu.distance_')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('distance', 'at')" >{{__('menu.distance_at')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('distance', 'close')" >{{__('menu.distance_close')}}</span>
                    <span class="dropdown-item" onclick="toggleFilter('distance', 'far')" >{{__('menu.distance_far')}}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function toggleFilter(filter, value){
            $('#frm_' + filter).val(value);
            $( "#frm_MainFilters" ).submit();
        }
    </script>
@endpush