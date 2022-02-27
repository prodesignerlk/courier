@extends('layouts.dashboard.main')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <p>Add Daily Finance</p>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Branch</label>
                            <select name="" id="" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select Branch</option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Deposite</label>
                            <input type="text" name="" id="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Date From</label>
                            <input type="text" name="" id="from" name="from" class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="">Date To</label>
                            <input type="text" name="" id="to" name="to" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 col-sm-12">
                            <label for="">Description</label>
                            <textarea name="" id="" rows="5" class="form-control"></textarea>
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
                                <th scope="col">Payable Date</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Total COD(LKR)</th>
                                <th scope="col">Payed Amount(LKR)</th>
                                <th scope="col">Payable Amount(LKR)</th>
                                <th scope="col">Expenses</th>
                                <th scope="col">Orders</th>
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