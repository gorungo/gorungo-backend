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
                    <a class="dropdown-item" onclick="toggleFilter('season', '')" href="#">{{__('menu.season_')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('season', 'spring')" href="#">{{__('menu.season_spring')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('season', 'summer')" href="#">{{__('menu.season_summer')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('season', 'autumn')" href="#">{{__('menu.season_autumn')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('season', 'winter')" href="#">{{__('menu.season_winter')}}</a>
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
                    <a class="dropdown-item" onclick="toggleFilter('daytime', '')" href="#">{{__('menu.daytime_')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('daytime', 'morning')" href="#">{{__('menu.daytime_morning')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('daytime', 'day')" href="#">{{__('menu.daytime_day')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('daytime', 'evening')" href="#">{{__('menu.daytime_evening')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('daytime', 'night')" href="#">{{__('menu.daytime_night')}}</a>
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
                    <a class="dropdown-item" onclick="toggleFilter('distance', '')" href="#">{{__('menu.distance_')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('distance', 'at')" href="#">{{__('menu.distance_at')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('distance', 'close')" href="#">{{__('menu.distance_close')}}</a>
                    <a class="dropdown-item" onclick="toggleFilter('distance', 'far')" href="#">{{__('menu.distance_far')}}</a>
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