@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Хамгаалалтын зурвас зөрчсөн хэрэглэгч бүртгэх
            </div>
            <div class="card-body">
                <form action="{{ route('protection-zone-violations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="branch_id" class="form-label">Салбар</label>
                                <div class="form-group mb-3">
                                    <select id="branch-dropdown" name="branch_id" class="form-control">
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
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
                                <label for="station_id" class="form-label">Дэд станц</label>
                                <div class="form-group mb-3">
                                    <select id="station-dropdown" name="station_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>
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
                                <label for="province_id" class="form-label">Аймаг</label>
                                <div class="form-group mb-3">
                                    <select id="province-dropdown" name="province_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
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
                                    </select>
                                </div>
                                @error('sum_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="output_name" class="form-label">Гаргалгааны нэр, тулгуурын дугаар</label>
                                <input type="text" name="output_name" class="form-control" value="{{ old('output_name') }}">
                                @error('output_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Хэрэглэгчийн нэр</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
                                @error('customer_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Хаяг, байршил</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                @error('address')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="certificate_number" class="form-label">Газрын гэрчилгээний дугаар</label>
                                <input type="text" name="certificate_number" class="form-control" value="{{ old('certificate_number') }}">
                                @error('certificate_number')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="action_taken" class="form-label">Авсан арга хэмжээ</label>
                                <input type="text" name="action_taken" class="form-control" value="{{ old('action_taken') }}">
                                @error('action_taken')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="maintainer_name" class="form-label">Засвар хийсэн хүний нэр, албан тушаал</label>
                                <input type="text" name="maintainer_name" class="form-control" value="{{ old('maintainer_name') }}">
                                @error('maintainer_name')
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

            $('#province-dropdown').on('change', function () {
                let provinceId = $(this).val();
                let sumDropdown = $('#sum-dropdown');

                // Clear existing options
                sumDropdown.html('<option value="">-- Сонгох --</option>');

                if (provinceId) {
                    $.ajax({
                        url: `/get-sums/${provinceId}`,
                        type: 'GET',
                        success: function (data) {
                            $.each(data, function (index, sum) {
                                sumDropdown.append(`<option value="${sum.id}">${sum.name}</option>`);
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching sums:', error);
                        }
                    });
                }
            });

        });
    </script>
@endsection
