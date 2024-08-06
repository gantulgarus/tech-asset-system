@extends('layouts.guest')

@section('content')
    <div class="col-lg-4 mx-auto">
        <div class="text-center">
            <h4 class="text-white mb-4">{{ __('Багануур Зүүн Өмнөд Бүсийн Цахилгаан Түгээх Сүлжээ') }}</h4>
        </div>
        <div class="card-group d-block d-md-flex row">
            <div class="card col-md-4 py-4 mb-0">
                <div class="card-body d-flex flex-column align-items-center">

                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-4" style="max-width: 100px;">

                    <h6>{{ __('Мэдээллийн нэгдсэн сан') }}</h6>
                    <form action="{{ route('login') }}" method="POST" style="width: 100%;">
                        @csrf
                        <div class="input-group mb-3 w-100"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-envelope-open') }}"></use>
                                </svg></span>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                                placeholder="{{ __('Имэйл хаяг') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-group mb-4"><span class="input-group-text">
                                <svg class="icon">
                                    <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                                </svg></span>
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                name="password" placeholder="{{ __('Нууц үг') }}" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-primary px-4" type="submit">{{ __('Нэвтрэх') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
