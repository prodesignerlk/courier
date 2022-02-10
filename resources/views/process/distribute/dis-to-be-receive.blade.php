@extends('layouts.dashboard.main')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>To be Receive Packages </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-basic">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Dispatched Date</th>
                                <th scope="col">Waybill ID</th>
                                <th scope="col">Pickup Branch</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">COD</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection