@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Хэрэглэгч ААН-ийн нэр</h2>
    <a href="{{ route('client-organizations.create') }}" class="btn btn-primary mb-3">Нэмэх</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Салбар</th>
                <th>Дэд станц</th>
                <th>Хэрэглэгч ААН-ийн нэр</th>
                <th>Гаргалгааны нэр</th>
                <th>Хэрэглээг бууруулах чадал</th>
                <th>Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($organizations as $organization)
                <tr>
                    <td>{{ $organization->id }}</td>
                    <td>{{ $organization->branch?->name }}</td>
                    <td>{{ $organization->station?->name }}</td>
                    <td>{{ $organization->name }}</td>
                    <td>{{ $organization->output_name }}</td>
                    <td>{{ $organization->reduction_capacity }}</td>
                    <td>
                        <a href="{{ route('client-organizations.edit', $organization->id) }}" class="btn btn-warning btn-sm">Засах</a>
                        <form action="{{ route('client-organizations.destroy', $organization->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Устгах</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
