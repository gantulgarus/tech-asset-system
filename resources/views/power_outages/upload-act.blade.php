@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Акт оруулах
            </div>
            <h2>Upload PDF for Power Outage #{{ $powerOutage->id }}</h2>
            <div class="card-body">
                <form action="{{ route('power_outage.upload-act', $powerOutage->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group mb-4">
                            <label for="act_file">Файл</label>
                            <input type="file" name="act_file" id="act_file" class="form-control" accept="application/pdf">
                            @error('act_file')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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
