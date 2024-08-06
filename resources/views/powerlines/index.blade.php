@extends('layouts.app')

@section('content')

<div class="mt-4">
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">ЦДАШ-ын мэдээлэл</div>
        <div class="card-body">
            <a href="{{ route('powerlines.create') }}" class="btn btn-primary btn-sm mb-2">Нэмэх</a>
            <table class="table table-bordered table-sm" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Дэд станц</th>
                        <th>Шугамын ША-ны нэр</th>
                        <th>Хүчдлийн түвшин /кВ/</th>
                        <th>Ашиглалтад орсон он</th>
                        <th>Утасны марк</th>
                        <th>Тулгуурын марк</th>
                        <th>Тулгуурын тоо</th>
                        <th>Шугамын урт /км/</th>
                        <th>Изоляторын маяг</th>
                        <th>Үйлдэл</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($powerlines as $powerline)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                                <a class="btn btn-info btn-sm text-white" href="{{ route('powerlines.show', $powerline) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary btn-sm" href="{{ route('powerlines.edit', $powerline) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="d-inline-flex">
                                    <form action="{{ route('powerlines.destroy', $powerline) }}" method="Post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
