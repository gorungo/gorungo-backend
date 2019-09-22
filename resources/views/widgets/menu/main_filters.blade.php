<div class="container">
    <div class="row justify-content-md-center">
    <season-filter :prop-filters="{{json_encode($seasonFilters ?? null)}}"></season-filter>
    <time-filter :prop-filters="{{json_encode($seasonFilters ?? null)}}"></time-filter>
    <main-place-filter prop-section="actions" :prop-active-place="{{json_encode($activePlaceResource ?? null)}}"></main-place-filter>
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