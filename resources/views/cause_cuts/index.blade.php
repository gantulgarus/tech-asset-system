@extends('layouts.app')

@section('content')

<div class="mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('cause_cuts.create') }}" class="btn btn-dark mb-2">Нэмэх</a>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th style="width: 50px;">№</th>
                <th>Нэр</th>
                <th>Тайлбар</th>
                <th width="280px">Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($causeCuts as $causeCut)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $causeCut->name }}</td>
                    <td>{{ $causeCut->description }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('cause_cuts.edit', $causeCut) }}">Засах</a>
                        <div class="d-inline-flex">
                            <form action="{{ route('cause_cuts.destroy', $causeCut) }}" method="Post">
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