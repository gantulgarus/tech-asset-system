@extends('layouts.admin')

@section('content')
<div class="container">
    <form action="{{ route('outage-schedule-types.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Нэр</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Хадгалах</button>
    </form>
</div>
@endsection
