@extends('layouts.admin')

@section('content')

<div class="container-fluid mt-4">
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
            <a href="{{ route('export', request()->all()) }}" class="btn btn-primary btn-sm mb-2">Экспорт</a>
            <div class="mb-2">
                <form method="GET" action="{{ route('stations.index') }}" id="filter-form">
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
                            <select name="station_type" class="form-select form-select-sm">
                                <option value="">Төрөл</option>
                                <option value="Дэд станц" {{ request('station_type') == 'Дэд станц' ? 'selected' : '' }}>Дэд станц</option>
                                <option value="Хуваарилах байгууламж" {{ request('station_type') == 'Хуваарилах байгууламж' ? 'selected' : '' }}>Хуваарилах байгууламж</option>
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
                            <select name="is_user_station" class="form-select form-select-sm">
                                <option value="">Эзэмшил</option>
                                    <option value="0" {{ request('is_user_station') === 0 ? 'selected' : '' }}>Хэрэглэгчийн</option>
                                    <option value="1" {{ request('is_user_station') === 1 ? 'selected' : '' }}>Өөрийн</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="create_year" placeholder="Ашиглалтад орсон он" class="form-control form-control-sm" value="{{ request('create_year') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Хайх</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-filters">Цэвэрлэх</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Төрөл</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станцын ША-ны нэр</th>
                        <th class="bg-body-secondary">Хүчдэлийн түвшин</th>
                        <th class="bg-body-secondary">Ашиглалтад орсон он</th>
                        <th class="bg-body-secondary">Суурилагдсан хүчин чадал /кВА/</th>
                        <th class="bg-body-secondary">Эзэмшил</th>
                        <th class="bg-body-secondary">Эх үүсвэр</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stations as $station)
                        <tr class="align-middle">
                            <td>{{ ++$i }}</td>
                            <td>{{ $station->station_type }}</td>
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
                            <td>{{ $station->is_user_station == 0 ? 'Хэрэглэгчийн' : 'Өөрийн' }}</td>
                            <td>{{ $station->desc }}</td>
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
            <div class="mt-2">
                {{ $stations->links(); }}
            </div>
        </div>
    </div>
    
</div>

<script>
    document.getElementById('reset-filters').addEventListener('click', function () {
        window.location.href = "{{ route('stations.index') }}";
    });
</script>

@endsection