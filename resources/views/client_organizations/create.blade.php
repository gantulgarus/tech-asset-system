@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Хэрэглэгч ААН-ийн нэр нэмэх</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('client-organizations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Нэр</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Хадгалах</button>
        <a href="{{ route('client-organizations.index') }}" class="btn btn-secondary">Буцах</a>
    </form>
</div>
@endsection
