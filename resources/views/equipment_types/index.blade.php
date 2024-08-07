@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('equipment-types.create') }}" class="btn btn-dark mb-2">Нэмэх</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 50px;">№</th>
                <th>Нэр</th>
                <th>Тайлбар</th>
                <th width="280px">Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipmentTypes as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->description }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('equipment-types.edit', $type->id) }}">Засах</a>
                        <div class="d-inline-flex">
                            <form action="{{ route('equipment-types.destroy', $type->id) }}" method="Post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger text-white">Устгах</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection