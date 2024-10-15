@extends('layouts.admin')

@section('content')
<div class="container mt-2">
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-2">Буцах</a>
    <div class="card">
        <div class="card-header">
            График оруулах
        </div>
        <div class="card-body">

            <form action="{{ route('maintenance-plans.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Тоноглол</label>
                            <div class="form-group">
                                <select name="equipment_id" class="form-control">
                                    @foreach($equipment as $equip)
                                    <option value="{{ $equip->id }}" {{ $equipment_id == $equip->id ? 'selected' : '' }}>
                                        {{ $equip->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Жил</label>
                            <div class="form-group">
                                <input type="number" name="year" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ажлын төрөл</label>
                            <div class="form-group">
                                <select name="work_type_id" class="form-control">
                                    @foreach($workTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary ml-3">Хадгалах</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
