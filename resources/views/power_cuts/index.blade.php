@extends('layouts.app')

@section('content')
    <div class="mt-4">
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
                <table class="table table-bordered table-sm" style="font-size: 12px;">
                    <thead class="thead-dark">
                        <tr>
                            <th>№</th>
                            <th>Дэд станц</th>
                            <th>Тоноглол</th>
                            <th>Таслалт хийх болсон шалтгаан</th>
                            <th>U кВ</th>
                            <th>I</th>
                            <th>P</th>
                            <th>Тасарсан</th>
                            <th>Залгасан</th>
                            <th>Нийт хугацаа</th>
                            <th>ДТЦЭХ кВт.ц</th>
                            <th>Шийдвэр өгсөн</th>
                            <th>Бүртгэсэн</th>
                            <th>Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($powerCuts as $powerCut)
                            <tr>
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
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('power_cuts.edit', $powerCut) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="d-inline-flex">
                                        <form action="{{ route('power_cuts.destroy', $powerCut) }}" method="Post">
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
