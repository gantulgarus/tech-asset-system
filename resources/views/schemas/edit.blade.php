<!-- resources/views/schemas/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Схем засах</h1>
        <form action="{{ route('schemas.update', $schema->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Нэр</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $schema->name }}" required>
            </div>
            <div class="form-group">
                <label for="station_id">Дэд станц</label>
                <select class="form-control" id="station_id" name="station_id" required>
                    @foreach ($stations as $station)
                        <option value="{{ $station->id }}" {{ $schema->station_id == $station->id ? 'selected' : '' }}>
                            {{ $station->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Зураг</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @if ($schema->image)
                    <img src="{{ asset('storage/' . $schema->image) }}" width="100" height="100">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Хадгалах</button>
        </form>
    </div>
@endsection
