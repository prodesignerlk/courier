@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Create Order</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Waybill :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Client :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Customer Name :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Contact Number :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Address :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">District :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">Hambantota</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">City :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">Ambalantota</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Order Description :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">COD Amount :</label>
                            <input type="number" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Pickup Branch :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">Ambalantota</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Order remarks :</label>
                            <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Create Order</button>
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
                <p>Add Bulk Orders (Upload Excel)</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="alert alert-info" role="alert">
                                You can download sample format of excel sheet <a href="#">HERE</a>. Make sure the format should be .xls or .xslx.
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="">Pickup Branch :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">Ambalantota</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Upload Excel</label>
                            <input type="file" class="form-control-file" name="" id="" placeholder="Upload file" aria-describedby="fileHelpId">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection