<!-- resources/views/schemas/create.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Шинэ схем бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('schemas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Нэр</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="station_id">Дэд атснц</label>
                        <select class="form-control" id="station_id" name="station_id" required>
                            @foreach ($stations as $station)
                                <option value="{{ $station->id }}">{{ $station->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Зураг</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
        
    </div>
@endsection
