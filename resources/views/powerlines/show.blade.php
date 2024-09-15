@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            {{-- <div class="col">
                <div id="map" style="height: 600px;"></div>
            </div> --}}
            
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="stationTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="details-tab" data-coreui-toggle="tab" href="#details"
                                    role="tab" aria-controls="details" aria-selected="true">Шугамын мэдээлэл</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-coreui-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Шугамын түүх</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="messages-tab" data-coreui-toggle="tab" href="#messages"
                                    role="tab" aria-controls="messages" aria-selected="false">Эргэлт, зөрлөгийн зураг</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="mapContainer-tab" data-coreui-toggle="tab" href="#mapContainer"
                                    role="tab" aria-controls="mapContainer" aria-selected="false">Трасс</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="stationTabContent">
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="row">
                                    <div class="col">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Дэд станц</th>
                                                    <td>{{ $powerline->station->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Шугамын ША-ны нэр</th>
                                                    <td>{{ $powerline->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Хүчдлийн түвшин /кВ/</th>
                                                    <td>
                                                        {{ $powerline->volt->name }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Ашиглалтад орсон он</th>
                                                    <td>{{ $powerline->create_year }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Утасны марк</th>
                                                    <td>{{ $powerline->line_mark }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Тулгуурын марк</th>
                                                    <td>{{ $powerline->tower_mark }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Тулгуурын тоо</th>
                                                    <td>{{ $powerline->tower_count }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Шугамын урт /км/</th>
                                                    <td>{{ $powerline->line_length }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Изоляторын маяг</th>
                                                    <td>{{ $powerline->isolation_mark }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h5>Тоноглолын мэдээлэл</h5>
                            </div>
                            <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                                <div class="container">
                                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="mapContainer" role="tabpanel" aria-labelledby="mapContainer-tab">
                                <h5>Дэд станцын байршлын мэдээлэл</h5>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div id="map" style="height: 600px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>

    var map = L.map('map').setView([47.92123, 106.918556], 8); // Set initial center and zoom

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var geojsonLayer;

    // Function to add the GeoJSON layer with point filtering
    function addGeoJsonLayer() {
        fetch('{{ asset('storage/' . $geojson->path) }}')
            .then(response => response.json())
            .then(data => {
                // Remove the previous layer if it exists
                if (geojsonLayer) {
                    map.removeLayer(geojsonLayer);
                }

                geojsonLayer = L.geoJSON(data, {
                    pointToLayer: function (feature, latlng) {
                        console.log(latlng);
                        // Only add the point if the zoom level is 14 or greater
                        if (map.getZoom() >= 14) {
                            return L.circleMarker(latlng, {
                                radius: 5,
                                fillColor: feature.properties.stroke || "#3388ff",
                                color: feature.properties.stroke || "#3388ff",
                                weight: 1,
                                opacity: 1,
                                fillOpacity: 0.8
                            });
                        }
                        return null; // Return null to skip adding the marker
                    },
                    style: function (feature) {
                        return {
                            color: feature.properties.stroke || "#3388ff", 
                            weight: 1.5, // Decreased line width
                            opacity: 1
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup('<b>' + feature.properties.name + '</b>');
                        var tooltip = '110 kV'; // Change this to your desired text
                        if (map.getZoom() < 14) {
                            layer.bindTooltip(tooltip, {
                                permanent: true, // Always show the label
                                direction: "center", // Position the label in the center of the line
                                offset: [0, 10],
                                className: "line-label" // Optional: add custom class for styling
                            });
                        } else {
                            // Remove tooltip if zoom level is 14 or greater
                            layer.unbindTooltip();
                        }
                    }
                }).addTo(map);

                // // Find the bounds of the geojsonLayer
                // var bounds = geojsonLayer.getBounds();
                // // Calculate the center of the bounds
                // var center = bounds.getCenter();
                // // Set the view to the center of the bounds
                // map.setView(center, 10); // Adjust zoom level as needed
                // // map.fitBounds(bounds);

                // Find the bounds of the geojsonLayer
                var bounds = geojsonLayer.getBounds();
                // Fit the map to the bounds
                // map.fitBounds(bounds);

            });
    }

    // Add the GeoJSON layer initially
    addGeoJsonLayer();

    // Update the GeoJSON layer when zoom level changes
    map.on('zoomend', function () {
        addGeoJsonLayer();
    });

    // Listen for the tab to be shown
    $('a[data-coreui-toggle="tab"]').on('shown.coreui.tab', function (e) {
        if ($(e.target).attr('href') === '#mapContainer') {
            setTimeout(function() {
                map.invalidateSize();
            }, 10); // Delay to ensure the tab is fully visible
        }
    });
</script>
@endsection