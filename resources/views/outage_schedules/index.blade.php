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
                Таслалтын график
            </div>
            <div class="card-body">
                <a href="{{ route('outage_schedules.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
                <a href="{{ route('export-outage', request()->all()) }}" class="btn btn-primary btn-sm mb-2">Экспорт</a>
                <table class="table border mb-0" style="font-size: 12px;">
                    <thead class="fw-semibold">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">Д/д</th>
                            <th class="bg-body-secondary">Салбар</th>
                            <th class="bg-body-secondary">Дэд станц, шугам, тоноглол</th>
                            <th class="bg-body-secondary">Хийх ажлын даалгавар</th>
                            <th class="bg-body-secondary">Эхлэх огноо</th>
                            <th class="bg-body-secondary">Дуусах огноо</th>
                            <th class="bg-body-secondary">Төрөл</th>
                            <th class="bg-body-secondary">Тасрах хэрэглэгчид</th>
                            <th class="bg-body-secondary">Хариуцах албан тушаалтан</th>
                            {{-- <th class="bg-body-secondary">Боловсруулсан</th>
                            <th class="bg-body-secondary">Хянасан</th>
                            <th class="bg-body-secondary">Баталсан</th> --}}
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outageSchedules as $schedule)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $schedule->branch->name }}</td>
                                <td>{{ $schedule->substation_line_equipment }}</td>
                                <td>{{ $schedule->task }}</td>
                                <td>{{ $schedule->customDateFormat . " " . $schedule->startTime }}</td>
                                <td>{{ $schedule->customDateFormat . " " . $schedule->endTime }}</td>
                                <td>{{ $schedule->type }}</td>
                                <td>{{ $schedule->affected_users }}</td>
                                <td>{{ $schedule->responsible_officer }}</td>
                                {{-- <td>{{ $schedule->created_user }}</td>
                                <td>{{ $schedule->controlled_user }}</td>
                                <td>{{ $schedule->approved_user }}</td> --}}
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
                                            <a class="dropdown-item" href="{{ route('outage_schedules.edit', $schedule) }}">Засах</a>
                                            <form action="{{ route('outage_schedules.destroy', $schedule) }}" method="Post">
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
                    {{ $outageSchedules->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
