@extends('layouts.dashboard.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Daily Deposite</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="daily-finance-table">
                        <thead>
                            <tr>
                                <th scope="col">Deposite Date</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Full Amount(LKR)</th>
                                <th scope="col">Expenses</th>
                                <th scope="col">Deposite Amount(LKR)</th>
                                <th scope="col">Remaining Amount(LKR)</th>
                                <th scope="col">Remark</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection