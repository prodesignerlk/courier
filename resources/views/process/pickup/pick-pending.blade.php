@extends('layouts.dashboard.main')

@section('content')
    @can('pickup-pending.search')
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
                                <select name="branch_id" id="branch_id" class="form-control js-example-basic-single">
                                    <option value="">All Branches</option>
                                    @foreach ($branch_details as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_code }} -
                                            {{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Seller :</label>
                                <select name="seller_id" id="seller_id" class="form-control js-example-basic-single">
                                    <option value="">All Sellers</option>
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
    @endcan

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>Pendings</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display" id="pending-order" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Order Date</th>
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
            $('#pending-order').DataTable({
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
                    url: '{{ route('pick_up_pending_orders_data_table') }}',
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        branch_id: branch_id,
                        seller_id: seller_id
                    }
                },
                columns: [{
                        data: 'st_1_at',
                        name: 'st_1_at'
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
            let from_date = $('#date_from').val();
            let to_date = $('#date_to').val();
            let branch_id = $('#branch_id').val();
            let seller_id = $('#seller_id').val();

            $('#pending-order').DataTable().destroy();
            load_data(from_date, to_date, branch_id, seller_id);

        });
    </script>
@endsection
