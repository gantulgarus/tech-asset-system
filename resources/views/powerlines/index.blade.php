@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">ЦДАШ-ын мэдээлэл</div>
        <div class="card-body">
            <a href="{{ route('powerlines.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">№</th>
                        <th class="bg-body-secondary">Дэд станц</th>
                        <th class="bg-body-secondary">Шугамын ША-ны нэр</th>
                        <th class="bg-body-secondary">Хүчдлийн түвшин /кВ/</th>
                        <th class="bg-body-secondary">Ашиглалтад орсон он</th>
                        <th class="bg-body-secondary">Утасны марк</th>
                        <th class="bg-body-secondary">Тулгуурын марк</th>
                        <th class="bg-body-secondary">Тулгуурын тоо</th>
                        <th class="bg-body-secondary">Шугамын урт /км/</th>
                        <th class="bg-body-secondary">Изоляторын маяг</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($powerlines as $powerline)
                        <tr class="align-middle">
                            <td>{{ ++$i }}</td>
                            <td>{{ $powerline->station->name }}</td>
                            <td>{{ $powerline->name }}</td>
                            <td>{{ $powerline->volt->name }}</td>
                            <td>{{ $powerline->create_year }}</td>
                            <td>{{ $powerline->line_mark }}</td>
                            <td>{{ $powerline->tower_mark }}</td>
                            <td>{{ $powerline->tower_count }}</td>
                            <td>{{ $powerline->line_length }}</td>
                            <td>{{ $powerline->isolation_mark }}</td>
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
                                        <a class="dropdown-item" href="{{ route('powerlines.show', $powerline) }}">Харах</a>
                                        <a class="dropdown-item" href="{{ route('powerlines.edit', $powerline) }}">Засах</a>
                                        <form action="{{ route('powerlines.destroy', $powerline) }}" method="Post">
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
                {{ $powerlines->links(); }}
            </div>
        </div>
    </div>
</div>
@endsection
