@extends('layouts.admin')

@section('content')
{{-- <livewire:user-table/> --}}
<div class="container">
    <div class="card mb-4">
        <div class="card-header">
            {{ __('Хэрэглэгч') }}
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Нэр</th>
                    <th scope="col">Имэйл</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
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
