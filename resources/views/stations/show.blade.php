@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="row">
            
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="stationTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="details-tab" data-coreui-toggle="tab" href="#details"
                                    role="tab" aria-controls="details" aria-selected="true">Мэдээлэл</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-coreui-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Тоноглол</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="messages-tab" data-coreui-toggle="tab" href="#messages"
                                    role="tab" aria-controls="messages" aria-selected="false">Схем</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="mapContainer-tab" data-coreui-toggle="tab" href="#mapContainer"
                                    role="tab" aria-controls="mapContainer" aria-selected="false">Байршил</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="stationTabContent">
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Салбар</th>
                                                    <td>{{ $station->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Дэд станцын нэр</th>
                                                    <td>{{ $station->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Эх үүсвэр</th>
                                                    <td>{{ $station->desc }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Хүчдэлийн түвшин /кВ/</th>
                                                    <td>
                                                        @foreach ($station->volts as $volt)
                                                            <span>{{ $volt->name }}</span>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Ашиглалтад орсон он</th>
                                                    <td>{{ $station->create_year }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Суурилагдсан хүчин чадал</th>
                                                    <td>{{ $station->installed_capacity }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>QR код</h3>
                                        <div>{!! $qrCode !!}</div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h5>Тоноглолын мэдээлэл</h5>
                                <table class="table table-bordered table-sm" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">Д/д</th>
                                            <th>Салбар</th>
                                            <th>Дэд станц</th>
                                            <th>Тоноглолын төрөл</th>
                                            <th>Шуурхай ажиллагааны нэр</th>
                                            <th>Хүчдэлийн түвшин</th>
                                            <th>Тип марк</th>
                                            <th>Үйлдвэрлэгдсэн он</th>
                                            <th>Үйлдэл</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipments as $equipment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $equipment->branch->name }}</td>
                                                <td>{{ $equipment->station->name }}</td>
                                                <td>{{ $equipment->equipmentType->name }}</td>
                                                <td>{{ $equipment->name }}</td>
                                                <td>
                                                    @foreach ($equipment->volts as $volt)
                                                        <span>{{ $volt->name }}</span>
                                                        @if (!$loop->last)
                                                            /
                                                        @endif
                                                    @endforeach
                                                    кВ
                                                </td>
                                                <td>{{ $equipment->mark }}</td>
                                                <td>{{ $equipment->production_date }}</td>
                                                <td>
                                                    <a class="btn btn-info btn-sm text-white"
                                                        href="{{ route('equipment.show', $equipment) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('equipment.edit', $equipment) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <div class="d-inline-flex">
                                                        <form action="{{ route('equipment.destroy', $equipment) }}"
                                                            method="Post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger text-white">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                                <div class="container">
                                    <a href="{{ route('schemas.create') }}" class="btn btn-primary mb-2">Нэмэх</a>
                                    <a href="{{ route('schemas.index') }}" class="btn btn-warning mb-2">Засах</a>
                                    <div class="row photos">
                                        @foreach ($schemas as $schema)
                                        <div class="col-sm-6 col-md-4 col-lg-3 item">
                                                <a
                                                    href="{{ asset('storage/' . $schema->image) }}"
                                                    data-lightbox="photos"><img class="img-fluid img-thumbnail" style="height: 200px; width: 300px; object-fit: cover;"
                                                        src="{{ asset('storage/' . $schema->image) }}">
                                                </a>
                                                <h6>{{ $schema->name }}</h6>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{-- @include('schemas.index') --}}
                            </div>
                            <div class="tab-pane fade" id="mapContainer" role="tabpanel" aria-labelledby="mapContainer-tab">
                                <h5>Дэд станцын байршлын мэдээлэл</h5>
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <div id="map" style="height: 400px;"></div>
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
    var map = L.map('map').setView([51.505, -0.09], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

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