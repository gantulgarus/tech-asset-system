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
                Тасралт
            </div>
            <div class="card-body">
                <div class="container">
                    <a href="{{ route('power_outages.create') }}" class="btn btn-dark mb-2">Нэмэх</a>
                    <form method="GET" action="{{ route('power_outages.index') }}" id="filter-form">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" name="station" class="form-control" placeholder="Дэд станц" value="{{ request('station') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="starttime" name="starttime" class="form-control" placeholder="Эхлэх" value="{{ request('starttime') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="endtime" name="endtime" class="form-control" placeholder="Дуусах" value="{{ request('endtime') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="volt_id" class="form-control">
                                    <option value="">Хүчдлийн түвшин</option>
                                    @foreach($volts as $volt)
                                        <option value="{{ $volt->id }}" {{ request('volt_id') == $volt->id ? 'selected' : '' }}>{{ $volt->name }}кВ</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Хайх</button>
                                <button type="button" class="btn btn-secondary" id="reset-filters">Цэвэрлэх</button>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2">
                        <table class="table table-bordered table-striped table-hover table-sm" style="font-size: 12px;">
                            <thead class="table-dark">
                                <tr>
                                    <th>№</th>
                                    <th>Дэд станц</th>
                                    <th>Тоноглол</th>
                                    <th>Хамгаалалт</th>
                                    <th>Тасарсан</th>
                                    <th>Залгасан</th>
                                    <th>Нийт хугацаа</th>
                                    <th>Цаг агаар</th>
                                    <th>Тасралтын шалгтаан</th>
                                    <th>U кВ</th>
                                    <th>I/P кВт</th>
                                    <th>Cosf</th>
                                    <th>ДТЦЭХ кВт.ц</th>
                                    <th>Бүртгэсэн</th>
                                    <th>Үйлдэл</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($powerOutages as $powerOutage)
                                    <tr>
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
                                            <a class="btn btn-sm" href="{{ route('power_outages.edit', $powerOutage) }}">
                                                <i class="fas fa-pen" style="color: #000000;"></i>
                                            </a>
                                            <form action="{{ route('power_outages.destroy', $powerOutage) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $powerOutages->links() }}
                        </div>
                    </div>
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
