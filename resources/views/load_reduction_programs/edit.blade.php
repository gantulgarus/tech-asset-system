@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>ААН-үүдийг ачаалал хөнгөлөх хөтөлбөр - Засвар</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('load-reduction-programs.update', $loadReductionProgram) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- This is important for updating the resource -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="branch_id" class="form-label">Салбар</label>
                                <div class="form-group mb-3">
                                    <select id="branch-dropdown" name="branch_id" class="form-select">
                                        @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}" {{ $branch->id == $loadReductionProgram->branch_id ? 'selected' : '' }}>
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
                                <label for="station_id" class="form-label">Дэд станц / ХБ</label>
                                <div class="form-group mb-3">
                                    <select id="station-dropdown" name="station_id" class="form-select">
                                        <option></option>
                                        @foreach ($stations as $station)
                                        <option value="{{$station->id}}" {{ $station->id == $loadReductionProgram->station_id ? 'selected' : '' }}>
                                            {{ $station->station_type }} | {{$station->name}}
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
                                <label for="company_name" class="form-label">Хэрэглэгчийн ААН-ийн нэр</label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $loadReductionProgram->company_name) }}">
                                @error('company_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="output_name" class="form-label">Гаргалгааны нэр</label>
                                <input type="text" name="output_name" class="form-control" value="{{ old('output_name', $loadReductionProgram->output_name) }}">
                                @error('output_name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reduction_capacity" class="form-label">2024-2025 хэрэглээг бууруулах чадал, МВт (17-21 цагт)</label>
                                <input type="number" step="any" name="reduction_capacity" class="form-control" id="reduction_capacity" value="{{ old('reduction_capacity', $loadReductionProgram->reduction_capacity) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pre_reduction_capacity" class="form-label">Ачаалал хөнгөлөхийн өмнөх чадал, (МВт)</label>
                                <input type="number" step="any" name="pre_reduction_capacity" class="form-control" id="pre_reduction_capacity" value="{{ old('pre_reduction_capacity', $loadReductionProgram->pre_reduction_capacity) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reduction_time" class="form-label">Ачаалал хөнгөлсөн цаг</label>
                                <input type="time" name="reduction_time" class="form-control" id="reduction_time" value="{{ old('reduction_time', $loadReductionProgram->reduction_time) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reduced_capacity" class="form-label">Хөнгөлсөн чадал, (МВт)</label>
                                <input type="number" step="any" name="reduced_capacity" class="form-control" id="reduced_capacity" value="{{ old('reduced_capacity', $loadReductionProgram->reduced_capacity) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post_reduction_capacity" class="form-label">Ачаалал хөнгөлсний дараах чадал, (МВт)</label>
                                <input type="number" step="any" name="post_reduction_capacity" class="form-control" id="post_reduction_capacity" value="{{ old('post_reduction_capacity', $loadReductionProgram->post_reduction_capacity) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="restoration_time" class="form-label">Ачаалал авсан цаг</label>
                                <input type="time" name="restoration_time" class="form-control" value="{{ old('restoration_time', $loadReductionProgram->restoration_time) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="energy_not_supplied" class="form-label">Дутуу түгээсэн ЦЭХ (кВт.ц)</label>
                                <input type="number" step="any" name="energy_not_supplied" class="form-control" value="{{ old('energy_not_supplied', $loadReductionProgram->energy_not_supplied) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Тайлбар</label>
                                <textarea name="remarks" class="form-control" id="remarks">{{ old('remarks', $loadReductionProgram->remarks) }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary ml-3">Засварлах</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
