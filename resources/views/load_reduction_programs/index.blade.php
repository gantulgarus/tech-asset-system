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
            </div>
            <div class="card-body">
                <a href="{{ route('load-reduction-programs.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
                <a href="{{ route('load-reduction-programs.export', request()->all()) }}"
                    class="btn btn-success btn-sm mb-2 text-white">
                    Excel Экспорт
                </a>
                <button type="button" class="btn btn-secondary btn-sm mb-2" id="reset-filters"><i
                    class="fas fa-undo-alt"></i> Цэвэрлэх</button>
                <form action="{{ route('load-reduction-programs.index') }}" method="GET" id="filter-form">
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
                            <tr class="align-middle">
                                <th></th>
                                <th class="text-center">
                                    <select name="branch_id" class="form-select form-select-sm">
                                        <option></option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </th>
                                <th>
                                    <input type="text" name="client_name" class="form-control form-control-sm" value="{{ request('client_name') }}">
                                </th>
                                <th>
                                    <input type="text" name="station_name" class="form-control form-control-sm" value="{{ request('station_name') }}">
                                </th>
                                <th>
                                    <input type="text" name="output_name" class="form-control form-control-sm" value="{{ request('output_name') }}">
                                </th>
                                <th></th>
                                <th></th>
                                <th>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ request('date') }}">
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <input type="text" name="remarks" class="form-control form-control-sm" value="{{ request('remarks') }}">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $program)
                                <tr class="align-middle">
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">{{ $program->branch?->name }}</td>
                                    <td class="text-center">{{ $program->clientOrganization?->name }}</td>
                                    <td class="text-center">{{ $program->station?->name }}</td>
                                    <td class="text-center">{{ $program->output_name }}</td>
                                    <td class="text-center">{{ $program->reduction_capacity }}</td>
                                    <td class="text-center">{{ $program->pre_reduction_capacity }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($program->reduction_time)->format('Y-m-d H:i') }}</td>
                                    <td class="text-center">{{ $program->reduced_capacity }}</td>
                                    <td class="text-center">{{ $program->post_reduction_capacity }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($program->restoration_time)->format('Y-m-d H:i') }}</td>
                                    <td class="text-center">{{ $program->energy_not_supplied }}</td>
                                    <td class="text-center">{{ $program->remarks }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-transparent p-0" type="button"
                                                data-coreui-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg class="icon">
                                                    <use
                                                        xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-options') }}">
                                                    </use>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="{{ route('load-reduction-programs.edit', $program) }}">Засах</a>
                                                <form action="{{ route('load-reduction-programs.destroy', $program) }}"
                                                    method="Post">
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
                </form>
                <div class="mt-2">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('reset-filters').addEventListener('click', function() {
            window.location.href = "{{ route('load-reduction-programs.index') }}";
        });

        document.querySelectorAll('#filter-form input, #filter-form select').forEach(element => {
            element.addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });
        });
    </script>
@endsection
