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
            Дэд станц
        </div>
        <div class="card-body">
            <a href="{{ route('stations.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table table-bordered table-sm" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th style="width: 50px;">№</th>
                        <th>Салбар</th>
                        <th>Дэд станцын ША-ны нэр</th>
                        <th>Хүчдлийн түвшин</th>
                        <th>Ашиглалтад орсон он</th>
                        <th>Суурилагдсан хүчин чадал /кВА/</th>
                        <th>uuid</th>
                        <th width="200px">Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stations as $station)
                        <tr>
                            <td>{{ $station->id }}</td>
                            <td>{{ $station->branch->name }}</td>
                            <td>{{ $station->name }}</td>
                            <td>
                                @foreach ($station->volts as $volt)
                                <span>{{ $volt->name }}</span>@if (!$loop->last)/@endif
                                @endforeach
                                кВ
                            </td>
                            <td>{{ $station->create_year }}</td>
                            <td>{{ $station->installed_capacity }}</td>
                            <td>{{ $station->uuid }}</td>
                            <td>
                                <a class="btn btn-info btn-sm text-white" href="{{ route('stations.show', $station) }}"><i class="fas fa-eye"></i></a>
                                <a class="btn btn-primary btn-sm" href="{{ route('stations.edit', $station) }}"><i class="fas fa-edit"></i></a>
                                <div class="d-inline-flex">
                                    <form action="{{ route('stations.destroy', $station) }}" method="Post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash"></i></button>
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