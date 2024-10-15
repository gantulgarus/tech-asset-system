@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Зөрчил бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('protection-zone-violations.update', $violation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="province_id" class="form-label">Аймаг</label>
                                <div class="form-group mb-3">
                                    <select id="province-dropdown" name="province_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id', $violation->province_id) == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('province_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sum_id" class="form-label">Сум</label>
                                <div class="form-group mb-3">
                                    <select id="sum-dropdown" name="sum_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($sums as $sum)
                                            <option value="{{ $sum->id }}" {{ old('sum_id', $violation->sum_id) == $sum->id ? 'selected' : '' }}>
                                                {{ $sum->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('sum_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="station_id" class="form-label">Дэд станц</label>
                                <div class="form-group mb-3">
                                    <select id="station-dropdown" name="station_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('station_id', $violation->station_id) == $station->id ? 'selected' : '' }}>
                                                {{ $station->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('station_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="output_name" class="form-label">Гаргалгааны нэр, тулгуурын дугаар</label>
                                <input type="text" name="output_name" class="form-control" value="{{ $violation->output_name }}">
                                @error('output_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Хэрэглэгчийн нэр</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ $violation->customer_name }}">
                                @error('customer_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Хаяг, байршил</label>
                                <input type="text" name="address" class="form-control" value="{{ $violation->address }}">
                                @error('address')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="certificate_number" class="form-label">Газрын гэрчилгээний дугаар</label>
                                <input type="text" name="certificate_number" class="form-control" value="{{ $violation->certificate_number }}">
                                @error('certificate_number')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="action_taken" class="form-label">Авсан арга хэмжээ</label>
                                <input type="text" name="action_taken" class="form-control" value="{{ $violation->action_taken }}">
                                @error('action_taken')
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
            $('#station-dropdown').select2();
            $('#province-dropdown').select2();
            $('#sum-dropdown').select2();
        });
    </script>
@endsection
