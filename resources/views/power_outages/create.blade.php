@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Тасралт бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('power_outages.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="protection_id" class="form-label">Хамгаалалт</label>
                                <div class="form-group mb-3">
                                    <select id="protection-dropdown" name="protection_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($protections as $protection)
                                            <option value="{{ $protection->id }}" {{ old('protection_id') == $protection->id ? 'selected' : '' }}>
                                                {{ $protection->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('protection_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cause_outage_id" class="form-label">Тасралтын шалтгаан</label>
                                <div class="form-group mb-3">
                                    <select id="cause-dropdown" name="cause_outage_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($causeOutages as $cause)
                                            <option value="{{ $cause->id }}" {{ old('cause_outage_id') == $cause->id ? 'selected' : '' }}>
                                                {{ $cause->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('cause_outage_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Тасарсан хугацаа</label>
                                <input id="start_time" type="text" name="start_time" class="form-control" value="{{ old('start_time') }}">
                                @error('start_time')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">Залгасан хугацаа</label>
                                <input id="end_time" type="text" name="end_time" class="form-control" value="{{ old('end_time') }}">
                                @error('end_time')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Нийт хугацаа</label></label>
                                <div class="input-group mb-3">
                                    <input id="duration" type="number" name="duration" class="form-control" value="{{ old('duration') }}">
                                    <span class="input-group-text">мин</span>
                                </div>
                                @error('duration')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="weather" class="form-label">Цаг агаар</label>
                                <input type="text" name="weather" class="form-control" value="{{ old('weather') }}">
                                @error('weather')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="current_voltage" class="form-label">Тухайн үеийн хүчдэл /кВ/</label>
                                <div class="input-group mb-3">
                                <input type="number" name="current_voltage" class="form-control" value="{{ old('current_voltage') }}">
                                <span class="input-group-text">кВ</span>
                                </div>
                                @error('current_voltage')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="current_amper" class="form-label">Гүйдэл /A/</label>
                                <input type="number" name="current_amper" class="form-control" value="{{ old('current_amper') }}">
                                @error('current_amper')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cosf" class="form-label">Cosf</label></label>
                                <input type="number" step="0.01" name="cosf" class="form-control" value="{{ old('cosf') }}">
                                @error('cosf')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ude" class="form-label">ДТЦЭХ /кВт.ц/</label></label>
                                <div class="input-group mb-3">
                                    <input type="number" step="0.01" name="ude" class="form-control" value="{{ old('ude') }}">
                                    <span class="input-group-text">кВт.ц</span>
                                </div>
                                @error('ude')
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
        function calculateDuration() {
            const startTime = $('#start_time').val();
            const endTime = $('#end_time').val();

            if (startTime && endTime) {
                const start = new Date(startTime);
                const end = new Date(endTime);
                const duration = (end - start) / 1000 / 60; // Duration in minutes

                if (!isNaN(duration)) {
                    const hours = Math.floor(duration / 60);
                    const minutes = Math.floor(duration % 60);
                    // $('#duration').val(`${hours}ц ${minutes}мин`);
                    $('#duration').val(duration);
                } else {
                    $('#duration').val('');
                }
            }
        }

        $(document).ready(function() {
            $('#station-dropdown').select2();
            $('#equipment-dropdown').select2();
            $('#cause-dropdown').select2();
            $('#protection-dropdown').select2();

            const options = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                // defaultDate: new Date(),
                onChange: calculateDuration
            };

            $('#start_time').flatpickr(options);
            $('#end_time').flatpickr(options);

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
