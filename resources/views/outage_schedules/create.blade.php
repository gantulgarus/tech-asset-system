@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Таслалтын график бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('outage_schedules.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="branch_id" class="form-label">Салбар</label>
                                <div class="form-group mb-3">
                                    <select id="station-dropdown" name="branch_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
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
                                <label for="substation_line_equipment" class="form-label">Дэд станц, шугам, тоноглол</label>
                                <input type="text" name="substation_line_equipment" class="form-control" value="{{ old('substation_line_equipment') }}">
                                @error('substation_line_equipment')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="task" class="form-label">Хийх ажлын даалгавар</label>
                                <input type="text" name="task" class="form-control" value="{{ old('task') }}">
                                @error('task')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Эхлэх огноо</label>
                                <input id="start_date" type="text" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Дуусах огноо</label>
                                <input id="end_date" type="text" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Төрөл</label>
                                    <input id="type" type="text" name="type" class="form-control" value="{{ old('type') }}">
                                @error('duration')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="affected_users" class="form-label">Тасрах хэрэглэгчид</label>
                                <input type="text" name="affected_users" class="form-control" value="{{ old('affected_users') }}">
                                @error('affected_users')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="responsible_officer" class="form-label">Хариуцах албан тушаалтан</label>
                                <input type="text" name="responsible_officer" class="form-control" value="{{ old('responsible_officer') }}">
                                @error('responsible_officer')
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
            
            const options = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                // defaultDate: new Date(),
            };

            $('#start_date').flatpickr(options);
            $('#end_date').flatpickr(options);

        });
    </script>
@endsection
