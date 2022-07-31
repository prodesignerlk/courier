@extends('layouts.auth-layout')

@section('content')
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">
            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pr-md-0">
                                <div class="auth-left-wrapper" style="background-position: 64%;">
                                </div>
                            </div>
                            <div class="col-md-8 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="#" class="noble-ui-logo d-block mb-3">
                                        <img class="ui-fc" src="{{url('./assets/images/logo.png')}}"></a>
                                    <h5 class="text-muted font-weight-normal mb-4">Create seller account here </h5>
                                    <form method="POST" action="{{route('register')}}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="web_store_name"
                                                       class="form-group">{{ __('Name of Web Store') }}</label>
                                                <input type="text" class="form-control @error('web_store_name')  is-invalid @enderror" name="web_store_name" value="{{old('web_store_name')}}" required>
                                                @error('web_store_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="seller_name" class="form-group">{{ __('Seller Name') }}</label>
                                                <input type="text" class="form-control @error('selle_name')  is-invalid @enderror" name="selle_name" value="{{old('selle_name')}}"
                                                       required autocomplete="seller_name">
                                                @error('selle_name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="seller_tp_1"
                                                       class="form-group">{{ __('Contact Number') }}</label>
                                                <input type="number" class="form-control @error('seller_tp_1')  is-invalid @enderror" name="seller_tp_1" value="{{old('seller_tp_1')}}"
                                                       required autocomplete="seller_tp_1">
                                                @error('seller_tp_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address_line1"
                                                       class="form-group">{{ __('Address') }}</label>
                                                <input type="text" class="form-control @error('address_line_1')  is-invalid @enderror" name="address_line_1" value="{{old('address_line_1')}}"
                                                       required>
                                                @error('address_line_1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="city_id" class="form-group">{{ __('City') }}</label>
                                                <select name="city_id" id="" class="form-control js-example-basic-single @error('city_id') is-invalid @enderror">
                                                    <option value="" disabled selected>Select City</option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                                @error('city_id')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="district_id" class="form-group">{{ __('District') }}</label>
                                                <select name="district_id" id=""
                                                        class="form-control js-example-basic-single @error('district_id') is-invalid @enderror">
                                                    <option value="" disabled selected>Select District</option>
                                                    <option value=""></option>
                                                    <option value=""></option>
                                                </select>
                                                @error('district_id')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="payment_period"
                                                       class="form-group">{{ __('Payment Types') }}</label>
                                                <select name="payment_period" id=""
                                                        class="form-control js-example-basic-single @error('payment_period') is-invalid @enderror">
                                                    <option value="" disabled selected>Select Payment Type</option>
                                                    <option value="3days" @if(old('payment_period') == '3days') {{'selected'}} @endif>After 3 Days</option>
                                                    <option value="7days"  @if(old('payment_period') == '7days') {{'selected'}} @endif>After 7 Days</option>
                                                    <option value="15days"  @if(old('payment_period') == '15days') {{'selected'}} @endif>After 15 Days</option>
                                                    <option value="30days"  @if(old('payment_period') == '30days') {{'selected'}} @endif>After 30 Days</option>
                                                </select>
                                                @error('payment_period')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="bank_name"
                                                       class="form-group">{{ __('Bank Name') }}</label>
                                                <input type="text"
                                                       class="form-control @error('bank_name') is-invalid @enderror"
                                                       name="bank_name" value="{{ old('bank_name') }}" required
                                                       autocomplete="bank_name">
                                                @error('bank_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="branch_name" class="form-group">{{ __('Branch') }}</label>
                                                <input type="text"
                                                       class="form-control @error('branch_name') is-invalid @enderror"
                                                       name="branch_name" value="{{ old('branch_name') }}" required
                                                       autocomplete="branch_name">
                                                @error('branch_name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="account_no"
                                                       class="form-group">{{ __('Account Number') }}</label>
                                                <input type="text"
                                                       class="form-control @error('account_no') is-invalid @enderror"
                                                       name="account_no" value="{{ old('account_no') }}" required
                                                       autocomplete="account_no">
                                                @error('account_no')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="email" class="form-group">{{ __('Email') }}</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('web_store_name')}}" required autocomplete="email">
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
                                                <input id="password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       name="password" required autocomplete="new-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="confirm-password"
                                                       class="form-group">{{ __('Confirm Password') }}</label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p>By clicking this "Create new account" you are agreed to the <a href="" target="blank">terms and conditions</a> of {{config('app.name')}}</p>
                                            <br>
                                            <button type="submit" class="btn btn-primary" id="sub_button">
                                                {{ __('Create new account') }}
                                            </button>
                                        </div>
                                        <a href="{{url('./login')}}" class="d-block mt-3 text-muted">Already a user?
                                            <span class="text-primary">Sign in</span></a>
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
