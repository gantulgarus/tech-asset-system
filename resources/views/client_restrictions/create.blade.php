@extends('layouts.admin')

@section('content')
    

    <form action="{{ route('client-restrictions.store') }}" method="POST">
        @csrf
        <div class="container">
            <h3>Хязгаарлалт лавлах сан</h3>
            <div class="mb-3">
                <label for="branch_id" class="form-label">Салбар</label>
                <div class="form-group mb-3">
                    <select id="branch-dropdown" name="branch_id" class="form-select">
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('branch_id')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="station_id" class="form-label">Дэд станц / ХБ</label>
                <div class="form-group mb-3">
                    <select id="station-dropdown" name="station_id" class="form-select">
                        <option></option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}">
                                {{ $station->station_type }} | {{ $station->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('station_id')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="output_name" class="form-label">Гаргалгааны нэр</label>
                <input type="text" name="output_name" id="output_name" class="form-control"
                    value="{{ old('output_name') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Хадгалах</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#station-dropdown').select2({
                placeholder: "-- Сонгох --",
                allowClear: true
            });

        });
    </script>
@endsection