@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Waybill Reservation</p>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="">Waybill Type :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">CAS</option>
                                <option value="">COD</option>
                                <option value="">CCP</option>
                                <option value="">CRE</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Client :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">Ayesh Nawawickrama</option>
                                <option value="">COD</option>
                                <option value="">CCP</option>
                                <option value="">CRE</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Reserve from :</label>
                            <input type="number" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Reserve to :</label>
                            <input type="number" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Reserve waybill</button>
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
                <p>Reserved Waybills</p>
            </div>
            <div class="card-body">
                <div class="table-resposive">
                    <table class="table table-bordered" id="datatable-basic">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Reserved Date</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>2021 Jan 23</td>
                                <td>Ayesh Nawawickrama</td>
                                <td>1</td>
                                <td>1300</td>
                                <td>1300</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>2021 Jan 23</td>
                                <td>Ayesh Nawawickrama</td>
                                <td>1</td>
                                <td>1300</td>
                                <td>1300</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>2021 Jan 23</td>
                                <td>Ayesh Nawawickrama</td>
                                <td>1</td>
                                <td>1300</td>
                                <td>1300</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection