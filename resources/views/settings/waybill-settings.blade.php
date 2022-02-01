@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Waybill Type</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Name</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Description :</label>
                            <textarea class="form-control" name="" id="" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Waybill Start</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Name</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        {{-- table  --}}
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <p>Starting With</p>
            </div>
            <div class="card-body">
                <div class="table-resposnive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">219045</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Reservation Type</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Select Type :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">Auto Increment</option>
                                <option value="">Quentity</option>
                                <option value="">Range</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        {{-- table  --}}
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <p>Selected Type</p>
            </div>
            <div class="card-body">
                <div class="table-resposnive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Range</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <p>Added Waybill Type</p>
            </div>
            <div class="card-body">
                <div class="table-resposnive">
                    <table class="table table-bordered" id="datatable-basic">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>COD</td>
                                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
                                <td><a href="#" class="badge badge-primary">Edit</a></td>
                                <td><a href="#" class="badge badge-danger">Delete</a></td>

                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>COD</td>
                                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
                                <td><a href="#" class="badge badge-primary">Edit</a></td>
                                <td><a href="#" class="badge badge-danger">Delete</a></td>

                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>COD</td>
                                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
                                <td><a href="#" class="badge badge-primary">Edit</a></td>
                                <td><a href="#" class="badge badge-danger">Delete</a></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection