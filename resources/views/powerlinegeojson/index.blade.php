@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            ЦДАШ Трассын координат
        </div>
        <div class="card-body">
            <a href="{{ route('powerlinegeojson.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">№</th>
                        <th class="bg-body-secondary">Шугам</th>
                        <th class="bg-body-secondary">Файлын нэр</th>
                        <th class="bg-body-secondary">Зам</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($geojsonFiles as $file)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $file->powerline->name }}</td>
                            <td>{{ $file->name }}</td>
                            <td>{{ $file->path }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-transparent p-0" type="button" data-coreui-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-options') }}">
                                            </use>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('powerlinegeojson.edit', $file->id) }}">Засах</a>
                                        <form action="{{ route('powerlinegeojson.destroy', $file->id) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn dropdown-item text-danger">
                                                Устгах
                                            </button>
                                        </form>
                                    </div>
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