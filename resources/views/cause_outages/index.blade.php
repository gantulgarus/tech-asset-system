@extends('layouts.app')

@section('content')

<div class="mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('cause_outages.create') }}" class="btn btn-dark mb-2">Нэмэх</a>
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
            @foreach ($causeOutages as $causeOutage)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $causeOutage->name }}</td>
                    <td>{{ $causeOutage->description }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('cause_outages.edit', $causeOutage) }}">Засах</a>
                        <div class="d-inline-flex">
                            <form action="{{ route('cause_outages.destroy', $causeOutage) }}" method="Post">
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