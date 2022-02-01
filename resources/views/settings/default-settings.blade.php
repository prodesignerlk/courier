@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Rates</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Delevery Rate (1kg)</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Extra Rate (1kg)</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Handling Rate (1kg)</label>
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
    </div>
    <div class="row mt-8">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <p>Rate History</p>
                </div>
                <div class="card-body">
                    <div class="table-resposnive">
                        <table class="table table-bordered" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Delevery Rate (1kg)</th>
                                    <th scope="col">Extra Rate (1kg)</th>
                                    <th scope="col">Handling Rate (1kg)</th>
                                    <th scope="col">Added Date</th>
                                    <th scope="col">Changed Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>300</td>
                                    <td>80</td>
                                    <td>1</td>
                                    <td>2021 January 10</td>
                                    <td>2021 January 20</td>    
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>300</td>
                                    <td>80</td>
                                    <td>1</td>
                                    <td>2021 January 10</td>
                                    <td>2021 January 20</td>    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection