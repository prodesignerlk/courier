@extends('layouts.dashboard.main')

@section('content')
    @php
    $user = Auth::user();
    @endphp
    @can('order-dispatched.mark')
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Mark as dispatched</p>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Waybill Id</label>
                                <input type="text" name="" id="scan_waybill" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Branch</label>
                                {{-- <input type="text" name="" id="branch_id" class="form-control"> --}}
                                <select name="" id="branch_id" class="form-control js-example-basic-single">
                                    <option value="null" selected disabled>Select Branch</option>
                                    @foreach ($all_branch as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_code }} -
                                            {{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="button" class="btn btn-primary btn-block" id="btn-submit">Dispatch Package</button>
                            </div>
                        </div>
                        <hr>
                        <form action="" id="user_data_form">
                            <div class="form-group col-md-12">
                                <label for="">District</label>
                                <input type="text" name="" id="district_id" class="form-control" placeholder="District"
                                    value="" readonly>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">City</label>
                                <input type="text" name="" id="city_id" class="form-control" placeholder="City" value=""
                                    readonly>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan

        @if ($user->can('order-dispatched.search') && $user->can('order-dispatched.view'))
            <div class="col-md-8">
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
                                    <select name="branch_id" id="branch_id" class="form-control js-example-basic-single">
                                        <option value="null" selected disabled>All Branches</option>
                                        @foreach ($branch_details as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_code }} -
                                                {{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="">Seller :</label>
                                    <select name="seller_id" id="seller_id" class="form-control js-example-basic-single">
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
                <br>
        @endif

        @can('order-dispatched.view')

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <p>Dispatched Packages </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-data">
                                <thead>
                                    <tr>
                                        <th scope="col">Dispatched Date</th>
                                        <th scope="col">Waybill ID</th>
                                        <th scope="col">Branch</th>
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
                        url: '{{ route('dis_dispatched_orders_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            branch_id: branch_id,
                            seller_id: seller_id
                        }
                    },
                    columns: [{
                            data: 'st_5_at',
                            name: 'st_5_at'
                        },
                        {
                            data: 'waybill_id',
                            name: 'waybill_id'
                        },
                        {
                            data: 'branch',
                            name: 'branch'
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
                dispatched();
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
                        $('#branch_id').removeAttr('readonly', true);
                    },
                    success: function(data) {
                        // console.log(data.district_details);
                        if (data.district_details && data.city_details) {
                            //district
                            if (data.district_details.district_name) {
                                $('#district_id').val(data.district_details.district_name);
                            } else {
                                $('#district_id').val('Invalid');
                                $('#branch_id').attr('readonly', true);
                            }
                            //city
                            if (data.city_details.city_name) {
                                $('#city_id').val(data.city_details.city_name);
                            } else {
                                $('#city_id').val('Invalid');
                                $('#branch_id').attr('readonly', true);
                            }
                        } else {
                            $('#branch_id').attr('readonly', true);
                            //district
                            $('#district_id').val('Invalid');
                            //city
                            $('#city_id').val('Invalid');
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                        $('#branch_id').attr('readonly', true);
                        //district
                        $('#district_id').val('Invalid');
                        //city
                        $('#city_id').val('Invalid');
                    }
                });
            };

            function dispatched() {
                let waybill = $('#scan_waybill').val();
                let branch_id = $('#branch_id').val();

                $.ajax({
                    url: '{{ route('dis_dispatched') }}',
                    method: 'post',
                    data: {
                        waybill_id: waybill,
                        branch_id: branch_id,
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

                        $('#branch_id').val('null');
                        $('#district_id').trigger('change');

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
