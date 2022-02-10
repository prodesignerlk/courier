@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Mark as collected</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Waybill Id</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Weight (kg)</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">District</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">City</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">Collect</button>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Client Name</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Customer Name</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">District</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">City</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Address</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Customer Contact</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Ammount</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Description</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Remark</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
    <div class="col-mt-8">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <p>Collected Packages </p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Collected Date</th>
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
</div>
@endsection