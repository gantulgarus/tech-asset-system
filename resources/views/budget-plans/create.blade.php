@extends('layouts.admin')

@section('content')
<div class="container mt-2">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('budget-plans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Нэр</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="branch_id" class="form-label">Салбар</label>
                        <select  id="country-dropdown" name="branch_id" class="form-select">
                            <option value="">-- Сонгох --</option>
                            @foreach ($branches as $branch)
                            <option value="{{$branch->id}}">
                                {{$branch->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Жил</label>
                        <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Файл</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Хадгалах</button>
            </form>
        </div>
    </div>
</div>
@endsection
