@extends('layouts.admin')

@section('content')
{{-- <livewire:user-table/> --}}
<div class="container">
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Хэрэглэгч') }}
        </div>

        <div class="card-body">

            <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Нэмэх</a>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead class="fw-semibold text-nowrap">
                <tr class="align-middle">
                    <th class="bg-body-secondary">Д/д</th>
                    <th class="bg-body-secondary">Нэр</th>
                    <th class="bg-body-secondary">Имэйл</th>
                    <th class="bg-body-secondary">Салбар</th>
                    <th class="bg-body-secondary">Хандах эрх</th>
                    <th class="bg-body-secondary">Албан тушаал</th>
                    <th class="bg-body-secondary">Утас</th>
                    <th class="bg-body-secondary">Үйлдэл</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->branch?->name }}</td>
                        <td>{{ $user->role?->name }}</td>
                        <td>{{ $user->division }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Засах</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Устгах</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
