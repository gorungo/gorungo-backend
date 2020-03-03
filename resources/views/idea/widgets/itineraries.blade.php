@if($idea->ideaItineraries->count())
    <itineraries-list :prop-itineraries="{{json_encode(\App\Http\Resources\Itinerary::collection($idea->ideaItineraries))}}" />
@endif
