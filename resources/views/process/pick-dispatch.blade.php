@extends('layouts.dashboard.main')

@section('content')
<div class="form-row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Mark as Pick-ups Dispatched</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <input type="text" name="" id="" class="form-control" placeholder="Scan barcode or enter waybill id">
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary btn-block">Dispatched Package</button>
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
                <p>Dispatched Orders </p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-basic">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Waybill ID</th>
                                <th scope="col">Pickup Branch</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Dilivery Address</th>
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