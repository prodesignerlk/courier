@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Mark as return to Client </p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Waybill Id</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">Return</button>
                        </div>
                    </div>
                    <hr>
                    {{-- මෙහෙම ටිකක් තිබුනේ නැ 
                    හිස් ගතිය යන්න දැම්මේ  --}}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Customer Name</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Client Name</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Contact</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Address</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <p>Returned packages for Clients</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Returned Date</th>
                                    <th scope="col">Waybill ID</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Dilivery Address</th>
                                    <th scope="col">Mobile Number</th>
                                    <th scope="col">COD</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
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