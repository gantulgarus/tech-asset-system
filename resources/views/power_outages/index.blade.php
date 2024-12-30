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
                Тасралт
            </div>
            <div class="card-body">
                <a href="{{ route('power_outages.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
                <a href="{{ route('export-power-outage', request()->all()) }}" class="btn btn-primary btn-sm mb-2">Экспорт</a>
                <button type="button" class="btn btn-secondary btn-sm mb-2" id="reset-filters"><i
                    class="fas fa-undo-alt"></i> Цэвэрлэх</button>
                {{-- <div class="mb-2">
                    <form method="GET" action="{{ route('power_outages.index') }}" id="filter-form">
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
                                <input type="text" name="station" class="form-control form-control-sm" placeholder="Дэд станц / ХБ" value="{{ request('station') }}">
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
                </div> --}}
                <form method="GET" action="{{ route('power_outages.index') }}" id="filter-form">
                <table class="table table-bordered table-hover" style="font-size: 12px;">
                    <thead class="fw-semibold">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">Д/д</th>
                            <th class="bg-body-secondary">Салбар</th>
                            <th class="bg-body-secondary">Дэд станц / ХБ</th>
                            <th class="bg-body-secondary">Тоноглол</th>
                            <th class="bg-body-secondary">Хамгаалалт</th>
                            <th class="bg-body-secondary">Тасарсан</th>
                            <th class="bg-body-secondary">Залгасан</th>
                            <th class="bg-body-secondary">Нийт хугацаа мин</th>
                            <th class="bg-body-secondary">Цаг агаар</th>
                            <th class="bg-body-secondary">Тасралтын задаргаа</th>
                            <th class="bg-body-secondary">U кВ</th>
                            <th class="bg-body-secondary">I A</th>
                            <th class="bg-body-secondary">cos ф</th>
                            <th class="bg-body-secondary">ДТЦЭХ кВт.ц</th>
                            <th class="bg-body-secondary">Гарсан гэмтэл, авсан арга хэмжээ</th>
                            <th class="bg-body-secondary">Бүртгэсэн</th>
                            <th class="bg-body-secondary">Технологийн зөрчил</th>
                            <th class="bg-body-secondary">Тасарсан хэрэглэгчийн тоо</th>
                            <th class="bg-body-secondary">Акт</th>
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
                            <th><input type="text" name="station" class="form-control form-control-sm" value="{{ request('station') }}"></th>
                            <th>
                                <input type="text" name="equipment" class="form-control form-control-sm" value="{{ request('equipment') }}">
                            </th>
                            <th>
                                <select name="protection_id" class="form-select form-select-sm">
                                    <option value=""></option>
                                    @foreach ($protections as $protection)
                                        <option value="{{ $protection->id }}"
                                            {{ request('protection_id') == $protection->id ? 'selected' : '' }}>
                                            {{ $protection->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <input type="text" name="start_time" class="form-control form-control-sm" value="{{ request('start_time') }}">
                            </th>
                            <th>
                                <input type="text" name="end_time" class="form-control form-control-sm" value="{{ request('end_time') }}">
                            </th>
                            <th></th>
                            <th>
                                <input type="text" name="weather" class="form-control form-control-sm" value="{{ request('weather') }}">
                            </th>
                            <th>
                                <select name="cause_outage_id" class="form-select form-select-sm">
                                    <option value=""></option>
                                    @foreach ($causeOutages as $cause)
                                        <option value="{{ $cause->id }}"
                                            {{ request('cause_outage_id') == $cause->id ? 'selected' : '' }}>
                                            {{ $cause->description }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>
                                <select name="volt_id" class="form-select form-select-sm">
                                    <option value="">Хүчдэлийн түвшин</option>
                                    @foreach($volts as $volt)
                                        <option value="{{ $volt->id }}" {{ request('volt_id') == $volt->id ? 'selected' : '' }}>{{ $volt->name }}кВ</option>
                                    @endforeach
                                </select>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                <input type="text" name="incident_resolution" class="form-control form-control-sm" value="{{ request('incident_resolution') }}">
                            </th>
                            <th>
                                <input type="text" name="create_user" class="form-control form-control-sm" value="{{ request('create_user') }}">
                            </th>
                            <th>
                                <select name="technological_violation" class="form-select form-select-sm">
                                    <option value=""></option>
                                    <option value="Аваар" {{ request('technological_violation') == 'Аваар' ? 'selected' : '' }}>Аваар</option>
                                    <option value="1-р зэргийн саатал" {{ request('technological_violation') == '1-р зэргийн саатал' ? 'selected' : '' }}>1-р зэргийн саатал</option>
                                    <option value="2-р зэргийн саатал" {{ request('technological_violation') == '2-р зэргийн саатал' ? 'selected' : '' }}>2-р зэргийн саатал</option>
                                </select>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($powerOutages as $powerOutage)
                            <tr class="align-middle">
                                <td>{{ ++$i }}</td>
                                <td>{{ $powerOutage->station->branch->name ?? 'N/A' }}</td>
                                <td>{{ $powerOutage->station->name }}</td>
                                <td>{{ $powerOutage->equipment->name }}</td>
                                <td>{{ $powerOutage->protection->name }}</td>
                                <td>{{ $powerOutage->start_time }}</td>
                                <td>{{ $powerOutage->end_time }}</td>
                                <td>{{ $powerOutage->duration }}</td>
                                <td>{{ $powerOutage->weather }}</td>
                                <td>{{ $powerOutage->causeOutage->description }}</td>
                                <td>{{ $powerOutage->current_voltage }}</td>
                                <td>{{ $powerOutage->current_amper }}</td>
                                <td>{{ $powerOutage->cosf }}</td>
                                <td>{{ $powerOutage->ude }}</td>
                                <td>{{ $powerOutage->incident_resolution }}</td>
                                <td>{{ $powerOutage->create_user }}</td>
                                <td>{{ $powerOutage->technological_violation }}</td>
                                <td>{{ $powerOutage->disconnected_users }}</td>
                                <td>
                                    @if($powerOutage->act_file_path)
                                        <a href="{{ Storage::url($powerOutage->act_file_path) }}" target="_blank">
                                            <i class="far fa-file-pdf fa-2x"></i>
                                        </a>
                                    @endif
                                </td>
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
                                            @if(!$powerOutage->act_file_path)
                                            <a class="dropdown-item" href="{{ route('power_outage.upload', $powerOutage->id) }}">Акт оруулах</a>
                                            @endif
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
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // $(document).ready(function() {
        //     $('#starttime').flatpickr();
        //     $('#endtime').flatpickr();

        //     $('#reset-filters').on('click', function() {
        //         // Clear all the input fields
        //         $('#filter-form').find('input[type="text"], select').val('');
        //         // Submit the form to reload without filters
        //         $('#filter-form').submit();
        //     });

        // });
        document.getElementById('reset-filters').addEventListener('click', function() {
            window.location.href = "{{ route('power_outages.index') }}";
        });

        document.querySelectorAll('#filter-form input, #filter-form select').forEach(element => {
            element.addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });
        });
    </script>
@endsection
