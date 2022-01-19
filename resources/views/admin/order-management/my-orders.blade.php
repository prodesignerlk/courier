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
                <div class="table-resposive">
                    <table class="table table-bordered" id="datatable-basic">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection