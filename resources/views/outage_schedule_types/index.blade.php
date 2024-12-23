@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Таслалтын графикийн төрөл</h1>
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('outage-schedule-types.create') }}" class="btn btn-primary">Нэмэх</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>№</th>
                <th>Нэр</th>
                <th>Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->name }}</td>
                    <td>
                        <a href="{{ route('outage-schedule-types.edit', $type) }}" class="btn btn-warning btn-sm">Засах</a>
                        <form action="{{ route('outage-schedule-types.destroy', $type) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Устгах</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
