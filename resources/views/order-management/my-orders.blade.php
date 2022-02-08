@extends('layouts.dashboard.main')

@section('content')
<div class="form-row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Filtering</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">From :</label>
                            <input type="date" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">To :</label>
                            <input type="date" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Status :</label>
                            <select name="" id="" class="form-control js-example-basic-multiple" multiple>
                                <option value="" selected>All</option>
                                <option value="">Ayesh Nawawickrama</option>
                                <option value="">COD</option>
                                <option value="">CCP</option>
                                <option value="">CRE</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Branch :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" selected>All</option>
                                <option value="">Ayesh Nawawickrama</option>
                                <option value="">COD</option>
                                <option value="">CCP</option>
                                <option value="">CRE</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Client :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" selected>All</option>
                                <option value="">Ayesh Nawawickrama</option>
                                <option value="">COD</option>
                                <option value="">CCP</option>
                                <option value="">CRE</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
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
                <p>Orders</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="my-order-table">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Waybill ID</th>
                                <th scope="col">Pickup Branch</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Seller</th>
                                <th scope="col">Customer</th>
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
@stop

@push('scripts')
    <script>
        $(function() {
            $('#my-order-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('my_order_data_table') }}",

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
                        data: 'status',
                        name: 'status'
                    },                   
                    
                ]
            });

        });
    </script>

@endpush