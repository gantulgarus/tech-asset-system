<!-- resources/views/schemas/create.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Шинэ хэрэглэгч бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('user_tier_research.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="province_id">Аймаг</label>
                        <select class="form-control" id="province_id" name="province_id" required>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="sum_id">Сум</label>
                        <select class="form-control" id="sum_id" name="sum_id" required>
                            @foreach ($sums as $sum)
                                <option value="{{ $sum->id }}">{{ $sum->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Нэр</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_tier">Хэрэглэгчийн зэрэг</label>
                        <select class="form-control" id="user_tier" name="user_tier" required>
                            <option value="1">1-р зэрэг</option>
                            <option value="2">2-р зэрэг</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="diesel_generator">Дизель генератор</label>
                        <input type="text" class="form-control" id="diesel_generator" name="diesel_generator">
                    </div>

                    <div class="form-group">
                        <label for="motor">Мотор</label>
                        <input type="text" class="form-control" id="motor" name="motor">
                    </div>

                    <div class="form-group">
                        <label for="backup_power">Чадал кВт</label>
                        <input type="number" class="form-control" id="backup_power" name="backup_power">
                    </div>

                    <div class="form-group">
                        <label for="backup_status">Ажилладаг эсэх</label>
                        <input type="text" class="form-control" id="backup_status" name="backup_status">
                    </div>

                    <div class="form-group">
                        <label for="contact">Холбоо барих</label>
                        <input type="text" class="form-control" id="contact" name="contact">
                    </div>

                    <div class="form-group mb-3">
                        <label for="schema">Холболтын схем</label>
                        <input type="file" class="form-control" id="schema" name="schema">
                    </div>
                    <button type="submit" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
        
    </div>
@endsection
