@extends('admin.layouts.app')

@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown" style="padding-top: 5%;">
        <div>
            <img alt="image" src="{{ asset('backend/assets/image/small_logo.png') }}" style="height: 100px;width: 40%;" />

            <h3>Welcome to {{config('app.name')}}</h3>
            <p>Login to access your Dashboard.</p>
            <form method="POST" action="{{ route('admin.login.submit') }}" class="form-example">
                @csrf
                <div class="form-group row">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email..." required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback text-left" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password..." required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback text-left" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <button type="submit" class="btn btn-primary block full-width m-b dim" style="margin-right: 0px;">Login</button>
                </div>

                <a href="#"><small>Forgot password?</small></a>
            </form>
        </div>
    </div>
@endsection
