@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Захиалга бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('order-journals.update', $orderJournal) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="station_id" class="form-label">Дэд станц</label>
                                <div class="form-group mb-3">
                                    <select id="station-dropdown" name="station_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('station_id', $orderJournal->station_id) == $station->id ? 'selected' : '' }}>
                                                {{ $station->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('station_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="equipment_id" class="form-label">Тоноглол</label>
                                <div class="form-group mb-3">
                                    <select id="equipment-dropdown" name="equipment_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($equipments as $equipment)
                                            <option value="{{ $equipment->id }}" {{ old('equipment_id', $orderJournal->equipment_id) == $equipment->id ? 'selected' : '' }}>
                                                {{ $equipment->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('equipment_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order_type_id" class="form-label">Захиалгын төрөл</label>
                                <div class="form-group mb-3">
                                    <select id="type-dropdown" name="order_type_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($orderTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('order_type_id', $orderJournal->order_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('order_type_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="content" class="form-label">Захиалгын агуулга, захиалга өгсөн, дамжуулсан хүний албан тушаал нэр </label>
                                <textarea name="content" rows="4" class="form-control">{{ old('content', $orderJournal->content) }}</textarea>
                                @error('content')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Таслах өдөр, цаг</label>
                                <input id="start_date"  type="text" name="start_date" class="form-control" value="{{ $orderJournal->start_date }}">
                                @error('start_date')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Залгах өдөр, цаг</label>
                                <input id="end_date" type="text" name="end_date" class="form-control" value="{{ $orderJournal->end_date }}">
                                @error('end_date')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary ml-3">Хадгалах</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $(document).ready(function() {
            $('#station-dropdown').select2();
            $('#equipment-dropdown').select2();

            const options = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
            };

            $('#start_date').flatpickr(options);
            $('#end_date').flatpickr(options);

            var oldStationId = "{{ old('station_id') }}";
            var oldEquipmentId = "{{ old('equipment_id') }}";

            if (oldStationId) {
                loadEquipments(oldStationId, oldEquipmentId);
            }

            $('#station-dropdown').on('change', function() {
                var stationId = this.value;
                loadEquipments(stationId);
            });

            function loadEquipments(stationId, selectedEquipmentId = null) {
                $("#equipment-dropdown").html('');
                $.ajax({
                    url: "{{ url('equipments') }}/" + stationId,
                    type: "GET",
                    dataType: 'json',
                    success: function(result) {
                        $('#equipment-dropdown').html('<option value="">-- Сонгох --</option>');
                        $.each(result, function(key, value) {
                            var selected = selectedEquipmentId == value.id ? 'selected' : '';
                            $("#equipment-dropdown").append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endsection