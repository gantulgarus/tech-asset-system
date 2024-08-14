@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary mb-2">Буцах</a>
        <div class="card">
            <div class="card-header">
                Тоноглолын түүх бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('equipment-histories.update', $equipmentHistory) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- <input type="hidden" name="equipment_id" value="{{ $equipment_id }}"> --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="equipment_id" class="form-label">Тоноглол</label>
                                <div class="form-group mb-3">
                                    <select name="equipment_id" class="form-control" disabled>
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($equipments as $equipment)
                                            <option value="{{ $equipment->id }}" {{ old('equipment_id', $equipmentHistory->equipment_id) == $equipment->id ? 'selected' : '' }}>
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
                                <label for="task_date" class="form-label">Огноо</label>
                                <input id="task_date" type="text" name="task_date" class="form-control" value="{{ $equipmentHistory->task_date }}">
                                @error('task_date')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="work_type" class="form-label">Ажлын төрөл</label>
                                <input type="text" name="work_type" class="form-control" value="{{ $equipmentHistory->work_type }}">
                                @error('work_type')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="completed_task" class="form-label">Хийгдсэн ажил</label>
                                <input type="text" name="completed_task" class="form-control" value="{{ $equipmentHistory->completed_task }}">
                                @error('completed_task')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="team_members" class="form-label">Бригадын бүрэлдэхүүн</label>
                                <input type="text" name="team_members" class="form-control" value="{{ $equipmentHistory->team_members }}">
                                @error('team_members')
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
            // $('#equipment-dropdown').select2();

            const options = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
            };

            $('#task_date').flatpickr(options);
        });
    </script>
@endsection
