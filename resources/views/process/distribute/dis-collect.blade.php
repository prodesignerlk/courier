@extends('layouts.dashboard.main')

@section('content')
    @php
    $user = Auth::user();
    @endphp
    <div class="row">
        @can('order-collected.mark')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white action-header">
                        <p>Mark as Collected</p>
                    </div>
                    <div class="card-body action-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">Waybill Id</label>
                                <input type="text" name="" id="scan_waybill" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Weight (kg)</label>
                                <input type="text" name="" id="package_weight" placeholder="Default 1kg" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">District</label>
                                <select class="form-control js-example-basic-single" name="district_id" id="district_id">
                                    <option value="null" selected disabled>Select District</option>
                                    @foreach ($district_details as $district)
                                        <option value="{{ $district->district_id }}">{{ $district->district_name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-3">
                                <label for="">City</label>
                                <select class="form-control js-example-basic-single" name="" id="city_id">
                                    <option value="null" selected disabled>Select City</option>
                                    @foreach ($city_details as $city)
                                        <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <button type="button" class="btn btn-primary btn-block" id="btn-submit">Mark as Collect</button>
                            </div>
                        </div>
                        <hr>
                        <form id="user_data_form">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="">Seller Name</label>
                                    <input type="text" name="" id="seller_name" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Amount (LKR)</label>
                                    <input type="text" name="" id="cod" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Destination</label>
                                    <input type="text" name="" id="destination" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Remark</label>
                                    <input type="text" name="" id="remark" class="form-control" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
            @endcan

            @if ($user->can('order-collected.search') && $user->can('order-collected.view'))
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white search-header">
                                <p>Filtering</p>
                            </div>
                            <div class="card-body search-body">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="">From :</label>
                                        <input type="date" name="date_from" id="date_from" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">To :</label>
                                        <input type="date" name="date_to" id="date_to" class="form-control">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Branch :</label>
                                        <select name="branch_id" id="branch_id"
                                            class="form-control js-example-basic-single">
                                            <option value="null" selected disabled>All Branches</option>
                                            @foreach ($branch_details as $branch)
                                                <option value="{{ $branch->branch_id }}">{{ $branch->branch_code }} -
                                                    {{ $branch->branch_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Seller :</label>
                                        <select name="seller_id" id="seller_id"
                                            class="form-control js-example-basic-single">
                                            <option value="null" selected disabled>All Sellers</option>
                                            @foreach ($user_details as $user)
                                                @php
                                                    $seller = $user->seller;
                                                @endphp
                                                <option value="{{ $seller->seller_id }}">{{ $seller->seller_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-primary btn-block" id="filter">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            @endif

            @can('order-collected.view')
                <div class="col-mt-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <p>Collected Packages </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table-data" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Collected Date</th>
                                            <th scope="col">Waybill ID</th>
                                            <th scope="col">Pickup Branch</th>
                                            <th scope="col">Seller</th>
                                            <th scope="col">Receiver</th>
                                            <th scope="col">Delivery Address</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Mobile (Secondary)</th>
                                            <th scope="col">COD (LKR)</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('document').ready(function() {
                load_data();
            });

            function load_data(from_date, to_date, branch_id, seller_id) {
                $('#table-data').DataTable({
                    drawCallback: function() {
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
                        url: '{{ route('dis_collected_orders_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            branch_id: branch_id,
                            seller_id: seller_id
                        }
                    },
                    columns: [{
                            data: 'st_4_at',
                            name: 'st_4_at'
                        },
                        {
                            data: 'waybill_id',
                            name: 'waybill_id'
                        },
                        {
                            data: 'pickup_branch',
                            name: 'pickup_branch'
                        },
                        {
                            data: 'seller_name',
                            name: 'seller_name'
                        },
                        {
                            data: 'receiver_name',
                            name: 'receiver_name'
                        },
                        {
                            data: 'receiver_address',
                            name: 'receiver_address'
                        },
                        {
                            data: 'receiver_contact',
                            name: 'receiver_contact'
                        },
                        {
                            data: 'receiver_conatct_2',
                            name: 'receiver_conatct_2'
                        },
                        {
                            data: 'cod_amount',
                            name: 'cod_amount'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                });
            };

            $('#filter').click(function() {
                var from_date = $('#date_from').val();
                var to_date = $('#date_to').val();
                var branch_id = $('#branch_id').val();
                var seller_id = $('#seller_id').val();

                $('#table-data').DataTable().destroy();
                load_data(from_date, to_date, status, branch_id, seller_id);

            });
        </script>
    @endcan

    @can('order-collected.mark')
        <script>
            $('document').ready(function() {
                $('#scan_waybill').focus();
            });

            $('#btn-submit').click(function() {
                collect();
            });

            $('#scan_waybill').on('keyup', function() {
                package_details();
            });

            function package_details() {

                let waybill_id = $('#scan_waybill').val();

                $.ajax({
                    url: '{{ route('get_waybill_details') }}',
                    method: 'post',
                    data: {
                        waybill_id: waybill_id,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#user_data_form').trigger('reset');
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.package_details && data.seller_details && data.receiver_details && data
                            .order_details) {
                            $('#package_weight').val(data.package_details.package_weight);
                            $('#package_weight').attr('readonly', false);
                            $('#seller_name').val(data.seller_details.seller_name);
                            $('#cod').val(data.order_details.cod_amount);
                            $('#remark').val(data.order_details.remark);
                            $('#destination').val(data.receiver_details.receiver_address);

                            //district
                            if (data.receiver_details.receiver_district_id) {
                                $('#district_id').val(data.receiver_details.receiver_district_id);
                                $('#district_id').trigger('change');
                            } else {
                                $('#district_id').val('null');
                                $('#district_id').trigger('change');
                            }

                            //city
                            if (data.receiver_details.receiver_city_id) {
                                $('#city_id').val(data.receiver_details.receiver_city_id);
                                $('#city_id').trigger('change');
                            } else {
                                $('#city_id').val('null');
                                $('#city_id').trigger('change');
                            }

                        } else {
                            $('#package_weight').val('Invalid Waybill');
                            $('#package_weight').attr('readonly', true);
                            $('#seller_name').val('');
                            $('#cod').val('');

                            //district
                            $('#district_id').val('null');
                            $('#district_id').trigger('change');

                            //city
                            $('#city_id').val('null');
                            $('#city_id').trigger('change');
                        }

                    },
                    error: function(error) {
                        // console.log(error);
                        $('#package_weight').val('Invalid Waybill');
                        $('#package_weight').attr('readonly', true);
                        $('#seller_name').val('');
                        $('#cod').val('');

                        //district
                        $('#district_id').val('null');
                        $('#district_id').trigger('change');

                        //city
                        $('#city_id').val('null');
                        $('#city_id').trigger('change');

                    }
                });
            };

            function collect() {
                let waybill = $('#scan_waybill').val();
                let dis_id = $('#district_id').val();
                let city_id = $('#city_id').val();
                let weight = $('#package_weight').val();

                $.ajax({
                    url: '{{ route('dis_collected') }}',
                    method: 'post',
                    data: {
                        waybill_id: waybill,
                        city_id: city_id,
                        dis_id: dis_id,
                        weight: weight,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-submit').html('<i class="fa fa-spinner fa-spin"></i> loading...');
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.response == '0') {
                            notify('error', data.msg);

                            $('#btn-submit').html(
                                '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                            setTimeout(function() {
                                $('#btn-submit').html(
                                    'Mark as Collected');
                            }, 2000);
                            $('#scan_waybill').focus();

                            return;
                        }

                        $('#btn-submit').html(
                            '<i class="fa fa-check-circle" aria-hidden="true"></i> Save');
                        $('#scan_waybill').val('');
                        notify('success', 'Package Collected.');
                        $('#table-data').DataTable().destroy();
                        load_data();

                        setTimeout(function() {
                            $('#btn-submit').html('Mark as Collected');
                        }, 2000);

                    },
                    error: function(error) {
                        // console.log(error.responseJSON.exception);

                        notify('error', error.responseJSON.exception);
                        $('#btn-submit').html(
                            '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                        setTimeout(function() {
                            $('#btn-submit').html(
                                'Mark as Collected');
                        }, 2000);
                        $('#scan_waybill').focus();

                        return;
                    }
                });
            }
        </script>
    @endcan
@endsection
