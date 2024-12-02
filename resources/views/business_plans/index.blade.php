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
            ИХ ЗАСВАР, ТЕХНИК ЗОХИОН  БАЙГУУЛАЛТЫН АРГА ХЭМЖЭЭ, ХӨРӨНГӨ ОРУУЛАЛТЫН АЖЛЫН ТӨЛӨВЛӨГӨӨ, ГҮЙЦЭТГЭЛ
        </div>
        <div class="card-body">
            <a href="{{ route('business-plans.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <div class="mb-2">
                <form method="GET" action="{{ route('business-plans.index') }}" id="filter-form">
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
                            <select name="plan_type" class="form-select form-select-sm">
                                    <option value="">Төрөл</option>
                                    <option value="Их засвар" {{ request('plan_type') == 'Их засвар' ? 'selected' : '' }}>Их засвар</option>
                                    <option value="ТЗБАХ" {{ request('plan_type') == 'ТЗБАХ' ? 'selected' : '' }}>ТЗБАХ</option>
                                    <option value="Хөрөнгө оруулалт" {{ request('plan_type') == 'Хөрөнгө оруулалт' ? 'selected' : '' }}>Хөрөнгө оруулалт</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="infrastructure_name" id="infrastructure_name" class="form-control form-control-sm" placeholder="Хэсэг, нэгж, дэд станц, шугамын нэр" value="{{ request('infrastructure_name') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="task_name" id="task_name" class="form-control form-control-sm" placeholder="Ажлын нэр" value="{{ request('task_name') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm">Хайх</button>
                            <button type="button" class="btn btn-secondary btn-sm" id="reset-filters">Цэвэрлэх</button>
                        </div>
                    </div>
                </form>
            </div>
            @if ($businessPlans->isEmpty())
                <p>Мэдээлэл хоосон байна.</p>
            @else
                <table class="table border mb-0" style="font-size: 12px;">
                    <thead class="fw-semibold">
                        <tr class="align-middle">
                            <th class="bg-body-secondary">Д/д</th>
                            <th class="bg-body-secondary">Төрөл</th>
                            <th class="bg-body-secondary">Салбар</th>
                            <th class="bg-body-secondary">Хэсэг, нэгж, дэд станц, шугамын нэр</th>
                            <th class="bg-body-secondary">Ажлын нэр</th>
                            <th class="bg-body-secondary">Хэмжих нэгж</th>
                            <th class="bg-body-secondary">Тоо хэмжээ</th>
                            <th class="bg-body-secondary">Төсөвт өртөг НӨАТ-гүй (сая төг) </th>
                            <th class="bg-body-secondary">Гүйцэтгэл (сая төг)</th>
                            <th class="bg-body-secondary">Хэтрэлт, хэмнэлт (сая төг)</th>
                            <th class="bg-body-secondary">Тайлбар</th>
                            <th class="bg-body-secondary">Гүйцэтгэл (%)</th>
                            <th class="bg-body-secondary">Акт</th>
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($businessPlans as $businessPlan)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $businessPlan->plan_type }}</td>
                                <td>{{ $businessPlan->branch->name }}</td>
                                <td>{{ $businessPlan->infrastructure_name }}</td>
                                <td>{{ $businessPlan->task_name }}</td>
                                <td>{{ $businessPlan->unit }}</td>
                                <td>{{ $businessPlan->quantity }}</td>
                                <td>{{ $businessPlan->budget_without_vat }}</td>
                                <td>{{ $businessPlan->performance_amount }}</td>
                                <td>{{ $businessPlan->variance_amount }}</td>
                                <td>{{ $businessPlan->desc }}</td>
                                <td>{{ $businessPlan->performance_percentage }}</td>
                                <td>
                                    @if($businessPlan->act_file_path)
                                        <a href="{{ Storage::url($businessPlan->act_file_path) }}" target="_blank">
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
                                            <a class="dropdown-item" href="{{ route('business-plans.show', $businessPlan) }}">Харах</a>
                                            <a class="dropdown-item" href="{{ route('business-plans.edit', $businessPlan) }}">Засах</a>
                                            @if(!$businessPlan->act_file_path)
                                            <a class="dropdown-item" href="{{ route('business-plans.upload', $businessPlan->id) }}">Акт оруулах</a>
                                            @endif
                                            <form action="{{ route('business-plans.destroy', $businessPlan) }}" method="Post">
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
            @endif
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