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
            Дэд станц
        </div>
        <div class="card-body">
            <a href="{{ route('stations.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <a href="{{ route('export', request()->all()) }}" class="btn btn-primary btn-sm mb-2"><i class="far fa-file-excel"></i> Экспорт</a>
            <button type="button" class="btn btn-secondary btn-sm mb-2" id="reset-filters"><i class="fas fa-undo-alt"></i> Цэвэрлэх</button>
            {{-- <div class="mb-2">
                <form method="GET" action="{{ route('stations.index') }}" id="filter-form">
                    <div class="row g-2">
                        <div class="col-md-1">
                            <select name="station_type" class="form-select form-select-sm">
                                <option value="">Төрөл</option>
                                <option value="Дэд станц" {{ request('station_type') == 'Дэд станц' ? 'selected' : '' }}>Дэд станц</option>
                                <option value="Хуваарилах байгууламж" {{ request('station_type') == 'Хуваарилах байгууламж' ? 'selected' : '' }}>Хуваарилах байгууламж</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select name="branch_id" class="form-select form-select-sm">
                                <option value="">Салбар</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <input type="text" name="name" placeholder="ДС нэр" class="form-control form-control-sm" value="{{ request('name') }}">
                        </div>
                        <div class="col-md-1">
                            <select name="volt_id" class="form-select form-select-sm">
                                <option value="">Хүчдэлийн түвшин</option>
                                @foreach($volts as $volt)
                                    <option value="{{ $volt->id }}" {{ request('volt_id') == $volt->id ? 'selected' : '' }}>{{ $volt->name }}кВ</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="create_year" placeholder="Ашиглалтад орсон он" class="form-control form-control-sm" value="{{ request('create_year') }}">
                        </div>
                        <div class="col-md-1">
                            <input type="text" name="installed_capacity" placeholder="Суурилагдсан чадал" class="form-control form-control-sm" value="{{ request('installed_capacity') }}">
                        </div>
                        
                        <div class="col-md-1">
                            <select name="is_user_station" class="form-select form-select-sm">
                                <option value="">Эзэмшил</option>
                                    <option value="0" {{ request('is_user_station') === 0 ? 'selected' : '' }}>Хэрэглэгчийн</option>
                                    <option value="1" {{ request('is_user_station') === 1 ? 'selected' : '' }}>Өөрийн</option>
                            </select>
                        </div>

                        <div class="col-md-1">
                            <input type="text" name="desc" placeholder="Эх үүсвэр" class="form-control form-control-sm" value="{{ request('desc') }}">
                        </div>

                        <div class="col-md-1">
                            <select name="station_category" class="form-select form-select-sm">
                                <option value="">Харьяалал</option>
                                    <option value="Түгээх" {{ request('station_category') === 'Түгээх' ? 'selected' : '' }}>Түгээх</option>
                                    <option value="Дамжуулах" {{ request('station_category') === 'Дамжуулах' ? 'selected' : '' }}>Дамжуулах</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Хайх</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-filters">Цэвэрлэх</button>
                        </div>
                    </div>
                </form>
            </div> --}}
            <form method="GET" action="{{ route('stations.index') }}" id="filter-form">
            <table class="table table-bordered table-hover" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Төрөл</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станцын ША-ны нэр</th>
                        <th class="bg-body-secondary">Хүчдэлийн түвшин</th>
                        <th class="bg-body-secondary">Ашиглалтад орсон он</th>
                        <th class="bg-body-secondary">Суурилагдсан хүчин чадал Т-1 /кВА/</th>
                        <th class="bg-body-secondary">Суурилагдсан хүчин чадал Т-2 /кВА/</th>
                        <th class="bg-body-secondary">Эзэмшил</th>
                        <th class="bg-body-secondary">Эх үүсвэр</th>
                        <th class="bg-body-secondary">Эх үүсвэрийн харьяалал</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                    <tr class="align-middle">
                        <th class=""></th>
                        <th class="">
                            <select name="station_type" class="form-select form-select-sm">
                                <option value=""></option>
                                <option value="Дэд станц" {{ request('station_type') == 'Дэд станц' ? 'selected' : '' }}>Дэд станц</option>
                                <option value="Хуваарилах байгууламж" {{ request('station_type') == 'Хуваарилах байгууламж' ? 'selected' : '' }}>Хуваарилах байгууламж</option>
                            </select>
                        </th>
                        <th class="">
                            <select name="branch_id" class="form-select form-select-sm">
                                <option value=""></option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th class="">
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="" value="{{ request('name') }}">
                        </th>
                        <th class="">
                            <select name="volt_id" class="form-select form-select-sm">
                                <option value=""></option>
                                @foreach($volts as $volt)
                                    <option value="{{ $volt->id }}" {{ request('volt_id') == $volt->id ? 'selected' : '' }}>{{ $volt->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th class="">
                            <input type="number" name="create_year" class="form-control form-control-sm" placeholder="" value="{{ request('create_year') }}">
                        </th>
                        <th class="">
                            <input type="text" name="installed_capacity" class="form-control form-control-sm" placeholder="" value="{{ request('installed_capacity') }}">
                        </th>
                        <th class="">
                            <input type="text" name="second_capacity" class="form-control form-control-sm" placeholder="" value="{{ request('second_capacity') }}">
                        </th>
                        <th class="">
                            <select name="is_user_station" class="form-select form-select-sm">
                                <option value=""></option>
                                <option value="0" {{ request('is_user_station') == "0" ? 'selected' : '' }}>Хэрэглэгчийн</option>
                                <option value="1" {{ request('is_user_station') == "1" ? 'selected' : '' }}>Өөрийн</option>
                            </select>
                        </th>
                        <th class="">
                            <input type="text" name="desc" class="form-control form-control-sm" placeholder="" value="{{ request('desc') }}">
                        </th>
                        <th class="">
                            <select name="station_category" class="form-select form-select-sm">
                                <option value=""></option>
                                <option value="Түгээх" {{ request('station_category') == 'Түгээх' ? 'selected' : '' }}>Түгээх</option>
                                <option value="Дамжуулах" {{ request('station_category') == 'Дамжуулах' ? 'selected' : '' }}>Дамжуулах</option>
                            </select>
                        </th>
                        <th class=""></th>
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
                            <td>{{ $station->second_capacity }}</td>
                            <td>{{ $station->is_user_station == 0 ? 'Хэрэглэгчийн' : 'Өөрийн' }}</td>
                            <td>{{ $station->desc }}</td>
                            <td>{{ $station->station_category }}</td>
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
            <div class="mt-3">
                <p>Нийт мэдээлэл: {{ $stations->count() }}</p>
            </div>
        </form>
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

    document.querySelectorAll('#filter-form input, #filter-form select').forEach(element => {
        element.addEventListener('change', function () {
            document.getElementById('filter-form').submit();
        });
    });

</script>

@endsection