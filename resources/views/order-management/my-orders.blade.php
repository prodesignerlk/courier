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
                    <table class="table table-bordered" id="datatable-basic">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Waybill ID</th>
                                <th scope="col">Pickup Branch</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Seller</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Delivery Address</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">COD</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>2021 Jan 29</td>
                                <td>CAS3203000303</td>
                                <th>Kelaniya</th>
                                <th>Ambalantota</th>
                                <td>Sajana Karunarathne</td>
                                <td>Ayesh Nawawickrama</td>
                                <td>137/1 Malpeththawa, Ambalantota</td>
                                <td>0779389533</td>
                                <th>2949</th>
                                <th><span class="badge badge-danger">Dispatched</span></th>
                                <td>
                                    <button type="button" class="btn btn-success btn-icon btn-email" data-email="#" data-toggle="tooltip" data-placement="top" title="View">
                                        <i data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-icon btn-email" data-email="#" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i data-feather="edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>2021 Jan 29</td>
                                <td>CAS3203000303</td>
                                <th>Kelaniya</th>
                                <th>Ambalantota</th>
                                <td>Sajana Karunarathne</td>
                                <td>Ayesh Nawawickrama</td>
                                <td>137/1 Malpeththawa, Ambalantota</td>
                                <td>0779389533</td>
                                <th>2949</th>
                                <th><span class="badge badge-danger">Dispatched</span></th>
                                <td>
                                    <button type="button" class="btn btn-success btn-icon btn-email" data-email="#" data-toggle="tooltip" data-placement="top" title="View">
                                        <i data-feather="eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-icon btn-email" data-email="#" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i data-feather="edit"></i>
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