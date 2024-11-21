@extends('layouts.admin')

@section('content')
<div class="container mt-2">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('budget-plans.update', $budgetPlan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Нэр</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $budgetPlan->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="branch_id" class="form-label">Салбар</label>
                    <select class="form-select" id="branch_id" name="branch_id" required>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ (isset($budgetPlan) && $budgetPlan->branch_id == $branch->id) ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Жил</label>
                    <input type="number" class="form-control" id="year" name="year" value="{{ $budgetPlan->year }}" required>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Файл</label>
                    <input type="file" class="form-control" id="file" name="file">
                </div>
                <button type="submit" class="btn btn-primary">Хадгалах</button>
            </form>
        </div>
    </div>
</div>
@endsection
