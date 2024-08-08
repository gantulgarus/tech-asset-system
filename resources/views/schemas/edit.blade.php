<!-- resources/views/schemas/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Шинэ схем бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('schemas.update', $schema->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Нэр</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $schema->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="station_id">Дэд станц</label>
                        <select class="form-control" id="station_id" name="station_id" required>
                            @foreach ($stations as $station)
                                <option value="{{ $station->id }}" {{ $schema->station_id == $station->id ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Зураг</label>
                        <input type="file" class="form-control mb-3" id="image" name="image">
                        @if ($schema->image)
                            <img src="{{ asset('storage/' . $schema->image) }}" width="100" height="100">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
        
    </div>
@endsection
