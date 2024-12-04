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
                    <th class="bg-body-secondary">Захиалга эрх</th>
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
                            @if($user->can_bypass_restrictions)
                                <span class="badge bg-success">Нээлттэй</span>
                            @else
                                <span class="badge bg-danger">Хаалттай</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('users.toggle-bypass', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $user->can_bypass_restrictions ? 'btn-danger' : 'btn-success' }} text-light">
                                    {{ $user->can_bypass_restrictions ? 'Захиалга эрх хаах' : 'Захиалга эрх нээх' }}
                                </button>
                            </form>
                            <br>
                            @if (Auth::user()->role->name == 'admin')    
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm text-light">Засах</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm text-light">Устгах</button>
                            </form>
                            @endif
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
