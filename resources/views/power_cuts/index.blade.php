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
                Таслалт
            </div>
            <div class="card-body">
                <a href="{{ route('power_cuts.create') }}" class="btn btn-dark mb-2">Нэмэх</a>
                <table class="table border mb-0" style="font-size: 12px;">
                    <thead class="fw-semibold text-nowrap">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">№</th>
                            <th class="bg-body-secondary">Дэд станц</th>
                            <th class="bg-body-secondary">Тоноглол</th>
                            <th class="bg-body-secondary">Таслалт шалтгаан</th>
                            <th class="bg-body-secondary">U кВ</th>
                            <th class="bg-body-secondary">I</th>
                            <th class="bg-body-secondary">P</th>
                            <th class="bg-body-secondary">Тасарсан</th>
                            <th class="bg-body-secondary">Залгасан</th>
                            <th class="bg-body-secondary">Нийт хугацаа</th>
                            <th class="bg-body-secondary">ДТЦЭХ кВт.ц</th>
                            <th class="bg-body-secondary">Шийдвэр өгсөн</th>
                            <th class="bg-body-secondary">Бүртгэсэн</th>
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($powerCuts as $powerCut)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $powerCut->station->name }}</td>
                                <td>{{ $powerCut->equipment->name }}</td>
                                <td>{{ $powerCut->causeCut->name }}</td>
                                <td>{{ $powerCut->current_voltage }}</td>
                                <td>{{ $powerCut->current_amper }}</td>
                                <td>{{ $powerCut->current_power }}</td>
                                <td>{{ $powerCut->start_time }}</td>
                                <td>{{ $powerCut->end_time }}</td>
                                <td>{{ $powerCut->duration }}</td>
                                <td>{{ $powerCut->ude }}</td>
                                <td>{{ $powerCut->approved_by }}</td>
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
