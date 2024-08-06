<!-- resources/views/schemas/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            Схемийн мэдээлэл
        </div>
        <div class="card-body">
            <a href="{{ route('schemas.create') }}" class="btn btn-primary mb-2">Нэмэх</a>
        <table class="table table-bordered table-sm" style="font-size: 12px;">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Дэд станц</th>
                    <th>Нэр</th>
                    <th>Зураг</th>
                    <th>Үйлдэл</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schemas as $schema)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $schema->station->name }}</td>
                        <td>{{ $schema->name }}</td>
                        <td>
                            @if ($schema->image)
                                <img src="{{ asset('storage/' . $schema->image) }}" width="50" height="50">
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('schemas.edit', $schema) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <div class="d-inline-flex">
                                <form action="{{ route('schemas.destroy', $schema) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    
</div>
@endsection
