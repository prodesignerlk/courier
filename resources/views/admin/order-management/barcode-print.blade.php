@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Filtering</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <form action="" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">Order Date :</label>
                                <input type="date" name="" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Status :</label>
                                <select name="" id="" class="form-control js-example-basic-single">
                                    <option value="" disabled selected>Select...</option>
                                    <option value="">Pending</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Branch :</label>
                                <select name="" id="" class="form-control js-example-basic-single">
                                    <option value="" disabled selected>Select...</option>
                                    <option value="">Ambalantota</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Seller :</label>
                                <select name="" id="" class="form-control js-example-basic-single">
                                    <option value="" disabled selected>Select...</option>
                                    <option value="">Ayesh Nawawickrama</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="text-white" for="">.</label>
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Print Barcodes</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable-basic">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Waybill ID</th>
                                <th scope="col">Seller</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>2021 Jan 29</td>
                                <td>CAS3203000303</td>
                                <td>Sajana Karunarathne</td>
                                <td>Ayesh Nawawickrama</td>
                                <td>137/1 Malpeththawa, Ambalantota</td>
                                <td>0779389533</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-icon btn-email" data-email="#" data-toggle="tooltip" data-placement="top" title="View">
                                        <i data-feather="printer"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>2021 Jan 29</td>
                                <td>CAS3203000303</td>
                                <td>Sajana Karunarathne</td>
                                <td>Ayesh Nawawickrama</td>
                                <td>137/1 Malpeththawa, Ambalantota</td>
                                <td>0779389533</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-icon btn-email" data-email="#" data-toggle="tooltip" data-placement="top" title="Print">
                                        <i data-feather="printer"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection