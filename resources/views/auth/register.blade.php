@extends('layouts.adminLayout')


@section('css')
    <style>
        #choose-location, #sidebar, .btn-primary{
            display: none !important;
        }
    </style>
@endsection


@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="auth-container">


        <div class="middle-row">
            <div class="form-container">
                <h1>
                    <span class="tertiary">{{__('Create your account')}}</span>
                </h1>

                <div class="form">

                    @if(request()->has('invite_token'))
                        <input type="hidden" name="invite_token" value="{{ request()->get('invite_token') }}">
                    @else 
                        <input type="hidden" name="invite_token" value="{{null}}">
                    @endif


                    <div class="input-group">
                        <label for="name">{{__('First name and Last Name')}}</label>


                        <div>
                            <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        </div>


                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="email">{{__('Email')}}</label>


                        <div>
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>


                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="input-group">
                        <label for="password">{{__('Password')}}</label>

                        <div>
                            <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required>
                        </div>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="confirm-password">{{__('Confirm password')}}</label>

                        <div>
                            <input id="confirm-password" type="password" class=" @error('confirm-password') is-invalid @enderror" name="confirm-password" required>
                        </div>

                        @error('confirm-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="login-button-container">
            <button type="submit"  style="background: rgb(253, 165, 60);color:white;font-size: 22px;font-weight: 700;">
                {{__('Create account')}}
            </button>
        </div>
    </div>
</form>
@endsection