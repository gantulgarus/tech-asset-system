@extends('layouts.app')

@section('content')
    <div class="mt-4">
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
                <a href="{{ route('power_failures.create') }}" class="btn btn-dark mb-2">Нэмэх</a>
                <table class="table table-bordered table-sm" style="font-size: 12px;">
                    <thead class="thead-dark">
                        <tr>
                            <th>№</th>
                            <th>Дэд станц</th>
                            <th>Тоноглол</th>
                            <th>Илрүүлсэн огноо</th>
                            <th>Илрүүлсэн хүний албан тушаал</th>
                            <th>Гэмтлийн шинж байдал</th>
                            <th>Гэмтлийн талаар мэдэгдсэн хүний албан тушаал, нэр</th>
                            <th>Гэмтэл арилгахаар авсан арга хэмжээ</th>
                            <th>Гэмтэл арилгасан хүний албан тушаал, нэр</th>
                            <th>Гэмтэл арилгасныг шалгаж, хүлээн авсан хүний албан тушаал, нэр</th>
                            <th>Үйлдэл</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($powerFailures as $powerFailure)
                            <tr>
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
                                    <a class="btn btn-primary btn-sm"
                                        href="{{ route('power_failures.edit', $powerFailure) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="d-inline-flex">
                                        <form action="{{ route('power_failures.destroy', $powerFailure) }}" method="Post">
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
