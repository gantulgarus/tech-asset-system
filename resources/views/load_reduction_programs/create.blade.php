@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>ААН-үүдийг ачаалал хөнгөлөх хөтөлбөр</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('load-reduction-programs.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client_organization_id" class="form-label">Хэрэглэгч ААН-ийн нэр</label>
                                <div class="form-group mb-3">
                                    <select id="client-dropdown" name="client_organization_id" class="form-select">
                                        <option></option>
                                        @foreach ($clientOrgs as $org)
                                        <option value="{{$org->id}}">
                                            {{$org->name}} | {{ $org->output_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('client_organization_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pre_reduction_capacity" class="form-label">Ачаалал хөнгөлөхийн өмнөх чадал, (МВт)</label>
                                <input type="number" step="any" name="pre_reduction_capacity" class="form-control"
                                    id="pre_reduction_capacity">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reduction_time" class="form-label">Ачаалал хөнгөлсөн цаг</label>
                                <input type="datetime-local" name="reduction_time" class="form-control" id="reduction_time">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reduced_capacity" class="form-label">Хөнгөлсөн чадал, (МВт)</label>
                                <input type="number" step="any" name="reduced_capacity" class="form-control" id="reduced_capacity">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post_reduction_capacity" class="form-label">Ачаалал хөнгөлсний дараах чадал, (МВт)</label>
                                <input type="number" step="any" name="post_reduction_capacity" class="form-control"
                                    id="post_reduction_capacity">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="restoration_time" class="form-label">Ачаалал авсан цаг</label>
                                <input type="datetime-local" name="restoration_time" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="energy_not_supplied" class="form-label">Дутуу түгээсэн ЦЭХ (кВт.ц)</label>
                                <input type="number" step="any" name="energy_not_supplied" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Тайлбар</label>
                                <textarea name="remarks" class="form-control" id="remarks"></textarea>
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
