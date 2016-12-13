<div id="map-custom-container">
    <div id="map"></div>
</div>

@section('scripts')
    <script>
        // prevent default enter to submit the page
        window.addEventListener('keydown', function(e) {
            if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
                if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
                    e.preventDefault();
                    return false;
                }
            }
        }, true);

        var hasInvoices = '<?php echo isset($hasInvoices) ? $hasInvoices : 0 ?>';

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 23.8859, lng: 45.0792},
                zoom: 6
            });
            var input = (document.getElementById('pac-input'));

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    toastr.error("{{ trans('contracts.no_details_for_input') }} '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setIcon(({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');

                    $('#pac-input').attr("name", "desc_location[]");
                }
            });
        }

        $( "#pac-input" ).change(function() {
            $(this).attr("name", "");
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('map.api') }}&language={{ Lang::locale() }}&libraries=places&callback=initMap" async
            defer></script>
@endsection
