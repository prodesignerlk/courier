@extends('layouts.dashboard.main')

@section('content')
    @php
    $user = Auth::user();
    @endphp
    @can('pickup-dispatched.mark')
        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Mark as Pick-ups Dispatched</p>
                    </div>
                    <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <input type="text" name="" id="scan_waybill" class="form-control"
                                        placeholder="Scan barcode or enter waybill id">
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="button" class="btn btn-primary btn-block" id='btn-submit'>Mark as Dispatched</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endcan

    @if ($user->can('pickup-dispatch.search') && $user->can('pickup-dispatch.view'))
        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Filtering</p>
                    </div>
                    <div class="card-body">
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
                                        <option value="{{ $seller->seller_id }}">{{ $seller->seller_name }}</option>
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
    @endif

    @can('pickup-dispatched.view')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Pick-ups Dispatched Orders </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-data">
                                <thead>
                                    <tr>
                                        <th scope="col">Pickup Dispatched Date</th>
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
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('pick_up_dispatched_orders_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            branch_id: branch_id,
                            seller_id: seller_id
                        }
                    },
                    columns: [{
                            data: 'st_3_at',
                            name: 'st_3_at'
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
    @can('pickup-dispatched.mark')
        <script>
            $('document').ready(function() {
                $('#scan_waybill').focus();
            });

            $('#btn-submit').click(function() {
                dispatched();
            });

            $('#scan_waybill').keypress(function(e) {
                if (e.which == 13) {
                    dispatched();
                }
            });

            function dispatched() {
                let waybill = $('#scan_waybill').val();
                $.ajax({
                    url: '{{ route('pickup_dispatched') }}',
                    method: 'post',
                    data: {
                        waybill_id: waybill,
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
                                    'Mark as Dispatched');
                            }, 2000);
                            $('#scan_waybill').focus();

                            return;
                        }

                        $('#btn-submit').html(
                            '<i class="fa fa-check-circle" aria-hidden="true"></i> Save');
                        $('#scan_waybill').val('');
                        notify('success', 'Package Dispatched.');
                        $('#table-data').DataTable().destroy();
                        load_data();

                        setTimeout(function() {
                            $('#btn-submit').html('Mark as Dispatched');
                        }, 2000);

                    },
                    error: function(error) {
                        // console.log(error.responseJSON.exception);

                        notify('error', error.responseJSON.exception);
                        $('#btn-submit').html(
                            '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                        setTimeout(function() {
                            $('#btn-submit').html(
                                'Mark as Dispatched');
                        }, 2000);
                        $('#scan_waybill').focus();

                        return;
                    }
                });
            }
        </script>
    @endcan

@endsection
