@extends('layouts.dashboard.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>ADvanced Search</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Date From</label>
                            <input type="text" name="" id="from" name="from" class="form-control">
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Date To</label>
                            <input type="text" name="" id="to" name="to" class="form-control">
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Client</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select Client</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Status</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select Status</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Payable Finance</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="daily-finance-table">
                        <thead>
                            <tr>
                                <th scope="col">Invoice ID</th>
                                <th scope="col">Invoice Date</th>
                                <th scope="col">Client</th>
                                <th scope="col">COD(LKR)</th>
                                <th scope="col">Delivery Charge(LKR)</th>
                                <th scope="col">Handling Charge(LKR)</th>
                                <th scope="col">Payable Amount(LKR)</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Package Count</th>
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
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
</script>
@endsection