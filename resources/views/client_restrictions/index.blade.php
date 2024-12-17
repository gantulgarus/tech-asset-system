@extends('layouts.admin')

@section('content')
<div class="container">


    <h1>Хязгаарлалт лавлах сан</h1>
    <a href="{{ route('client-restrictions.create') }}" class="btn btn-primary">Нэмэх</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>№</th>
                <th>Салбар</th>
                <th>Дэд станц</th>
                <th>Гаргалгааны нэр</th>
                <th>Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientRestrictions as $restriction)
                <tr>
                    <td>{{ $restriction->id }}</td>
                    <td>{{ $restriction->branch?->name }}</td>
                    <td>{{ $restriction->station?->name }}</td>
                    <td>{{ $restriction->output_name }}</td>
                    <td>
                        <a href="{{ route('client-restrictions.edit', $restriction->id) }}" class="btn btn-warning">Засах</a>
                        <form action="{{ route('client-restrictions.destroy', $restriction->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Устгах</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
