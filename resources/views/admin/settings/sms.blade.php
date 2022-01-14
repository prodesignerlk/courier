@extends('layouts.dashboard.main')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>SMS Configuration</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">SMS Gateway :</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                                <option value="">Lanka Bell</option>
                                <option value="">Dialog</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">API Key :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">API Secret :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">From Number :</label>
                            <input type="number" name="" id="" class="form-control">
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
                <p>Test SMS</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">To (number) :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Message :</label>
                            <textarea class="form-control" name="" id="" cols="30" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection