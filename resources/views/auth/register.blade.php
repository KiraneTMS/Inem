@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row login-box justify-content-center">
        <div class="col-6">
            <h5>Kelola E-Commerce mu dengan</h5>
            <h3>Inem</h3>
            <p>Integrator e-commerce menggunakan Robotic Process Automation</p>
            <img src="{{ "backend/img/login-pict.png" }}" alt="">
        </div>
            <div class="col-6 login-box-body">
                <h3 class="mb-3 text-center">Join<span style="color:#13AA54;font-weight:700;"> INEM</span>!</h3>
                    <form method="POST" action="{{ url('store_register_user') }}" class="form-login">
                        @csrf

                        <div class="row justify-content-center mb-3">
                            {{-- <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label> --}}

                            <div class="col-10">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Full Name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}

                            <div class="col-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> --}}

                            <div class="col-10">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                            {{-- <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label> --}}

                            <div class="col-10">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Retype Password">
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center mb-0">
                            <div class="col-10 btn-login">
                                <button type="submit">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-10 login-text">
                                <span>Already have an account? </span> <a href="{{ route('login') }}">{{ __('Login') }} here</a>
                            </div>
                        </div>
                    </form>
            </div>
    </div>
</div>
@endsection
