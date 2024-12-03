@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Гэмтэл бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('power_failures.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="station_id" class="form-label">Дэд станц</label>
                                <div class="form-group mb-3">
                                    <select id="station-dropdown" name="station_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>
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
                                        {{-- @foreach ($equipments as $equipment)
                                            <option value="{{ $equipment->id }}">
                                                {{ $equipment->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                @error('equipment_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="failure_date" class="form-label">Илрүүлсэн огноо</label>
                                <input id="failure_date" type="text" name="failure_date" class="form-control" value="{{ old('failure_date') }}">
                                @error('failure_date')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="detector_name" class="form-label">Илрүүлсэн хүний албан тушаал</label>
                                <input type="text" name="detector_name" class="form-control" value="{{ old('detector_name') }}">
                                @error('detector_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="failure_detail" class="form-label">Илэрсэн гэмтэл</label>
                                <input type="text" name="failure_detail" class="form-control" value="{{ old('failure_detail') }}">
                                @error('failure_detail')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="notified_name" class="form-label">Гэмтлийн талаар мэдэгдсэн хүний албан тушаал, нэр</label>
                                <input type="text" name="notified_name" class="form-control" value="{{ old('notified_name') }}">
                                @error('notified_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="action_taken" class="form-label">Гэмтэл арилгахаар авсан арга хэмжээ</label>
                                <input type="text" name="action_taken" class="form-control" value="{{ old('action_taken') }}">
                                @error('action_taken')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fixer_name" class="form-label">Гэмтэл арилгасан хүний албан тушаал, нэр</label>
                                <input type="text" name="fixer_name" class="form-control" value="{{ old('fixer_name') }}">
                                @error('fixer_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inspector_name" class="form-label">Гэмтэл арилгасныг шалгаж, хүлээн авсан хүний албан тушаал, нэр</label>
                                <input type="text" name="inspector_name" class="form-control" value="{{ old('inspector_name') }}">
                                @error('inspector_name')
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
            $('#cause-dropdown').select2();
            $('#protection-dropdown').select2();

            const options = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
            };

            $('#failure_date').flatpickr(options);

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
