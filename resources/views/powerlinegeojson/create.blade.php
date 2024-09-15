@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Трассын координат файл оруулах
            </div>
            <div class="card-body">
                <form action="{{ route('powerlinegeojson.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">


                        <div class="mb-3">
                            <label for="powerline_id" class="form-label">ЦДАШ</label>
                            <div class="form-group mb-3">
                                <select  id="powerline-dropdown" name="powerline_id" class="form-control">
                                    <option value="">-- Сонгох --</option>
                                    @foreach ($powerlines as $powerline)
                                    <option value="{{$powerline->id}}" {{ old('powerline_id') == $powerline->id ? 'selected' : '' }}>
                                        {{$powerline->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('powerline_id')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="file">Файл:</label>
                            <input type="file" class="form-control" name="geojson_file">
                            @error('geojson_file')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
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