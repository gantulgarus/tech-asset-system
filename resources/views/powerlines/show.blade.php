@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div>Шугамын мэдээлэл</div>
                    </div>
                    <div class="card-body">
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
                                            <td>{{ $powerline->volt->name }}</td>
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
                        <a href="{{ route('powerlinegeojson.create') }}" class="btn btn-dark btn-sm mb-2">Схем оруулах</a>
                        <div id="map" style="height: 600px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map;
    var geojsonLayer;

    // Initialize the map with a temporary center and zoom level
    function initializeMap() {
        map = L.map('map').setView([47.92123, 106.918556], 8); // Set initial view before GeoJSON loads

        // Add the tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    }

    // Function to add the GeoJSON layer
    function addGeoJsonLayer() {
        fetch('{{ asset('storage/' . $geojson?->path) }}')
            .then(response => response.json())
            .then(data => {
                // Remove the previous layer if it exists
                if (geojsonLayer) {
                    map.removeLayer(geojsonLayer);
                }

                geojsonLayer = L.geoJSON(data, {
                    pointToLayer: function (feature, latlng) {
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
                        return null;
                    },
                    style: function (feature) {
                        return {
                            color: feature.properties.stroke || "#3388ff",
                            weight: 1.5,
                            opacity: 1
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.bindPopup('<b>' + feature.properties.name + '</b>');
                        var tooltip = feature.properties.name;
                        if (map.getZoom() < 14) {
                            layer.bindTooltip(tooltip, {
                                permanent: true,
                                direction: "center",
                                offset: [0, 10],
                                className: "line-label"
                            });
                        } else {
                            layer.unbindTooltip();
                        }
                    }
                }).addTo(map);

                // Automatically fit the map to the GeoJSON bounds
                var bounds = geojsonLayer.getBounds();
                map.fitBounds(bounds);
            });
    }

    // Initialize the map and load the GeoJSON layer
    document.addEventListener('DOMContentLoaded', function () {
        initializeMap(); // Set up the map
        addGeoJsonLayer(); // Load the GeoJSON layer
    });
</script>
@endsection
