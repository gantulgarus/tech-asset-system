@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header">
             Батлагдсан төсөв
        </div>
        <div class="card-body">
            <a href="{{ route('budget-plans.create') }}" class="btn btn-primary btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Нэр</th>
                        <th class="bg-body-secondary">Жил</th>
                        <th class="bg-body-secondary">Файл</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budgetPlans as $budgetPlan)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $budgetPlan->branch->name }}</td>
                            <td>{{ $budgetPlan->name }}</td>
                            <td>{{ $budgetPlan->year }}</td>
                            <td>
                                @if ($budgetPlan->file_path)
                                    <a href="{{ Storage::url($budgetPlan->file_path) }}" target="_blank">Харах</a>
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
                                        <a class="dropdown-item" href="{{ route('budget-plans.edit', $budgetPlan) }}">Засах</a>
                                        <form action="{{ route('budget-plans.destroy', $budgetPlan) }}" method="Post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn dropdown-item text-danger" onclick="return confirm('Are you sure?')">
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
            {{ $budgetPlans->links() }}
        </div>
    </div>
    
</div>
@endsection
