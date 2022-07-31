@extends('layouts.dashboard.main')

@section('content')
    @php
    $user = Auth::user();
    @endphp

    @if ($user->can('order-miss-route.search') && $user->can('order-miss-route.view'))
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
                                        <option value="{{ $seller->seller_id }}">{{ $user->name }}
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

    @can('order-miss-route.view')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <p>Miss Route</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="table-data" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Received Date</th>
                                        <th scope="col">Waybill ID</th>
                                        <th scope="col">Branch</th>
                                        <th scope="col">Received Branch</th>
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
                        url: '{{ route('hand_miss_route_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            branch_id: branch_id,
                            seller_id: seller_id,
                            staff_id: staff_id
                        }
                    },
                    columns: [{
                            data: 'st_6_at',
                            name: 'st_6_at'
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
                            data: 'received_branch',
                            name: 'received_branch'
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
                let staff_id = $('#staff_id').val();

                $('#table-data').DataTable().destroy();
                load_data(from_date, to_date, branch_id, seller_id, staff_id);

            });
        </script>
    @endcan
@endsection
