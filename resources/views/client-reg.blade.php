@extends('layouts.dashboard.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Client Registration</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Web Store</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Name of Web Store">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Username</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Client Username">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Contact</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <p>Address</p>
                    <div class="form-row">
                        <div class="form-group col-md-4 col-sm-12">
                            <input type="text" name="" id="" class="form-control" placeholder="Address Line">
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select City</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 col-sm-12">
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select District</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <p>Select Payment Methord</p>
                    <div class="form-row" id="selectable">
                        <div class="form-group col-md-3 col-sm-6 ">
                            <div class="card ui-widget-content bg-transparent border border-primary">
                                <div class="card-body">
                                    <h4>After 3 days</h4>
                                    <h6><span class="badge badge-primary pl-3 pr-3 border border-light">(+3%)</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3 col-sm-6 ">
                            <div class="card ui-widget-content bg-transparent border border-primary">
                                <div class="card-body">
                                    <h4>After 7 days</h4>
                                    <h6><span class="badge badge-primary pl-3 pr-3 border border-light">(+1%)</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3 col-sm-6 ">
                            <div class="card ui-widget-content bg-transparent border border-primary">
                                <div class="card-body">
                                    <h4>After 15 days</h4>
                                    <h6><span class="badge badge-primary pl-3 pr-3 border border-light">(+0%)</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3 col-sm-6 ">
                            <div class="card ui-widget-content bg-transparent border border-primary">
                                <div class="card-body">
                                    <h4>After 30 days</h4>
                                    <h6><span class="badge badge-primary pl-3 pr-3 border border-light">(+0%)</span></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Bank Name</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Branck</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Enter Branch">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Account Number</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Enter Account Number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Login Email</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Password</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Morethan 5 Character">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Confirm Password</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Confirm">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $( function() {
      $( "#selectable" ).selectable();
      
    } );
</script>
@endsection