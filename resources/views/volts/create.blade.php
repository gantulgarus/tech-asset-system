@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-secondary text-white" href="{{ route('volts.index') }}"> Буцах</a>
                </div>
            </div>
        </div>
        <br />
        <div class="card">
            <div class="card-body">
                <form action="{{ route('volts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Нэр</label>
                                <input type="text" name="name" class="form-control" placeholder="Хүчдлийн түвшний утга">
                                @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="order" class="form-label">Эрэмбэ</label>
                                <input type="text" name="order" class="form-control" placeholder="Эрэмбэ">
                                @error('order')
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
