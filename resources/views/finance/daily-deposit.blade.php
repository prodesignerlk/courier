@extends('layouts.dashboard.main')

@section('content')
    @php
        /** @var App\Models\User $user*/
        $user = \Illuminate\Support\Facades\Auth::user();
    @endphp

    @if ($user->can('daily-deposit.search') && $user->can('daily-deposit.view'))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white search-header">
                        <p>Filtering</p>
                    </div>
                    <div class="card-body search-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">From :</label>
                                <input type="date" name="date_from" id="date_from" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">To :</label>
                                <input type="date" name="date_to" id="date_to" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Branch :</label>
                                <select name="branch_id" id="branch_id" class="form-control js-example-basic-single">
                                    <option value="">All Branches</option>
                                    @foreach ($branch_details as $branch)
                                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_code }}
                                            - {{$branch->branch_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="">Payment Status</label>
                                <select name="payment_status" id="payment_status"
                                        class="form-control js-example-basic-single">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1">Paid</option>
                                    <option value="0">Unpaid</option>
                                    <option value="2">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary btn-block" id="filter">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif

    @can('daily-deposit.view')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Daily Deposit</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="table-data" style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">Deposited Date</th>
                                    <th scope="col">Bill Date</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Full Amount(LKR)</th>
                                    <th scope="col">Deposit Amount(LKR)</th>
                                    <th scope="col">Remaining Amount(LKR)</th>
                                    <th scope="col">Remark</th>
                                    <th scope="col">Package Count</th>
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
                        url: '{{ route('daily_deposit_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            payment_status: payment_status,
                            branch_id: branch_id
                        }
                    },
                    columns: [
                        {
                            data: 'payed_date',
                            name: 'payed_date'
                        },
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
                            data: 'remaining',
                            name: 'remaining'
                        },
                        {
                            data: 'remark',
                            name: 'remark'
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

    @can('daily-deposit.confirm')
        <script>
            $('body').on('click', '.btn-payment-confirm', function (e) {
                var deposit_id = $(this).attr('data-id');
                confirmation(deposit_id);
            });

            function confirmation(deposit_id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#29ad03',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Confirm it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Payment Confirm!',
                            'This recode conform successful.',
                            'success'
                        );
                    }
                })
            }

            function payment_confirm(deposit_id){
                $.ajax({
                    url: '{{ route('confirm_deposit') }}',
                    method: 'post',
                    data: {
                        deposit_id: deposit_id,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend:function (){
                        $('#table-data').DataTable().destroy();
                    },
                    success:function (){
                        notify('success', 'Payment Confirmed.');
                        load_data();
                    },
                    error:function (error){
                        // console.log(error);
                        notify('error', error.responseJSON.exception);
                        load_data();
                    }
                });
            }
        </script>
    @endcan
@endsection
