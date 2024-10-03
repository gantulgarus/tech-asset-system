@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('volts.create') }}" class="btn btn-dark mb-2">Нэмэх</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 50px;">№</th>
                <th>Нэр</th>
                <th>Эрэмбэ</th>
                <th width="280px">Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($volts as $volt)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $volt->name }}кВ</td>
                    <td>{{ $volt->order }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('volts.edit', $volt->id) }}">Засах</a>
                        <div class="d-inline-flex">
                            <form action="{{ route('volts.destroy', $volt) }}" method="Post">
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