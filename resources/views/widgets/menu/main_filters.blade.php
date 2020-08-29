<div class="container">
    <div class="filters">
        <div class="fw fw-fake">
            <place-filter prop-section="actions" :prop-active-place="{{json_encode($activePlaceResource ?? null)}}"></place-filter>
            <dates-filter></dates-filter>
            <time-filter :prop-filters="{{json_encode($seasonFilters ?? null)}}"></time-filter>
        </div>
    </div>
</div>
