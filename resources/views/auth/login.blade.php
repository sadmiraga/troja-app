@extends('layouts.adminLayout')

@section('css')
    <style>
        #back-button{
            display: none;
        }
    </style>
@endsection

@section('content')


    <!--
    <div id="app">
        <login-component></login-component>
    </div>
    -->

    <form method="POST" action="{{ route('login') }}">
        <div class="auth-container">


            <div class="logo" style="visibility: hidden;">
                <img src="images/logo.png" style="width: 150px;height: fit-content;" />
            </div>

            <div class="middle-row">
                <div class="form-container">
                    <h1>
                        <span class="tertiary">{{ __('Login') }}</span><br>
                    </h1>

                    @if ($errors->any())
                        <div class="alert alert-danger custom-danger-popup">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="form">
                        @csrf

                        <div class="input-group">
                            <label for="email">{{ __('Email') }}</label>

                            <div>
                                <input id="email" type="email" class="@error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>


                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="input-group">
                            <label for="password">{{ __('Password') }}</label>

                            <div>
                                <input id="password" type="password" class=" @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password">
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @if (Route::has('password.request'))
                            <div class="input-group">
                                <a class="tertiary" href="{{ route('password.request') }}">
                                    {{ __('Did you forger your password?') }}
                                </a>
                            </div>
                        @endif

                        <div class="input-group">
                            <div class="input-group">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Check for error message -->
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="login-button-container">
                <button type="submit" style="background: rgb(253, 165, 60) !important;color:white;font-size: 22px;font-weight: 700;">
                    {{__('Login')}}
                </button>
            </div>
        </div>
    </form>
@endsection
