@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            Хамгаалалтын зурвас зөрчсөн хэрэглэгчийн судалгаа
        </div>
        <div class="card-body">
            <a href="{{ route('protection-zone-violations.create') }}" class="btn btn-primary btn-sm mb-2">Нэмэх</a>
            <div class="mb-2">
                <form method="GET" action="{{ route('protection-zone-violations.index') }}" id="filter-form">
                    <div class="row g-2">
                        <div class="col-md-2">
                            <select name="branch_id" class="form-select form-select-sm">
                                <option value="">Салбар</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="station_id" class="form-select form-select-sm">
                                <option value="">Дэд станц</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ request('station_id') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="province_id" class="form-select form-select-sm">
                                <option value="">Аймаг</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="sum_id" class="form-select form-select-sm">
                                <option value="">Сум</option>
                                @foreach($sums as $sum)
                                    <option value="{{ $sum->id }}" {{ request('sum_id') == $sum->id ? 'selected' : '' }}>{{ $sum->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <input type="text" name="output_name" id="output_name" class="form-control form-control-sm" placeholder="Гаргалгааны нэр, тулгуурын дугаар" value="{{ request('output_name') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Хайх</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-filters">Цэвэрлэх</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Дэд станц</th>
                        <th class="bg-body-secondary">Аймаг</th>
                        <th class="bg-body-secondary">Сум</th>
                        <th class="bg-body-secondary">Гаргалгааны нэр, тулгуурын дугаар</th>
                        <th class="bg-body-secondary">Хэрэглэгчийн нэр</th>
                        <th class="bg-body-secondary">Хаяг, байршил</th>
                        <th class="bg-body-secondary">Газрын гэрчилгээний дугаар</th>
                        <th class="bg-body-secondary">Авсан арга хэмжээ</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($violations as $violation)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $violation->branch->name }}</td>
                            <td>{{ $violation->station->name }}</td>
                            <td>{{ $violation->province->name }}</td>
                            <td>{{ $violation->sum->name }}</td>
                            <td>{{ $violation->output_name }}</td>
                            <td>{{ $violation->customer_name }}</td>
                            <td>{{ $violation->address }}</td>
                            <td>{{ $violation->certificate_number }}</td>
                            <td>{{ $violation->action_taken }}</td>
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
                                        <a class="dropdown-item" href="{{ route('protection-zone-violations.edit', $violation->id) }}">Засах</a>
                                        <form action="{{ route('protection-zone-violations.destroy', $violation->id) }}" method="Post">
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
                <div class="mt-2">
                    {{ $violations->links() }}
                </div>
            </table>
            <div class="mt-2">
                {{ $violations->links() }}
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#reset-filters').on('click', function() {
                // Clear all the input fields
                $('#filter-form').find('input[type="text"], select').val('');
                // Submit the form to reload without filters
                $('#filter-form').submit();
            });

        });
    </script>
@endsection
