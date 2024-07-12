@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
            <div class="row login-box justify-content-center">
                <div class="col-6">
                    <h5>Kelola E-Commerce mu dengan</h5>
                    <h3>Inem</h3>
                    <p>Integrator e-commerce menggunakan Robotic Process Automation</p>
                    <img src="{{ "backend/img/login-pict.png" }}" alt="">
                </div>
                <div class="col-6 login-box-body" style="padding-top:70px">
                    <h3 class="mb-3 text-center">Selamat <span style="color:#0F8843;font-weight:700;">Datang</span>!</h3>

                    @if($errors->any())
                    <div class="alert alert-dark bg-dark text-light border-0 alert-dismissible fade show" role="alert">
                        {{$errors->first()}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" class="form-login">
                        @csrf

                        <div class="row mb-3 justify-content-center">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}

                            <div class="col-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> --}}

                            <div class="col-10">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingat Saya') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center mb-3">
                            <div class="col-10 btn-login">
                                <button type="submit" class="">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <div class="col-10 login-text">
                                @if (Route::has('password.request'))
                                <a class="" href="{{ route('password.request') }}">
                                    {{ __('Lupa Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-10 login-text">
                                <span>Belum punya akun? </span> <a href="{{ url('register_user') }}">{{ __('Register') }} Sekarang! </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
