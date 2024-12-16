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
                Таслалт
            </div>
            <div class="card-body">
                <a href="{{ route('power_cuts.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
                <a href="{{ route('export-power-cut', request()->all()) }}" class="btn btn-primary btn-sm mb-2">Экспорт</a>
                <div class="mb-2">
                    <form method="GET" action="{{ route('power_cuts.index') }}" id="filter-form">
                        <div class="row g-2">
                            <div class="col-md-2">
                                <select name="branch_id" class="form-select form-select-sm">
                                    <option value="">Салбар</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="station" class="form-control form-control-sm" placeholder="Дэд станц" value="{{ request('station') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="starttime" name="starttime" class="form-control form-control-sm" placeholder="Эхлэх" value="{{ request('starttime') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="endtime" name="endtime" class="form-control form-control-sm" placeholder="Дуусах" value="{{ request('endtime') }}">
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
                </div>
                <table class="table table-bordered table-hover" style="font-size: 12px;">
                    <thead class="fw-semibold">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">Д/д</th>
                            <th class="bg-body-secondary">Дэд станц</th>
                            <th class="bg-body-secondary">Тоноглол</th>
                            <th class="bg-body-secondary">Захиалгын төрөл</th>
                            <th class="bg-body-secondary">Таслалт шалтгаан</th>
                            <th class="bg-body-secondary">U кВ</th>
                            <th class="bg-body-secondary">I</th>
                            <th class="bg-body-secondary">P</th>
                            <th class="bg-body-secondary">Тасарсан</th>
                            <th class="bg-body-secondary">Залгасан</th>
                            <th class="bg-body-secondary">Нийт хугацаа</th>
                            <th class="bg-body-secondary">ДТЦЭХ кВт.ц</th>
                            <th class="bg-body-secondary">Шийдвэр өгсөн</th>
                            <th class="bg-body-secondary">Захиалгын дугаар</th>
                            <th class="bg-body-secondary">Бүртгэсэн</th>
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($powerCuts as $powerCut)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $powerCut->station?->name }}</td>
                                <td>{{ $powerCut->equipment?->name }}</td>
                                <td>{{ $powerCut->orderType?->name }}</td>
                                <td>{{ $powerCut->cause_cut }}</td>
                                <td>{{ $powerCut->current_voltage }}</td>
                                <td>{{ $powerCut->current_amper }}</td>
                                <td>{{ $powerCut->current_power }}</td>
                                <td>{{ $powerCut->start_time }}</td>
                                <td>{{ $powerCut->end_time }}</td>
                                <td>{{ $powerCut->duration }}</td>
                                <td>{{ $powerCut->ude }}</td>
                                <td>{{ $powerCut->approved_by }}</td>
                                <td>{{ $powerCut->order_number }}</td>
                                <td>{{ $powerCut->created_by }}</td>
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
                                            <a class="dropdown-item" href="{{ route('power_cuts.edit', $powerCut) }}">Засах</a>
                                            <form action="{{ route('power_cuts.destroy', $powerCut) }}" method="Post">
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
                    {{ $powerCuts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#starttime').flatpickr();
            $('#endtime').flatpickr();

            $('#reset-filters').on('click', function() {
                // Clear all the input fields
                $('#filter-form').find('input[type="text"], select').val('');
                // Submit the form to reload without filters
                $('#filter-form').submit();
            });

        });
    </script>
@endsection