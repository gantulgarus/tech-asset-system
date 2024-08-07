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
            <table class="table table-bordered table-sm" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th style="width: 50px;">№</th>
                        <th>Салбар</th>
                        <th>Дэд станц</th>
                        <th>Тоноглолын төрөл</th>
                        <th>Шуурхай ажиллагааны нэр</th>
                        <th>Хүчдлийн түвшин</th>
                        <th>Тип марк</th>
                        <th>Үйлдвэрлэгдсэн он</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($equipments as $equipment)
                        <tr>
                            <td>{{ $equipment->id }}</td>
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
                                <a class="btn btn-info btn-sm text-white" href="{{ route('equipment.show', $equipment) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary btn-sm" href="{{ route('equipment.edit', $equipment) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="d-inline-flex">
                                    <form action="{{ route('equipment.destroy', $equipment) }}" method="Post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white">
                                            <i class="fas fa-trash"></i>
                                        </button>
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