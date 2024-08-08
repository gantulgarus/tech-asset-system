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
            Дэд станц
        </div>
        <div class="card-body">
            <a href="{{ route('stations.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">№</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станцын ША-ны нэр</th>
                        <th class="bg-body-secondary">Хүчдлийн түвшин</th>
                        <th class="bg-body-secondary">Ашиглалтад орсон он</th>
                        <th class="bg-body-secondary">Суурилагдсан хүчин чадал /кВА/</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stations as $station)
                        <tr class="align-middle">
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
                                        <a class="dropdown-item" href="{{ route('stations.show', $station) }}">Харах</a>
                                        <a class="dropdown-item" href="{{ route('stations.edit', $station) }}">Засах</a>
                                        <form action="{{ route('stations.destroy', $station) }}" method="Post">
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