@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">ЦДАШ-ын мэдээлэл</div>
        <div class="card-body">
            <a href="{{ route('powerlines.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <button type="button" class="btn btn-secondary btn-sm mb-2" id="reset-filters"><i
                class="fas fa-undo-alt"></i> Цэвэрлэх</button>
            <form method="GET" action="{{ route('powerlines.index') }}" id="filter-form">
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станц</th>
                        <th class="bg-body-secondary">Шугамын ША-ны нэр</th>
                        <th class="bg-body-secondary">Хүчдэлийн түвшин /кВ/</th>
                        <th class="bg-body-secondary">Ашиглалтад орсон он</th>
                        <th class="bg-body-secondary">Утасны марк</th>
                        <th class="bg-body-secondary">Тулгуурын марк</th>
                        <th class="bg-body-secondary">Тулгуурын тоо</th>
                        <th class="bg-body-secondary">Шугамын урт /км/</th>
                        <th class="bg-body-secondary">Изоляторын маяг</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
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
                                <option></option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ request('station_id') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <input type="text" name="powerline" class="form-control form-control-sm" placeholder="Шугамын нэр" value="{{ request('powerline') }}">
                        </th>
                        <th>
                            <select name="volt_id" class="form-select form-select-sm">
                                <option></option>
                                @foreach($volts as $volt)
                                    <option value="{{ $volt->id }}" {{ request('volt_id') == $volt->id ? 'selected' : '' }}>{{ $volt->name }}кВ</option>
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <input type="text" id="create_year" name="create_year" class="form-control form-control-sm" value="{{ request('create_year') }}">
                            
                        </th>
                        
                        <th>
                            <input type="text" id="line_mark" name="line_mark" class="form-control form-control-sm" value="{{ request('line_mark') }}">
                        </th>
                        <th>
                            <input type="text" id="tower_mark" name="tower_mark" class="form-control form-control-sm" value="{{ request('tower_mark') }}">
                        </th>
                        <th></th>
                        <th></th>
                        <th>
                            <input type="text" id="isolation_mark" name="isolation_mark" class="form-control form-control-sm" value="{{ request('isolation_mark') }}">
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($powerlines as $powerline)
                        <tr class="align-middle">
                            <td>{{ ++$i }}</td>
                            <td>{{ $powerline->station->branch->name ?? 'N/A' }}</td>
                            <td>{{ $powerline->station?->name }}</td>
                            <td>{{ $powerline->name }}</td>
                            <td>{{ $powerline->volt?->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($powerline->create_year)->format('Y') }}</td>
                            <td>{{ $powerline->line_mark }}</td>
                            <td>{{ $powerline->tower_mark }}</td>
                            <td>{{ $powerline->tower_count }}</td>
                            <td>{{ $powerline->line_length }}</td>
                            <td>{{ $powerline->isolation_mark }}</td>
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
                                        <a class="dropdown-item" href="{{ route('powerlines.show', $powerline) }}">Харах</a>
                                        <a class="dropdown-item" href="{{ route('powerlines.edit', $powerline) }}">Засах</a>
                                        <form action="{{ route('powerlines.destroy', $powerline) }}" method="Post">
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
                {{ $powerlines->links(); }}
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('reset-filters').addEventListener('click', function () {
        window.location.href = "{{ route('powerlines.index') }}";
    });

    document.querySelectorAll('#filter-form input, #filter-form select').forEach(element => {
            element.addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });
        });

</script>
@endsection