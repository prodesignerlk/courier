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
                                <h5 class="text-muted font-weight-normal mb-4">Create your Kelani account here </h5>
                                <form method="POST" action="">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="first_name" class="form-group">{{ __('User Type') }}</label>
                                            <select name="user_type" id="user_type"  required>
                                                <option value="null" >Select Charactor</option>
                                                <option value="1" >Teacher</option>
                                                <option value="0" >Student</option>
                                                <option value="2" >Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-group">{{ __('Company Name') }}</label>
                                            <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-group">{{ __('Company Contact') }}</label>
                                            <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-group">{{ __('Company Registration Name') }}</label>
                                            <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-group">{{ __('Company Registration Number') }}</label>
                                            <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-group">{{ __('Website') }}</label>
                                            <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email" class="form-group">{{ __('Address') }}</label>
                                            <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="first_name" class="form-group">{{ __('Owner Name') }}</label>
                                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="last_name" class="form-group">{{ __('Owner Contact') }}</label>
                                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="email" class="form-group">{{ __('E-Mail Address') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="password" class="form-group">{{ __('Password') }}</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="confirm-password" class="form-group">{{ __('Confirm Password') }}</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="form-check form-check-flat form-check-primary">

                                    </div>
                                    <div class="mt-3">
                                        @if(isset($teacherid))
                                            <input type="hidden" name="class_id" value="{{$classid}}">
                                            <input type="hidden" name="teacherid" value="{{$teacherid}}">
                                        @endif
                                        <p>By clicking this "Create new account" you are agreed to the <a href="" target="blank">terms and conditions</a> of CourierPro</p>
                                        <button type="submit" class="btn btn-primary" id="sub_button" disabled>
                                            {{ __('Create new account') }}
                                        </button>
                                    </div>
                                    <a href="{{url('./login')}}" class="d-block mt-3 text-muted">Already a user? <span class="text-primary">Sign in</span></a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection