@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Хэрэглэгч нэмэх
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">

                        
                        <div class="col">
                            <div class="mb-3">
                                <label for="name" class="form-label">Нэр</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="email" class="form-label">Имэйл</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                @error('email')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="password" class="form-label">Нууц үг</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="name" class="form-label">Салбар</label>
                                <div class="form-group mb-3">
                                    <select  id="branch-dropdown" name="branch_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{$branch->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('branch_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="name" class="form-label">Хандах эрх</label>
                                <div class="form-group mb-3">
                                    <select  id="role-dropdown" name="role_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($roles as $role)
                                        <option value="{{$role->id}}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{$role->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="division" class="form-label">Албан тушаал</label>
                                <input type="text" name="division" class="form-control" value="{{ old('division') }}">
                                @error('division')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Утас</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary ml-3">Хадгалах</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection