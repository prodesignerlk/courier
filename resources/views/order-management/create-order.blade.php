@extends('layouts.dashboard.main')

@section('content')
    @can('order.create')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Create Order</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('create_order_post') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Waybill :</label>
                                    <input type="text" name="waybill_number" id="waybill_number"
                                        class="form-control @error('waybill_number') is-invalid @enderror"
                                        value="{{ old('waybill_number') }}">
                                    @error('waybill_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Seller :</label>
                                    <select name="seller_id" id="seller_id"
                                        class="form-control @error('seller_id') is-invalid @enderror" readonly>
                                    </select>
                                    @error('seller_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Customer Name :</label>
                                    <input type="text" name="cus_name" id=""
                                        class="form-control @error('cus_name') is-invalid @enderror"
                                        value="{{ old('cus_name') }}">
                                    @error('cus_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Contact Number :</label>
                                    <input type="text" name="cus_contact" id="" maxlength="10"
                                        class="form-control @error('cus_contact') is-invalid @enderror"
                                        value="{{ old('cus_contact') }}">
                                    @error('cus_contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Contact Number(Optional) :</label>
                                    <input type="text" name="cus_contact_2" id="" maxlength="10"
                                        class="form-control @error('cus_contact_2') is-invalid @enderror"
                                        value="{{ old('cus_contact_2') }}">
                                    @error('cus_contact_2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Address :</label>
                                    <input type="text" name="cus_address" id=""
                                        class="form-control @error('cus_address') is-invalid @enderror"
                                        value="{{ old('cus_address') }}">
                                    @error('cus_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">District :</label>
                                    <select name="district_id" id="district_id"
                                        class="form-control js-example-basic-single @error('district_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select District</option>
                                        @foreach ($district_details as $district)
                                            <option value="{{ $district->district_id }}" @if (old('district_id') == $district->district_id) {{ 'selected' }} @endif>
                                                {{ $district->district_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">City :</label>
                                    <select name="city_id" id="city_id"
                                        class="form-control js-example-basic-single @error('city_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select City</option>
                                        @foreach ($city_details as $city)
                                            <option value="{{ $city->city_id }}" @if (old('city_id') == $city->city_id) {{ 'selected' }} @endif>
                                                {{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Order Description :</label>
                                    <input type="text" name="order_description" id=""
                                        class="form-control @error('order_description') is-invalid @enderror"
                                        value="{{ old('order_description') }}">
                                    @error('order_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">COD Amount :</label>
                                    <input type="text" name="cod" id="" class="form-control @error('cod') is-invalid @enderror"
                                        value="{{ old('cod') }}">
                                    @error('cod')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Pickup Branch :</label>
                                    <select name="pickup_branch_id" id=""
                                        class="form-control js-example-basic-single @error('pickup_branch_id') is-invalid @enderror">
                                        <option value="" disabled selected>Select Pickup Branch</option>
                                        @foreach ($branche_details as $branch)
                                            <option value="{{ $branch->branch_id }}" @if (old('pickup_branch_id') == $branch->branch_id) {{ 'selected' }} @endif>
                                                {{ $branch->branch_code }} - {{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('pickup_branch_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block">Create Order</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Add Bulk Orders (Upload Excel)</p>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="alert alert-info" role="alert">
                                        You can download sample format of excel sheet <a href="#">HERE</a>. Make sure the format
                                        should be .xls or .xslx.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="">Pickup Branch :</label>
                                    <select name="" id="" class="form-control js-example-basic-single">
                                        <option value="" disabled selected>Select...</option>
                                        <option value="">Ambalantota</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Upload Excel</label>
                                    <input type="file" class="form-control-file" name="" id="" placeholder="Upload file"
                                        aria-describedby="fileHelpId">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-block">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <script>
        $('document').ready(function() {
            seller();

            //get seller id
            $('#waybill_number').on('keyup', function() {
                seller();
            });

            //get cities
            $('#district_id').change(function() {
                let dis_id = $(this).val();
                var option = "";
                $.ajax({
                    url: '{{ route('districts_city') }}',
                    method: 'post',
                    data: {
                        district_id: dis_id,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#city_id').html(' ');
                    },
                    success: function(data) {
                        // console.log(data.city_details);
                        $.each(data.city_details, function(i, city) {
                            option += "<option value=" + city.city_id + ">" + city
                                .city_name + "</option>";
                        });

                        $('#city_id').html(
                            "<option value='null' disabled selected >Select City</option>")
                        $('#city_id').append(option);

                    },
                    error: function(error) {
                        // console.log(error);
                        notify('error', 'City data error.');

                    }
                });
            });

            //get districts
            $('#city_id').change(function() {
                let city_id = $(this).val();
                var option = "";
                $.ajax({
                    url: '{{ route('districts_city') }}',
                    method: 'post',
                    data: {
                        city_id: city_id,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#district_id').html(' ');
                    },
                    success: function(data) {
                        // console.log(data);
                        option += "<option selected value=" + data.district_details
                            .district_id + ">" + data.district_details.district_name +
                            "</option>";
                        $('#district_id').html(option);

                    },
                    error: function(error) {
                        // console.log(error);
                        notify('error', 'City data error.');

                    }
                });
            });
        });

        function seller() {
            var option = "";
            let waybill_id = $('#waybill_number').val();
            $.ajax({
                url: '{{ route('get_waybill_details') }}',
                method: 'post',
                data: {
                    waybill_id: waybill_id,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#seller_id').html('');
                },
                success: function(data) {
                    // console.log(data);
                    if (data.seller_name) {
                        option = "<option selected value=" + data.seller_id + ">" + data.seller_name +
                            "</option>";

                    } else {
                        option = "<option selected value='null'>Invalid Waybill</option>";
                    }

                    $('#seller_id').html(option);
                },
                error: function(error) {
                    // console.log(error);
                    option = "<option selected value='null'>Invalid Waybill</option>";
                    $('#seller_id').html(option);

                }
            });

        };
    </script>
@endsection
