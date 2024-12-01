@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            1 ба 2-р зэрэглэлийн хэрэглэгчийн судалгаа
        </div>
        <div class="card-body">
            <a href="{{ route('user_tier_research.create') }}" class="btn btn-dark btn-sm mb-2">Нэмэх</a>
            <table class="table border mb-0" style="font-size: 12px;">
                <thead class="fw-semibold text-nowrap">
                    <tr class="align-middle">
                        <th class="bg-body-secondary">Д/д</th>
                        <th class="bg-body-secondary">Аймаг</th>
                        <th class="bg-body-secondary">Сум</th>
                        <th class="bg-body-secondary">Хэрэглэгчийн нэр</th>
                        <th class="bg-body-secondary">Хэрэглэгчийн зэрэглэл</th>
                        <th class="bg-body-secondary">Холболтын схем</th>
                        <th class="bg-body-secondary">Дизель генератор</th>
                        <th class="bg-body-secondary">Мотор</th>
                        <th class="bg-body-secondary">Чадал кВт</th>
                        <th class="bg-body-secondary">Ажилладаг эсэх</th>
                        <th class="bg-body-secondary">Холбоо барих</th>
                        <th class="bg-body-secondary"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userTierResearches as $user)
                        <tr class="align-middle">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->province->name }}</td>
                            <td>{{ $user->sum?->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->user_tier }}-р зэрэг</td>
                            <td>
                                <a href="{{ asset('storage/' . $user->source_con_schema) }}"
                                    data-lightbox="photos"><img class="img-fluid img-thumbnail" style="height: 50px; width: 300px; object-fit: cover;"
                                    src="{{ asset('storage/' . $user->source_con_schema) }}"></a>
                            </td>
                            <td>{{ $user->diesel_generator }}</td>
                            <td>{{ $user->motor }}</td>
                            <td>{{ $user->backup_power }}</td>
                            <td>{{ $user->backup_status }}</td>
                            <td>{{ $user->contact }}</td>
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
                                        <a class="dropdown-item" href="{{ route('user_tier_research.edit', $user) }}">Засах</a>
                                        <form action="{{ route('user_tier_research.destroy', $user) }}" method="Post">
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
        </div>
    </div>
    
</div>

@endsection