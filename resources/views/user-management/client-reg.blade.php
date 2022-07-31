@extends('layouts.dashboard.main')

@section('content')

    @can('seller.create')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Seller Registration</p>
                    </div>
                    <div class="card-body">
                        <form action="{{route('register')}}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">Web Store</label>
                                    <input type="text" name="web_store_name" id=""
                                           class="form-control @error('web_store_name')  is-invalid @enderror"
                                           value="{{old('web_store_name')}}" required
                                           placeholder="Name of Web Store">
                                    @error('web_store_name')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Username</label>
                                    <input type="text" class="form-control @error('seller_name')  is-invalid @enderror"
                                           name="seller_name" value="{{old('seller_name')}}"
                                           placeholder="Seller User Name"
                                           required autocomplete="seller_name">
                                    @error('seller_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Contact</label>
                                    <input type="number"
                                           class="form-control @error('seller_tp_1')  is-invalid @enderror"
                                           name="seller_tp_1" value="{{old('seller_tp_1')}}"
                                           required autocomplete="seller_tp_1" placeholder="Contact Number">
                                    @error('seller_tp_1')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>
                            <p>Address</p>
                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <input type="text"
                                           class="form-control @error('address_line_1')  is-invalid @enderror"
                                           name="address_line_1" value="{{old('address_line_1')}}"
                                           required placeholder="Address Line">
                                    @error('address_line_1')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror

                                </div>
                                <div class="form-group col-md-4 col-sm-12">
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
                                <div class="form-group col-md-4 col-sm-12">
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
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="payment_period"
                                           class="form-group">{{ __('Payment Types') }}</label><br>
                                    <select name="payment_period" id=""
                                            class="form-control @error('payment_period') is-invalid @enderror">
                                        <option value="" disabled selected>Select Payment Type</option>
                                        <option value="3" @if(old('payment_period') == '3') {{'selected'}} @endif>After
                                            3
                                            Days
                                        </option>
                                        <option value="7" @if(old('payment_period') == '7') {{'selected'}} @endif>After
                                            7
                                            Days
                                        </option>
                                        <option value="15" @if(old('payment_period') == '15') {{'selected'}} @endif>
                                            After 15
                                            Days
                                        </option>
                                        <option value="30" @if(old('payment_period') == '30') {{'selected'}} @endif>
                                            After 30
                                            Days
                                        </option>
                                    </select>
                                    @error('payment_period')
                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">Bank Name</label>
                                    <input type="text"
                                           class="form-control @error('bank_name') is-invalid @enderror"
                                           name="bank_name" value="{{ old('bank_name') }}" required
                                           autocomplete="bank_name" placeholder="Enter Bank Name">
                                    @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Branch</label>
                                    <input type="text"
                                           class="form-control @error('branch_name') is-invalid @enderror"
                                           name="branch_name" value="{{ old('branch_name') }}" required
                                           autocomplete="branch_name" placeholder="Enter Branch Name">
                                    @error('branch_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Account Number</label>
                                    <input type="text"
                                           class="form-control @error('account_no') is-invalid @enderror"
                                           name="account_no" value="{{ old('account_no') }}" required
                                           autocomplete="account_no" placeholder="Enter Account No.">
                                    @error('account_no')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="">Login Email</label>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{old('email')}}" required
                                           autocomplete="email" placeholder="Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Password</label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required autocomplete="new-password"
                                           placeholder="More than 8 characters">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required placeholder="Re-enter Password"
                                           autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    @can('seller.view')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Seller View</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="seller-view-table" style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">Web Store</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">City</th>
                                    <th scope="col">District</th>
                                    <th scope="col">Payment Period</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Account No.</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <script>
        $('document').ready(function () {
            load_data();
        });

        function load_data() {
            $('#seller-view-table').DataTable({
                drawCallback: function () {
                    feather.replace();
                },
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 50, 100, 500, 1000, 5000, -1],
                    ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows', '5000 rows', 'Show all']
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
                ],
                scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('seller_view_table') }}',
                },
                columns: [{
                    data: 'name',
                    name: 'name'
                },
                    {
                        data: 'seller_name',
                        name: 'seller_name'
                    },
                    {
                        data: 'seller_tp_1',
                        name: 'seller_tp_1'
                    },
                    {
                        data: 'address_line_1',
                        name: 'address_line_1'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'district',
                        name: 'district'
                    },
                    {
                        data: 'payment_period',
                        name: 'payment_period'
                    },
                    {
                        data: 'bank_name',
                        name: 'bank_name'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'account_no',
                        name: 'account_no'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
        }
    </script>

@endsection
