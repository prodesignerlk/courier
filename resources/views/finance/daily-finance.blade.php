@extends('layouts.dashboard.main')

@section('content')
    @can('daily-invoice.mark')
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
                                    <label for="">Branch<span class="text-danger">*</span></label>
                                    <select name="" id="branch_id" class="form-control js-example-basic-single">
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach($branch_details as $branch)
                                            <option value="{{$branch->branch_id}}">{{$branch->branch_code}}
                                                - {{$branch->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="">Deposit Amount<span class="text-danger">*</span></label>
                                    <input type="text" name="" id="amount" class="form-control" placeholder="LKR">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="">Date Range/ Date<span class="text-danger">*</span></label>
                                    <input type="text" name="daterange" id="date" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 col-sm-12">
                                    <label for="">Description</label>
                                    <textarea name="" id="description" rows="5" class="form-control" placeholder="(Optional)"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3 col-sm-12">
                                    <button type="button" class="btn btn-primary btn-block" id="btn-submit">Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endcan

    @can('daily-invoice.view')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Payable Finance</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="table-data" style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">Bill Date</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Total COD(LKR)</th>
                                    <th scope="col">Payed Amount(LKR)</th>
                                    <th scope="col">Payable Amount(LKR)</th>
                                    <th scope="col">Orders Qty</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('document').ready(function () {
                load_data();
            });

            function load_data(from_date, to_date, branch_id, payment_status) {
                $('#table-data').DataTable({
                    drawCallback: function () {
                        feather.replace();
                    },
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 50, 100, 500, 1000, 5000, -1],
                        ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows', '5000 rows', 'Show all']
                    ],
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
                    ],
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('daily_finance_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            payment_status: payment_status,
                            branch_id: branch_id
                        }
                    },
                    columns: [
                        {
                            data: 'bill_date',
                            name: 'bill_date'
                        },
                        {
                            data: 'branch_name',
                            name: 'branch_name'
                        },
                        {
                            data: 'total_cod_amount',
                            name: 'total_cod_amount'
                        },
                        {
                            data: 'payed_amount',
                            name: 'payed_amount'
                        },
                        {
                            data: 'payable',
                            name: 'payable'
                        },
                        {
                            data: 'order_count',
                            name: 'order_count'
                        },
                        {
                            data: 'pay_status',
                            name: 'pay_status'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ],
                });
            };

            $('#filter').click(function () {
                let from_date = $('#date_from').val();
                let to_date = $('#date_to').val();
                let payment_status = $('#payment_status').val();
                let branch_id = $('#seller_id').val();

                $('#table-data').DataTable().destroy();
                load_data(from_date, to_date, branch_id, payment_status);

            });
        </script>
    @endcan

    @can('daily-invoice.mark')
        <script>
            let dateFrom;
            let dateTo;
            $('#btn-submit').click(function () {
                deposit();
            });

            function deposit() {
                let branch_id = $('#branch_id').val();
                let amount = $('#amount').val();
                let description = $('#description').val();
                let from = dateFrom;
                let to = dateTo;
                $.ajax({
                    url: '{{ route('daily_finance_deposit') }}',
                    method: 'post',
                    data: {
                        branch_id: branch_id,
                        amount: amount,
                        from: from,
                        to: to,
                        description: description,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#btn-submit').html('<i class="fa fa-spinner fa-spin"></i> loading...');
                    },
                    success: function (data) {
                        // console.log(data);
                        if (data.response == 0) {
                            notify('error', data.msg);

                            $('#btn-submit').html(
                                '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                            setTimeout(function () {
                                $('#btn-submit').html(
                                    'Submit');
                            }, 2000);
                            $('#amount').focus();

                            return;
                        }

                        $('#btn-submit').html(
                            '<i class="fa fa-check-circle" aria-hidden="true"></i> Save'
                        );

                        notify('success', 'Package Collected.');
                        $('#table-data').DataTable().destroy();
                        load_data();

                        setTimeout(function () {
                            $('#btn-submit').html('Submit');
                        }, 2000);

                    },
                    error: function (error) {
                        // console.log(error.responseJSON.exception);

                        notify('error', error.responseJSON.exception);
                        $('#btn-submit').html(
                            '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                        setTimeout(function () {
                            $('#btn-submit').html(
                                'Submit');
                        }, 2000);

                    }
                });
            }
        </script>
    @endcan

    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                dateFrom = start.format('YYYY-MM-DD');
                dateTo = end.format('YYYY-MM-DD');
            });
        });

        $(document).ready(function (){
            var date = $('#date').val();
            dateFrom = date.slice(0, 10);
            dateTo = date.slice(12, 23);
        });

    </script>
@endsection
