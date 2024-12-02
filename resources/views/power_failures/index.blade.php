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
                Гэмтэл
            </div>
            <div class="card-body">
                <a href="{{ route('power_failures.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
                <div class="mb-2">
                    <form method="GET" action="{{ route('power_failures.index') }}" id="filter-form">
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
                                <input type="text" name="station" class="form-control form-control-sm" placeholder="Дэд станц" value="{{ request('station') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="starttime" name="starttime" class="form-control form-control-sm" placeholder="Эхлэх" value="{{ request('starttime') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="endtime" name="endtime" class="form-control form-control-sm" placeholder="Дуусах" value="{{ request('endtime') }}">
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
                            <th class="bg-body-secondary">Дэд станц</th>
                            <th class="bg-body-secondary">Тоноглол</th>
                            <th class="bg-body-secondary">Илрүүлсэн огноо</th>
                            <th class="bg-body-secondary">Илрүүлсэн хүн</th>
                            <th class="bg-body-secondary">Гэмтлийн шинж байдал</th>
                            <th class="bg-body-secondary">Гэмтлийн талаар мэдэгдсэн хүн</th>
                            <th class="bg-body-secondary">Авсан арга хэмжээ</th>
                            <th class="bg-body-secondary">Гэмтэл арилгасан хүн</th>
                            <th class="bg-body-secondary">Хүлээн авсан хүн</th>
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($powerFailures as $powerFailure)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $powerFailure->station->name }}</td>
                                <td>{{ $powerFailure->equipment->name }}</td>
                                <td>{{ $powerFailure->failure_date }}</td>
                                <td>{{ $powerFailure->detector_name }}</td>
                                <td>{{ $powerFailure->failure_detail }}</td>
                                <td>{{ $powerFailure->notified_name }}</td>
                                <td>{{ $powerFailure->action_taken }}</td>
                                <td>{{ $powerFailure->fixer_name }}</td>
                                <td>{{ $powerFailure->inspector_name }}</td>
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
                                            <a class="dropdown-item" href="{{ route('power_failures.edit', $powerFailure) }}">Засах</a>
                                            <form action="{{ route('power_failures.destroy', $powerFailure) }}" method="Post">
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
                    {{ $powerFailures->links() }}
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