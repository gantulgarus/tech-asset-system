@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <a class="btn btn-secondary mb-2" href="{{ route('cause_outages.index') }}"> Буцах</a>
        <br />
        <div class="card">
            <div class="card-body">
                <form action="{{ route('cause_outages.update', $causeOutage) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Нэр</label>
                                <input type="text" name="name" value="{{ $causeOutage->name }}" class="form-control">
                                @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Тайлбар</label>
                                <input type="text" name="description" value="{{ $causeOutage->description }}" class="form-control">
                                @error('description')
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
