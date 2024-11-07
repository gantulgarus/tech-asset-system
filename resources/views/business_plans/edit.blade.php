@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('business-plans.update', $businessPlan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group">
                            <label for="branch_id" class="form-label">Салбар</label>
                            <select name="branch_id" class="form-control">
                                <option value="">-- Сонгох --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $businessPlan->branch_id == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="plan_type">Төрөл</label>
                            <select name="plan_type" id="plan_type" class="form-control" required>
                                <option value="Их засвар" {{ $businessPlan->plan_type == 'Их засвар' ? 'selected' : '' }}>Их засвар</option>
                                <option value="ТЗБАХ" {{ $businessPlan->plan_type == 'ТЗБАХ' ? 'selected' : '' }}>ТЗБАХ</option>
                                <option value="Хөрөнгө оруулалт" {{ $businessPlan->plan_type == 'Хөрөнгө оруулалт' ? 'selected' : '' }}>Хөрөнгө оруулалт</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="infrastructure_name">Хэсэг, нэгж, дэд станц, шугамын нэр</label>
                            <input type="text" name="infrastructure_name" id="infrastructure_name" class="form-control" required value="{{ $businessPlan->infrastructure_name }}">
                        </div>

                        <div class="form-group">
                            <label for="task_name">Ажлын нэр</label>
                            <input type="text" name="task_name" id="task_name" class="form-control" required value="{{ $businessPlan->task_name }}">
                        </div>

                        <div class="form-group">
                            <label for="unit">Хэмжих нэгж</label>
                            <input type="text" name="unit" id="unit" class="form-control" required value="{{ $businessPlan->unit }}">
                        </div>

                        <div class="form-group">
                            <label for="quantity">Тоо хэмжээ</label>
                            <input type="number" step="0.00001" name="quantity" id="quantity" class="form-control" required value="{{ $businessPlan->quantity }}">
                        </div>

                        <div class="form-group">
                            <label for="budget_without_vat">Төсөвт өртөг НӨАТ-гүй (сая төг) </label>
                            <input type="number" name="budget_without_vat" id="budget_without_vat" class="form-control" required value="{{ $businessPlan->budget_without_vat }}">
                        </div>

                        <div class="form-group">
                            <label for="performance_amount">Гүйцэтгэл (сая төг)</label>
                            <input type="number" step="0.00001" name="performance_amount" id="performance_amount" class="form-control" required value="{{ $businessPlan->performance_amount }}">
                        </div>

                        <div class="form-group">
                            <label for="variance_amount">Хэтрэлт, хэмнэлт (сая төг)</label>
                            <input type="number" step="0.00001" name="variance_amount" id="variance_amount" class="form-control" required value="{{ $businessPlan->variance_amount }}">
                        </div>

                        <div class="form-group">
                            <label for="desc" class="form-label">Тайлбар</label>
                            <input type="text" name="desc" class="form-control" value="{{ $businessPlan->desc }}">
                            @error('desc')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="performance_percentage">Гүйцэтгэл (%)</label>
                            <input type="number" step="0.00001" name="performance_percentage" id="performance_percentage" class="form-control" required value="{{ $businessPlan->performance_percentage }}">
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

    </script>
@endsection
