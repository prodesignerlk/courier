@extends('layouts.auth-layout')

@section('content')

<div class="page-wrapper full-page">
    <div class="page-content d-flex align-items-center justify-content-center">

        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4 pr-md-0">
                            <div class="auth-left-wrapper">

                            </div>
                        </div>
                        <div class="col-md-8 pl-md-0">
                            <div class="auth-form-wrapper px-4 py-5">
                                <a href="#" class="noble-ui-logo d-block mb-3"><img class="ui-fc" src="{{url('./assets/images/logo.png')}}"></a>
                                <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
                                <form method="POST" action="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="">Enter your  Email Address </label>
                                        <input id="email" type="text" placeholder="Email ලිපිනය ඇතුළත් කරන්න." class="form-control @if($errors->has('email') || $errors->has('contact_no')) is-invalid @endif" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>didewinuwara@outloo.com </strong>
                                                </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="">Enter your Password</label>
                                        <input id="password" type="password" placeholder="ඔබගේ මුරපදය ඇතුලත් කරන්න" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            <span class="invalid-feedback" role="alert">
                                                <strong></strong>
                                            </span>
                                    </div>
                                    <div class="form-check form-check-flat form-check-primary">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                            <i class="btn-icon-prepend" data-feather="lock"></i>
                                            Login to dashboard
                                        </button>
                                    </div>
                                    <a href="" class="d-block mt-3 text-muted">Don't have an account? <span class="text-primary">Create one</span></a>
                                    <a href="">Forget Password</a>
                                </form>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection