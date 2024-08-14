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
                                    aria-controls="profile" aria-selected="false">Тоноглолын түүх</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="stationTabContent">
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Салбар</th>
                                                    <td>{{ $equipment->branch->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Дэд станцын нэр</th>
                                                    <td>{{ $equipment->station->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Төрөл</th>
                                                    <td>{{ $equipment->equipmentType->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Шуурхай ажиллагааны нэр</th>
                                                    <td>{{ $equipment->name }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Хүчдлийн түвшин /кВ/</th>
                                                    <td>
                                                        @foreach ($equipment->volts as $volt)
                                                            <span>{{ $volt->name }}</span>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                        кВ
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Марк</th>
                                                    <td>{{ $equipment->mark }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Үйлдвэрлэгдсэн он</th>
                                                    <td>{{ $equipment->production_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Тайлбар</th>
                                                    <td>{{ $equipment->description }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-8">
                                        <h5>Зураг</h5>
                                        <div class="row photos">
                                        @foreach ($equipment->images as $image)
                                            <div class="col-sm-6 col-md-4 col-lg-3 item">
                                                <a href="{{ asset('storage/' . $image->file_path) }}"
                                                data-lightbox="photos"><img class="img-fluid img-thumbnail" style="height: 200px; width: 300px; object-fit: cover;"
                                                src="{{ asset('storage/' . $image->file_path) }}"></a>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                @include('equipment_histories.index')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
