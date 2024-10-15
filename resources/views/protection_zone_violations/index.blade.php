@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    

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
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">№</th>
                        <th class="bg-body-secondary">Салбар</th>
                        <th class="bg-body-secondary">Аймаг</th>
                        <th class="bg-body-secondary">Сум</th>
                        <th class="bg-body-secondary">Дэд станцын нэр</th>
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
                            <td>{{ $violation->province->name }}</td>
                            <td>{{ $violation->sum->name }}</td>
                            <td>{{ $violation->station->name }}</td>
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
        </div>
    </div>

</div>
@endsection
