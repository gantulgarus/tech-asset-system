<!-- resources/views/schemas/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Хэрэглэгчийн мэдээлэл засварлах
            </div>
            <div class="card-body">
                <form action="{{ route('user_tier_research.update', $userTierResearch) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Use PUT for updating resources -->
                    <div class="form-group mb-3">
                        <label for="province_id">Аймаг</label>
                        <select class="form-control" id="province_id" name="province_id" required>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" {{ $userTierResearch->province_id == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sum_id">Сум</label>
                        <select class="form-control" id="sum_id" name="sum_id" required>
                            @foreach ($sums as $sum)
                                <option value="{{ $sum->id }}" {{ $userTierResearch->sum_id == $sum->id ? 'selected' : '' }}>
                                    {{ $sum->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Нэр</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $userTierResearch->username }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_tier">Хэрэглэгчийн зэрэг</label>
                        <select class="form-control" id="user_tier" name="user_tier" required>
                            <option value="1" {{ $userTierResearch->user_tier == 1 ? 'selected' : '' }}>1-р зэрэг</option>
                            <option value="2" {{ $userTierResearch->user_tier == 2 ? 'selected' : '' }}>2-р зэрэг</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="diesel_generator">Дизель генератор</label>
                        <input type="text" class="form-control" id="diesel_generator" name="diesel_generator" value="{{ $userTierResearch->diesel_generator }}">
                    </div>

                    <div class="form-group">
                        <label for="motor">Мотор</label>
                        <input type="text" class="form-control" id="motor" name="motor" value="{{ $userTierResearch->motor }}">
                    </div>

                    <div class="form-group">
                        <label for="backup_power">Чадал кВт</label>
                        <input type="number" class="form-control" id="backup_power" name="backup_power" value="{{ $userTierResearch->backup_power }}">
                    </div>

                    <div class="form-group">
                        <label for="backup_status">Ажилладаг эсэх</label>
                        <input type="text" class="form-control" id="backup_status" name="backup_status" value="{{ $userTierResearch->backup_status }}">
                    </div>

                    <div class="form-group">
                        <label for="contact">Холбоо барих</label>
                        <input type="text" class="form-control" id="contact" name="contact" value="{{ $userTierResearch->contact }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="schema">Холболтын схем</label>
                        <input type="file" class="form-control" id="schema" name="schema">
                        @if ($userTierResearch->schema)
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $userTierResearch->schema) }}" target="_blank">Хадгалагдсан файл харах</a>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
    </div>
@endsection
