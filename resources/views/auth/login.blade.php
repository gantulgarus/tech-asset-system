@extends('layouts.guest')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-lg-4">
        <div class="text-center mb-4">
            <div class="overlay">
                <h4 class="text-white text-shadow">{{ __('Багануур Зүүн Өмнөд Бүсийн Цахилгаан Түгээх Сүлжээ') }}</h4>
                
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid rounded-circle border" style="max-width: 100px; height: 100px;">
                </div>
                <div>
                    <h4 class="subtitle">{{ __('Техникийн мэдээллийн сан') }}</h4>
                </div>
                <form action="{{ route('login') }}" method="POST" style="width: 100%;">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-primary text-white">
                            <svg class="icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-envelope-open') }}"></use>
                            </svg>
                        </span>
                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                               placeholder="{{ __('Имэйл хаяг') }}" required autofocus>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-primary text-white">
                            <svg class="icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                            </svg>
                        </span>
                        <input class="form-control @error('password') is-invalid @enderror" type="password"
                               name="password" placeholder="{{ __('Нууц үг') }}" required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">{{ __('Нэвтрэх') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
