@extends('layouts.admin')

@section('content')

<div class="container-fluid">
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
            <a href="{{ route('export-equipment', request()->all()) }}" class="btn btn-primary btn-sm mb-2">Экспорт</a>
            <button type="button" class="btn btn-secondary btn-sm mb-2" id="reset-filters"><i
                class="fas fa-undo-alt"></i> Цэвэрлэх</button>
            {{-- <div class="mb-2">
                <form method="GET" action="{{ route('equipment.index') }}" id="filter-form">
                    <div class="row g-2">
                        <div class="col-md-2">
                            <select name="branch_id" class="form-select form-select-sm">
                                <option value="">Салбар</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="station_id" class="form-select form-select-sm">
                                <option value="">Дэд станц / ХБ</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ request('station_id') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="equipment_type_id" class="form-select form-select-sm">
                                <option value="">Төрөл</option>
                                @foreach($equipment_types as $type)
                                    <option value="{{ $type->id }}" {{ request('equipment_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="volt_id" class="form-select form-select-sm">
                                <option value="">Хүчдэлийн түвшин</option>
                                @foreach($volts as $volt)
                                    <option value="{{ $volt->id }}" {{ request('volt_id') == $volt->id ? 'selected' : '' }}>{{ $volt->name }}кВ</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Хайх</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-filters">Цэвэрлэх</button>
                        </div>
                    </div>
                </form>
            </div> --}}
            <form method="GET" action="{{ route('equipment.index') }}" id="filter-form">
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станц</th>
                        <th class="bg-body-secondary">Тоноглолын төрөл</th>
                        <th class="bg-body-secondary">Шуурхай ажиллагааны нэр</th>
                        <th class="bg-body-secondary">Хүчдэлийн түвшин</th>
                        <th class="bg-body-secondary">Тип марк</th>
                        <th class="bg-body-secondary">Үйлдвэрлэгдсэн он</th>
                        <th class="bg-body-secondary"></th>
                    <tr class="align-middle">
                        <th></th>
                        <th>
                            <select name="branch_id" class="form-select form-select-sm">
                                <option value=""></option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select name="station_id" class="form-select form-select-sm">
                                <option value=""></option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ request('station_id') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <select name="equipment_type_id" class="form-select form-select-sm">
                                <option value=""></option>
                                @foreach($equipment_types as $type)
                                    <option value="{{ $type->id }}" {{ request('equipment_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder=""
                                        value="{{ request('name') }}">
                        </th>
                        <th>
                            <select name="volt_id" class="form-select form-select-sm">
                                <option value=""></option>
                                @foreach($volts as $volt)
                                    <option value="{{ $volt->id }}" {{ request('volt_id') == $volt->id ? 'selected' : '' }}>{{ $volt->name }}кВ</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <input type="text" name="mark" class="form-control form-control-sm" placeholder=""
                                        value="{{ request('mark') }}">
                        </th>
                        <th>
                            <input type="text" name="production_date" class="form-control form-control-sm" placeholder=""
                                        value="{{ request('production_date') }}">
                        </th>
                        <th></th>
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
                            <td>{{ \Carbon\Carbon::parse($equipment->production_date)->format('Y') }}</td>
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
            </form>
        </div>
    </div>
    
</div>

<script>
    document.getElementById('reset-filters').addEventListener('click', function () {
        window.location.href = "{{ route('equipment.index') }}";
    });

    document.querySelectorAll('#filter-form input, #filter-form select').forEach(element => {
            element.addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });
        });

</script>

@endsection