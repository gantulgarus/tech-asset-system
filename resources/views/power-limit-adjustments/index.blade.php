@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">2024-2025 оны өвлийн их ачааллын онцгой үеийн хөнгөлөлт, хязгаарлалтын багц-14
            <form action="{{ route('power-limit-adjustments.index') }}" method="GET" class="float-end">
                <div class="input-group">
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                    <button type="submit" class="btn btn-dark">Харах</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <a href="{{ route('power-limit-adjustments.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станц</th>
                        <th class="bg-body-secondary">Гаргалгааны нэр</th>
                        <th class="bg-body-secondary">Тасарсан цаг</th>
                        <th class="bg-body-secondary">Залгасан цаг</th>
                        <th class="bg-body-secondary">Тасарсан хугацаа, мин</th>
                        <th class="bg-body-secondary">Тасарсан хугацаа, цаг</th>
                        <th class="bg-body-secondary">Хүчдэл, кВ</th>
                        <th class="bg-body-secondary">Гүйдэл, А</th>
                        <th class="bg-body-secondary">cos ф</th>
                        <th class="bg-body-secondary">Чадал, МВт</th>
                        <th class="bg-body-secondary">Дутуу түгээсэн ЦЭХ, кВт.ц</th>
                        <th class="bg-body-secondary">Хэрэглэгчийн тоо</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                    <tr class="align-middle">
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        <th class="text-center">6</th>
                        <th class="text-center">7</th>
                        <th class="text-center">8</th>
                        <th class="text-center">9</th>
                        <th class="text-center">10</th>
                        <th class="text-center">11</th>
                        <th class="text-center">12</th>
                        <th class="text-center">13</th>
                        <th class="text-center">14</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adjustments as $index => $adjustment)
                    <tr class="align-middle">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $adjustment->branch?->name }}</td>
                        <td class="text-center">{{ $adjustment->station?->name }}</td>
                        <td class="text-center">{{ $adjustment->output_name }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($adjustment->start_time)->format('H:i') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($adjustment->end_time)->format('H:i') }}</td>
                        <td class="text-center">{{ $adjustment->duration_minutes }}</td>
                        <td class="text-center">{{ $adjustment->duration_hours }}</td>
                        <td class="text-center">{{ $adjustment->voltage }}</td>
                        <td class="text-center">{{ $adjustment->amper }}</td>
                        <td class="text-center">{{ $adjustment->cosf }}</td>
                        <td class="text-center">{{ $adjustment->power }}</td>
                        <td class="text-center">{{ $adjustment->energy_not_supplied }}</td>
                        <td class="text-center">{{ $adjustment->user_count }}</td>
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
                                    <a class="dropdown-item" href="{{ route('power-limit-adjustments.edit', $adjustment) }}">Засах</a>
                                    <form action="{{ route('power-limit-adjustments.destroy', $adjustment) }}" method="Post">
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
                <tfoot>
                    <tr class="align-middle">
                        <td colspan="6" class="text-end fw-bold">Нийт:</td>
                        <td class="text-center fw-bold">{{ $totalMinutes }}</td>
                        <td class="text-center fw-bold">{{ $totalHours }}</td>
                        <td colspan="3"></td>
                        <td class="text-center fw-bold">{{ $totalPower }}</td>
                        <td class="text-center fw-bold">{{ $totalEnergyNotSupplied }}</td>
                        <td class="text-center fw-bold">{{ $totalUserCount }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
