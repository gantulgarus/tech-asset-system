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
                Тасралт
            </div>
            <div class="card-body">
                <a href="{{ route('power_outages.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
                <div class="mb-2">
                    <form method="GET" action="{{ route('power_outages.index') }}" id="filter-form">
                        <div class="row">
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
                                <select name="volt_id" class="form-control form-control-sm">
                                    <option value="">Хүчдлийн түвшин</option>
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
                <table class="table border mb-0" style="font-size: 12px;">
                    <thead class="fw-semibold text-nowrap">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">№</th>
                            <th class="bg-body-secondary">Дэд станц</th>
                            <th class="bg-body-secondary">Тоноглол</th>
                            <th class="bg-body-secondary">Хамгаалалт</th>
                            <th class="bg-body-secondary">Тасарсан</th>
                            <th class="bg-body-secondary">Залгасан</th>
                            <th class="bg-body-secondary">Нийт хугацаа</th>
                            <th class="bg-body-secondary">Цаг агаар</th>
                            <th class="bg-body-secondary">Тасралтын шалгтаан</th>
                            <th class="bg-body-secondary">U кВ</th>
                            <th class="bg-body-secondary">I/P кВт</th>
                            <th class="bg-body-secondary">Cosf</th>
                            <th class="bg-body-secondary">ДТЦЭХ кВт.ц</th>
                            <th class="bg-body-secondary">Бүртгэсэн</th>
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($powerOutages as $powerOutage)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $powerOutage->station->name }}</td>
                                <td>{{ $powerOutage->equipment->name }}</td>
                                <td>{{ $powerOutage->protection->name }}</td>
                                <td>{{ $powerOutage->start_time }}</td>
                                <td>{{ $powerOutage->end_time }}</td>
                                <td>{{ $powerOutage->duration }}</td>
                                <td>{{ $powerOutage->weather }}</td>
                                <td>{{ $powerOutage->causeOutage->name }}</td>
                                <td>{{ $powerOutage->current_voltage }}</td>
                                <td>{{ $powerOutage->current_amper }}</td>
                                <td>{{ $powerOutage->cosf }}</td>
                                <td>{{ $powerOutage->ude }}</td>
                                <td>{{ $powerOutage->user->name }}</td>
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
                                            <a class="dropdown-item" href="{{ route('power_outages.edit', $powerOutage) }}">Засах</a>
                                            <form action="{{ route('power_outages.destroy', $powerOutage) }}" method="Post">
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
                    {{ $powerOutages->links() }}
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
