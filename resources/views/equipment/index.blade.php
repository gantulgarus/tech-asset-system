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
            Үндсэн тоноглол
        </div>
        <div class="card-body">
            <a href="{{ route('equipment.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">№</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станц</th>
                        <th class="bg-body-secondary">Тоноглолын төрөл</th>
                        <th class="bg-body-secondary">Шуурхай ажиллагааны нэр</th>
                        <th class="bg-body-secondary">Хүчдлийн түвшин</th>
                        <th class="bg-body-secondary">Тип марк</th>
                        <th class="bg-body-secondary">Үйлдвэрлэгдсэн он</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipments as $equipment)
                        <tr class="align-middle">
                            <td>{{ ++$i }}</td>
                            <td>{{ $equipment->branch->name }}</td>
                            <td>{{ $equipment->station->name }}</td>
                            <td>{{ $equipment->equipmentType->name }}</td>
                            <td>{{ $equipment->name }}</td>
                            <td>
                                @foreach ($equipment->volts as $volt)
                                <span>{{ $volt->name }}</span>@if (!$loop->last)/@endif
                                @endforeach
                                кВ
                            </td>
                            <td>{{ $equipment->mark }}</td>
                            <td>{{ $equipment->production_date }}</td>
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
                                        <a class="dropdown-item" href="{{ route('equipment.show', $equipment) }}">Харах</a>
                                        <a class="dropdown-item" href="{{ route('equipment.edit', $equipment) }}">Засах</a>
                                        <form action="{{ route('equipment.destroy', $equipment) }}" method="Post">
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
            <div class="mt-2">
                {{ $equipments->links(); }}
            </div>
        </div>
    </div>
    
</div>

@endsection