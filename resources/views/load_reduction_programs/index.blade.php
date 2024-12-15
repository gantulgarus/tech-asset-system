@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">ААН-үүдийг ачаалал хөнгөлөх хөтөлбөр
            <form action="{{ route('load-reduction-programs.index') }}" method="GET" class="float-end">
                <div class="input-group">
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                    <button type="submit" class="btn btn-dark">Харах</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <a href="{{ route('load-reduction-programs.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Хэрэглэгчийн ААН-ийн нэр</th>
                        <th class="bg-body-secondary">Дэд станц</th>
                        <th class="bg-body-secondary">Гаргалгааны нэр</th>
                        <th class="bg-body-secondary">2024-2025 хэрэглээг бууруулах чадал, МВт (17-21 цагт)</th>
                        <th class="bg-body-secondary">Ачаалал хөнгөлөхийн өмнөх чадал, (МВт)</th>
                        <th class="bg-body-secondary">Ачаалал хөнгөлсөн цаг</th>
                        <th class="bg-body-secondary">Хөнгөлсөн чадал, (МВт)</th>
                        <th class="bg-body-secondary">Ачаалал хөнгөлсний дараах чадал, (МВт)</th>
                        <th class="bg-body-secondary">Ачаалал авсан цаг</th>
                        <th class="bg-body-secondary">Дутуу түгээсэн ЦЭХ (кВт.ц)</th>
                        <th class="bg-body-secondary">Тайлбар</th>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programs as $index => $program)
                    <tr class="align-middle">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $program->branch?->name }}</td>
                        <td class="text-center">{{ $program->company_name }}</td>
                        <td class="text-center">{{ $program->station?->name }}</td>
                        <td class="text-center">{{ $program->output_name }}</td>
                        <td class="text-center">{{ $program->reduction_capacity }}</td>
                        <td class="text-center">{{ $program->pre_reduction_capacity }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($program->reduction_time)->format('H:i') }}</td>
                        <td class="text-center">{{ $program->reduced_capacity }}</td>
                        <td class="text-center">{{ $program->post_reduction_capacity }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($program->restoration_time)->format('H:i') }}</td>
                        <td class="text-center">{{ $program->energy_not_supplied }}</td>
                        <td class="text-center">{{ $program->remarks }}</td>
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
                                    <a class="dropdown-item" href="{{ route('load-reduction-programs.edit', $program) }}">Засах</a>
                                    <form action="{{ route('load-reduction-programs.destroy', $program) }}" method="Post">
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
                        <td colspan="5" class="text-center"><strong>Нийт:</strong></td>
                        <td class="text-center"><strong>{{ $total_reduction_capacity }}</strong></td>
                        <td class="text-center"><strong>{{ $total_pre_reduction_capacity }}</strong></td>
                        <td class="text-center"></td> <!-- No sum for time -->
                        <td class="text-center"><strong>{{ $total_reduced_capacity }}</strong></td>
                        <td class="text-center"><strong>{{ $total_post_reduction_capacity }}</strong></td>
                        <td class="text-center"></td> <!-- No sum for time -->
                        <td class="text-center"><strong>{{ $total_energy_not_supplied }}</strong></td>
                        <td class="text-center"></td> <!-- No sum for remarks -->
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
