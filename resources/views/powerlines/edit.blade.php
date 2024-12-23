@extends('layouts.admin')

@section('content')
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                Шугам засах
            </div>
            <div class="card-body">
                <form action="{{ route('powerlines.update', $powerline) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="station_id" class="form-label">Дэд станц</label>
                                <div class="form-group mb-3">
                                    <select id="station-dropdown" name="station_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('station_id', $powerline->station_id) == $station->id ? 'selected' : '' }}>
                                                {{ $station->branch?->name }} | {{ $station->name }}
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
                                <label for="line_type" class="form-label">Төрөл</label>
                                <div class="form-group mb-3">
                                    <select id="type-dropdown" name="line_type" class="form-control">
                                        <option value="ЦДАШ" {{ $powerline->line_type == 'ЦДАШ' ? 'selected' : '' }}>ЦДАШ</option>
                                        <option value="ЦДКШ" {{ $powerline->line_type == 'ЦДКШ' ? 'selected' : '' }}>ЦДКШ</option>
                                    </select>
                                </div>
                                @error('line_type')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Шугамын ША-ны нэр</label>
                                <input type="text" name="name" class="form-control" value="{{ $powerline->name }}">
                                @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="volt_id" class="form-label">Хүчдэлийн түвшин</label>
                                <div class="form-group mb-3">
                                    <select name="volt_id" class="form-control">
                                        <option value="">-- Сонгох --</option>
                                        @foreach ($volts as $volt)
                                        <option value="{{$volt->id}}" {{ old('volt_id', $powerline->volt_id) == $volt->id ? 'selected' : '' }}>
                                            {{$volt->name}}
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
                                <label for="create_year" class="form-label">Ашиглалтад орсон он</label>
                                <input type="text" id="create_year" name="create_year" class="form-control" value="{{ $powerline->create_year }}">
                                @error('create_year')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="line_mark" class="form-label">Утасны марк</label>
                                <input type="text" name="line_mark" class="form-control" value="{{ $powerline->line_mark }}">
                                @error('line_mark')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tower_mark" class="form-label">Тулгуурын марк</label>
                                <input type="text" name="tower_mark" class="form-control" value="{{ $powerline->tower_mark }}">
                                @error('tower_mark')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tower_count" class="form-label">Тулгуурын тоо</label>
                                <input type="number" name="tower_count" class="form-control" value="{{ $powerline->tower_count }}">
                                @error('tower_count')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="line_length" class="form-label">Шугамын урт /км/</label>
                                <input type="number" step="0.001" name="line_length" class="form-control" value="{{ $powerline->line_length }}">
                                @error('line_length')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="isolation_mark" class="form-label">Изоляторын маяг</label>
                                <input type="text" name="isolation_mark" class="form-control" value="{{ $powerline->isolation_mark }}">
                                @error('isolation_mark')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="muft_count" class="form-label">Муфтны тоо</label>
                                <input type="number" name="muft_count" class="form-control" value="{{ $powerline->muft_count }}">
                                @error('muft_count')
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
        });

        $('#create_year').flatpickr();

    </script>
@endsection