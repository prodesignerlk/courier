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
                                                <input type="text"
                                                       class="form-control @error('web_store_name')  is-invalid @enderror"
                                                       name="web_store_name" value="{{old('web_store_name')}}" required>
                                                @error('web_store_name')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="seller_name"
                                                       class="form-group">{{ __('Seller Name') }}</label>
                                                <input type="text"
                                                       class="form-control @error('seller_name')  is-invalid @enderror"
                                                       name="seller_name" value="{{old('seller_name')}}"
                                                       required autocomplete="seller_name">
                                                @error('seller_name')
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
                                                <input type="number"
                                                       class="form-control @error('seller_tp_1')  is-invalid @enderror"
                                                       name="seller_tp_1" value="{{old('seller_tp_1')}}"
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
                                                <input type="text"
                                                       class="form-control @error('address_line_1')  is-invalid @enderror"
                                                       name="address_line_1" value="{{old('address_line_1')}}"
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
                                                <label for="district_id" class="form-group">{{ __('District') }}</label>
                                                <select name="district_id" id="district_id"
                                                        class="js-example-basic-single @error('district_id') is-invalid @enderror">
                                                    <option value="" disabled selected>Select District</option>
                                                    @foreach($districtDetails as $district)
                                                        <option
                                                            value="{{$district->district_id}}" @if(old('district_id') == $district->district_id) {{'selected'}} @endif>{{$district->district_name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('district_id')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="city_id" class="form-group">{{ __('City') }}</label>
                                                <select name="city_id" id="city_id"
                                                        class="form-control js-example-basic-single @error('city_id') is-invalid @enderror">
                                                    <option value="" disabled selected>Select City</option>
                                                    @foreach($cityDetails as $city)
                                                        <option
                                                            value="{{$city->city_id}}" @if(old('city_id') == $city->city_id) {{'selected'}} @endif>{{$city->city_name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('city_id')
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
                                                    <option
                                                        value="3" @if(old('payment_period') == '3') {{'selected'}} @endif>
                                                        After 3 Days
                                                    </option>
                                                    <option
                                                        value="7" @if(old('payment_period') == '7') {{'selected'}} @endif>
                                                        After 7 Days
                                                    </option>
                                                    <option
                                                        value="15" @if(old('payment_period') == '15') {{'selected'}} @endif>
                                                        After 15 Days
                                                    </option>
                                                    <option
                                                        value="30" @if(old('payment_period') == '30') {{'selected'}} @endif>
                                                        After 30 Days
                                                    </option>
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
                                                <input id="email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email" value="{{old('email')}}" required
                                                       autocomplete="email">
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
                                                <input id="password-confirm" type="password" class="form-control"
                                                       name="password_confirmation" required
                                                       autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p>By clicking this "Create new account" you are agreed to the <a href=""
                                                                                                              target="blank">terms
                                                    and conditions</a> of {{config('app.name')}}</p>
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
    <script>
        $('#district_id').change(function () {
            let district_id = $(this).val();
            var option = "";

            $.ajax({
                url: "{{route('districts_city')}}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{csrf_token()}}",
                    district_id: district_id,
                }, success: function (data) {
                    // console.log(data.city_details);
                    $.each(data.city_details, function (i, city) {
                        option += "<option value=" + city.city_id + ">" + city
                            .city_name + "</option>";
                    });

                    $('#city_id').html(
                        "<option value='null' disabled selected >Select City</option>");
                    $('#city_id').append(option);


                },
                error: function (error) {
                    // console.log(error);
                    notify('error', 'City data error.');

                }
            });
        });
    </script>
@endsection
