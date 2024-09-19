@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('stations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Нэр</label>
                                <input type="text" name="name" class="form-control">
                                @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Салбар</label>
                                <div class="form-group mb-3">
                                    <select  id="country-dropdown" name="branch_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}">
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Хүчдлийн түвшин</label>
                                <div class="form-group mb-3">
                                    <select name="volt_ids[]" id="volt_ids" class="form-control" multiple>
                                        @foreach ($volts as $volt)
                                            <option value="{{ $volt->id }}" {{ collect(old('volt_ids'))->contains($volt->id) ? 'selected' : '' }}>
                                                {{ $volt->name }}кВ
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('volt_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="installed_capacity" class="form-label">Суурилагдсан чадал /кВА/</label>
                                <input type="text" name="installed_capacity" class="form-control">
                                @error('installed_capacity')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_year" class="form-label">Ашиглалтад орсон он</label>
                                <input type="number" name="create_year" class="form-control">
                                @error('create_year')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="desc" class="form-label">Тайлбар</label>
                                <input type="text" name="desc" class="form-control">
                                @error('desc')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_user_station" class="form-label">Хэрэглэгчийн дэд станц мөн эсэх</label>
                                <select name="is_user_station" class="form-control">
                                    <option value="0">Үгүй</option>
                                    <option value="1">Тийм</option>
                                </select>
                                @error('is_user_station')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary ml-3">Хадгалах</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#volt_ids').select2({
                placeholder: "-- Сонгох --",
                allowClear: true
            });
        });
    </script>
@endsection