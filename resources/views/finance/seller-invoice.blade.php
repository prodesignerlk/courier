@extends('layouts.dashboard.main')

@section('content')
    @php
        /** @var App\Models\User $user*/
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp

    @if ($user->can('invoice.search') && $user->can('invoice.view'))
        <div class="row">
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
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="">Payment Status</label>
                                <select name="payment_status" id="payment_status"
                                        class="form-control js-example-basic-single">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1">Paid</option>
                                    <option value="0">Unpaid</option>
                                    <option value="2">Pending</option>
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

    @can('invoice.view')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Payable Finance</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="table-data" style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">Invoice ID</th>
                                    <th scope="col">Invoice Date</th>
                                    <th scope="col">Seller</th>
                                    <th scope="col">Total COD(LKR)</th>
                                    <th scope="col">Delivery Charge(LKR)</th>
                                    <th scope="col">Handling Charge(LKR)</th>
                                    <th scope="col">Payable Amount(LKR)</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Package Count</th>
                                    <th scope="col">Total Weight(Kg)</th>
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
            $('document').ready(function () {
                load_data();
            });

            function load_data(from_date, to_date, seller_id, payment_status) {
                $('#table-data').DataTable({
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
                        url: '{{ route('seller_invoice_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            payment_status: payment_status,
                            seller_id: seller_id
                        }
                    },
                    columns: [
                        {
                            data: 'invoice_id',
                            name: 'invoice_id'
                        },
                        {
                            data: 'invoice_date',
                            name: 'invoice_date'
                        },
                        {
                            data: 'seller_name',
                            name: 'seller_name'
                        },
                        {
                            data: 'total_cod_amount',
                            name: 'total_cod_amount'
                        },
                        {
                            data: 'total_delivery_fee',
                            name: 'total_delivery_fee'
                        },
                        {
                            data: 'handling_free',
                            name: 'handling_free'
                        },
                        {
                            data: 'total_payable',
                            name: 'total_payable'
                        },
                        {
                            data: 'pay_status',
                            name: 'pay_status'
                        },
                        {
                            data: 'package_count',
                            name: 'package_count'
                        },
                        {
                            data: 'total_weight',
                            name: 'total_weight'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                });
            };

            $('#filter').click(function () {
                let from_date = $('#date_from').val();
                let to_date = $('#date_to').val();
                let payment_status = $('#payment_status').val();
                let seller_id = $('#seller_id').val();

                $('#table-data').DataTable().destroy();
                load_data(from_date, to_date, seller_id, payment_status);

            });
        </script>
    @endcan
@endsection
