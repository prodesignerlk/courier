@extends('layouts.dashboard.main')

@section('content')
    @can('order.search')
        <div class="form-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Filtering</p>
                    </div>
                    <div class="card-body">

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
                                <label for="">Status :</label>
                                <select name="status" id="status" class="form-control js-example-basic-single">
                                    <option value=''>Select All</option>
                                    @foreach ($status_details as $status)
                                        <option value="{{ $status->order_status_id }}">{{ $status->status }}</option>
                                    @endforeach
                                </select>
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
                            @if (!(Auth::user()->branch_staff))
                                <div class="form-group col-md-3">
                                    <label for="">Seller :</label>
                                    <select name="seller_id" id="seller_id" class="form-control js-example-basic-single">
                                        <option value="null" selected disabled>All Sellers</option>
                                        @foreach ($user_details as $user)
                                            @php
                                                $seller = $user->seller;
                                            @endphp
                                            <option value="{{ $seller->seller_id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
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
    @can('order.view')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Orders</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="my-order-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Status Date</th>
                                        <th scope="col">Waybill ID</th>
                                        <th scope="col">Pickup Branch</th>
                                        <th scope="col">Branch</th>
                                        <th scope="col">Seller</th>
                                        <th scope="col">Receiver</th>
                                        <th scope="col">Delivery Address</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Mobile (Secondary)</th>
                                        <th scope="col">COD (LKR)</th>
                                        <th scope="col">Status</th>
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

    <!-- Modal -->
    <div class="modal fade" id="modalone" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Body
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->


    <script>
        $('document').ready(function() {
            load_data();
        });

        function load_data(from_date, to_date, status, branch_id, seller_id) {
            $('#my-order-table').DataTable({
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
                    url: '{{ route('my_order_data_table') }}',
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        status: status,
                        branch_id: branch_id,
                        seller_id: seller_id
                    }
                },
                columns: [{
                        data: 'date',
                        name: 'date'
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
        }

        $('#filter').click(function() {
            let from_date = $('#date_from').val();
            let to_date = $('#date_to').val();
            let status = $('#status').val();
            let branch_id = $('#branch_id').val();
            let seller_id = $('#seller_id').val();

            console.log(status);
            $('#my-order-table').DataTable().destroy();
            load_data(from_date, to_date, status, branch_id, seller_id);

        });
    </script>

@endsection
