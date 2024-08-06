@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Тасралт бүртгэх
            </div>
            <div class="card-body">

                <form action="{{ route('power_outages.update', $powerOutage) }}" method="POST" enctype="multipart/form-data">
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
                                            <option value="{{ $station->id }}" {{ old('station_id', $powerOutage->station_id) == $station->id ? 'selected' : '' }}>
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
                                            <option value="{{ $equipment->id }}" {{ old('equipment_id', $powerOutage->equipment_id) == $equipment->id ? 'selected' : '' }}>
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
                                <label for="protection_id" class="form-label">Хамгаалалт</label>
                                <div class="form-group mb-3">
                                    <select id="protection-dropdown" name="protection_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($protections as $protection)
                                            <option value="{{ $protection->id }}" {{ old('protection_id', $powerOutage->protection_id) == $protection->id ? 'selected' : '' }}>
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
                                            <option value="{{ $cause->id }}" {{ old('cause_outage_id', $powerOutage->cause_outage_id) == $cause->id ? 'selected' : '' }}>
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
                                <input type="text" name="start_time" value="{{ $powerOutage->start_time }}" class="form-control">
                                @error('start_time')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">Залгасан хугацаа</label>
                                <input type="text" name="end_time" value="{{ $powerOutage->end_time }}" class="form-control">
                                @error('end_time')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Нийт хугацаа</label></label>
                                <input type="text" name="duration" value="{{ $powerOutage->duration }}" class="form-control">
                                @error('duration')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="weather" class="form-label">Цаг агаар</label></label>
                                <input type="text" name="weather" value="{{ $powerOutage->weather }}" class="form-control">
                                @error('weather')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="current_voltage" class="form-label">Тухайн үеийн хүчдэл /кВ/</label></label>
                                <input type="number" name="current_voltage" value="{{ $powerOutage->current_voltage }}" class="form-control">
                                @error('current_voltage')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="current_amper" class="form-label">Гүйдэл /A/</label></label>
                                <input type="number" name="current_amper" value="{{ $powerOutage->current_amper }}" class="form-control">
                                @error('current_amper')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Cosf" class="form-label">Cosf</label></label>
                                <input type="number" name="cosf" value="{{ $powerOutage->cosf }}" class="form-control">
                                @error('cosf')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ude" class="form-label">ДТЦЭХ /кВт.ц/</label></label>
                                <input type="number" name="ude" value="{{ $powerOutage->ude }}" class="form-control">
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
        $(document).ready(function() {
            $('#volt_ids').select2({
                placeholder: "-- Сонгох --",
                allowClear: true
            });
        });
    </script>
@endsection
