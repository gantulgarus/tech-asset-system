@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('equipment.update', $equipment) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="branch_id" class="form-label">Салбар</label>
                                <div class="form-group mb-3">
                                    <select  id="branch-dropdown" name="branch_id" class="form-control">
                                        @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}" {{ old('branch_id', $equipment->branch_id) == $branch->id ? 'selected' : '' }}>
                                            {{$branch->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('branch_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="station_id" class="form-label">Дэд станц / ХБ</label>
                                <div class="form-group mb-3">
                                    <select  id="station-dropdown" name="station_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($stations as $station)
                                        <option value="{{$station->id}}" {{ old('station_id', $equipment->station_id) == $station->id ? 'selected' : '' }}>
                                            {{ $station->station_type }} | {{$station->name}}
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
                                <label for="equipment_type_id" class="form-label">Тоноглолын төрөл</label>
                                <div class="form-group mb-3">
                                    <select  id="country-dropdown" name="equipment_type_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($equipmentTypes as $type)
                                        <option value="{{$type->id}}" {{ old('equipment_type_id', $equipment->equipment_type_id) == $type->id ? 'selected' : '' }}>
                                            {{$type->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('equipment_type_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Шуурхай ажиллагааны нэр</label>
                                <input type="text" name="name" value="{{ $equipment->name }}" class="form-control">
                                @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="volt_id" class="form-label">Хүчдэлийн түвшин</label>
                                <div class="form-group mb-3">
                                    <select name="volt_ids[]" id="volt_ids" class="form-control" multiple>
                                        @foreach ($volts as $volt)
                                            <option value="{{ $volt->id }}" {{ collect(old('volt_ids', $equipment->volts->pluck('id')))->contains($volt->id) ? 'selected' : '' }}>
                                                {{ $volt->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                @error('volt_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mark" class="form-label">Тип марк</label>
                                <input type="text" name="mark" value="{{ $equipment->mark }}" class="form-control">
                                @error('mark')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="production_date" class="form-label">Суурилагдсан он</label>
                                <input type="text" name="production_date" value="{{ $equipment->production_date }}" class="form-control">
                                @error('production_date')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Тайлбар</label>
                                <input type="text" name="description" value="{{ $equipment->description }}" class="form-control">
                                @error('description')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="images">Зураг:</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
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

            $('#station-dropdown').select2({
                placeholder: "-- Сонгох --",
            });

        });
    </script>
@endsection