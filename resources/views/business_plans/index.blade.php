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
            @if ($businessPlans->isEmpty())
                <p>Мэдээлэл хоосон байна.</p>
            @else
                <table class="table border mb-0" style="font-size: 12px;">
                    <thead class="fw-semibold">
                        <tr class="align-middle">
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
                            <th class="bg-body-secondary"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($businessPlans as $businessPlan)
                            <tr class="align-middle">
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
