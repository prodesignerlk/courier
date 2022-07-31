@extends('layouts.dashboard.main')

@section('content')
    @php
    $user = Auth::user();
    @endphp
    @can('order-assign-to-agent.mark')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white action-header">
                        <p>Assign To Agent </p>
                    </div>
                    <div class="card-body action-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="">Waybill Id :</label>
                                <input type="text" name="" id="scan_waybill" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Assign to Rider :</label>
                                <select name="" id="staff_id" class="form-control js-example-basic-single">
                                    <option value="" disabled selected>Select Rider</option>
                                    @foreach ($active_riders as $rider)
                                        @php
                                            $staff_info = App\Models\User::find($rider->id)->staff;
                                            $branch_info = App\Models\Staff::find($staff_info->staff_id)->branch;
                                        @endphp
                                        {{-- value --->>>> staff_id --}}
                                        <option value="{{ $staff_info->staff_id }}">{{ $rider->name }}
                                            @if(isset($branch_info->branch_code)){{ ' - '.$branch_info->branch_code }} {{ $branch_info->branch_name }} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="button" class="btn btn-primary btn-block" id="btn-submit">Mark as Assign</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endcan

    @if ($user->can('order-assign-to-agent.search') && $user->can('order-assign-to-agent.view'))
        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white search-header">
                        <p>Filtering</p>
                    </div>
                    <div class="card-body search-body">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="">From :</label>
                                <input type="date" name="date_from" id="date_from" class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">To :</label>
                                <input type="date" name="date_to" id="date_to" class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Branch :</label>
                                <select name="branch_id" id="branch_id" class="form-control js-example-basic-single">
                                    <option value="">All Branches</option>
                                    @foreach ($branch_details as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_code }} -
                                            {{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Seller :</label>
                                <select name="seller_id" id="seller_id" class="form-control js-example-basic-single">
                                    <option value="">All Sellers</option>
                                    @foreach ($user_details as $user)
                                        @php
                                            $seller = $user->seller;
                                        @endphp
                                        <option value="{{ $seller->seller_id }}">{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Rider(Agent) :</label>
                                <select name="" id="staff_id" class="form-control js-example-basic-single">
                                    <option value="">All Riders</option>
                                    @foreach ($active_riders as $rider)
                                        @php
                                            $staff_info = App\Models\User::find($rider->id)->staff;
                                            $branch_info = App\Models\Staff::find($staff_info->staff_id)->branch;
                                        @endphp
                                        {{-- value --->>>> staff_id --}}
                                        <option value="{{ $staff_info->staff_id }}">{{ $rider->name }}
                                            @if(isset($branch_info->branch_code)){{ ' - '.$branch_info->branch_code }} {{ $branch_info->branch_name }} @endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-block" id="filter">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif

    @can('order-assign-to-agent.view')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <p>Dispatched Packages </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="table-data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Assigned Date</th>
                                        <th scope="col">Final Rider</th>
                                        <th scope="col">Waybill ID</th>
                                        <th scope="col">Branch</th>
                                        <th scope="col">Seller</th>
                                        <th scope="col">Receiver</th>
                                        <th scope="col">Delivery Address</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Mobile (Secondary)</th>
                                        <th scope="col">COD (LKR)</th>
                                        <th scope="col">Attempt</th>
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

            function load_data(from_date, to_date, branch_id, seller_id, staff_id) {
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
                        url: '{{ route('hand_assign_to_agent_orders_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            branch_id: branch_id,
                            seller_id: seller_id,
                            staff_id: staff_id
                        }
                    },
                    columns: [{
                            data: 'assign_date',
                            name: 'assign_date'
                        },
                        {
                            data: 'rider_name',
                            name: 'rider_name'
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
                            data: 'receiver_contact_2',
                            name: 'receiver_contact_2'
                        },
                        {
                            data: 'cod_amount',
                            name: 'cod_amount'
                        },
                        {
                            data: 'attemp',
                            name: 'attemp'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                });
            };

            $('#filter').click(function() {
                let from_date = $('#date_from').val();
                let to_date = $('#date_to').val();
                let branch_id = $('#branch_id').val();
                let seller_id = $('#seller_id').val();
                let staff_id = $('#staff_id').val();

                $('#table-data').DataTable().destroy();
                load_data(from_date, to_date, branch_id, seller_id, staff_id);

            });
        </script>
    @endcan

    @can('order-assign-to-agent.mark')
        <script>
            $('document').ready(function() {
                $('#scan_waybill').focus();
            });

            $('#btn-submit').click(function() {
                assign();
            });

            function assign() {
                let waybill = $('#scan_waybill').val();
                let staff_id = $('#staff_id').val();
                $.ajax({
                    url: '{{ route('hand_assign_to_agent') }}',
                    method: 'post',
                    data: {
                        waybill_id: waybill,
                        staff_id:staff_id,
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
                                    'Mark as Received');
                            }, 2000);
                            $('#scan_waybill').focus();

                            return;
                        }

                        $('#btn-submit').html(
                            '<i class="fa fa-check-circle" aria-hidden="true"></i> Save');
                        $('#scan_waybill').val('');

                        notify('success', 'Package Assined.');
                        $('#table-data').DataTable().destroy();
                        load_data();

                        //reset rider
                        $('#staff_id').val('');
                        $('#staff_id').trigger('change');

                        setTimeout(function() {
                            $('#btn-submit').html('Mark as Assined');
                        }, 2000);

                    },
                    error: function(error) {
                        // console.log(error.responseJSON.exception);

                        notify('error', error.responseJSON.exception);
                        $('#btn-submit').html(
                            '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                        setTimeout(function() {
                            $('#btn-submit').html(
                                'Mark as Assined');
                        }, 2000);
                        $('#scan_waybill').focus();

                        return;
                    }
                });
            }
        </script>
    @endcan
@endsection
