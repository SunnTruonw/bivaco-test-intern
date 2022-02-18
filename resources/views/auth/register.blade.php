@extends('frontend.layouts.main')
@section('title', 'Đăng ký')

@section('content')
<style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #fff!important;
    }
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');
    .box_container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 0;
    }
    .card-header {
        text-align: left;
        text-transform:uppercase;
        font-weight: 700;
        font-size: 20px;
    }
    .navbar-brand {
        font-size: 25px;
        font-weight:700; 
    }
    .container {
    }
    .card {
        background: #eee;
    }
    .card-header {
        background: #000;
        text-align: center;
        color: #fff;
    }
    .card-body .dang_ky{
        width: 100%;
        margin-top: 15px;
        text-align: center;
        max-width: 257px;
    }
    .card-body .dang_ky a{
        color: #c01d25;
    }
    .navbar-light .navbar-brand {
        color: #c01d25
    }
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 600;
    }
    .btn-primary {
        background: #c01d25;
        border: 0;
        padding: 5px 20px;
    }
    .btn-link {
        font-weight: 400;
        color: #c01d25;
        font-size: 15px;
        text-decoration: none;
    }
</style>
<div class="box_container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{-- <div class="card-header">{{ __('Đăng ký') }}</div> --}}
                    <div class="card-header"> {{ isset($url) ? ucwords($url) : ""}} {{ __('Đăng ký') }}</div>
                    <div class="card-body">
                        {{-- <form method="POST" action="{{ route('register') }}"> --}}
                        @isset($url)
                        <form method="POST" action='{{ url("register/$url") }}' aria-label="{{ __('Register') }}">
                        @else
                        <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                        @endisset
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Họ và tên') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Tên đăng nhập') }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Nhập lại mật khẩu') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Đăng ký') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
