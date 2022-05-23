@extends('layouts.dashboard.main')

@section('content')
    @php
    $user = Auth::user();
    @endphp

    @can('order-re-route.view')
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Mark as Re-Route </p>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Waybill Id</label>
                                <input type="text" name="" id="scan_waybill" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary btn-block" id="btn-submit">Make Re-Route</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <p>Re-Route Packages </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered display" id="table-data" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Re-route Date</th>
                                            <th scope="col">Waybill ID</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('document').ready(function() {
                load_data();
            });

            function load_data(from_date, to_date, branch_id, seller_id, staff_id) {
                $('#table-data').DataTable({
                    drawCallback: function() {
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
                        url: '{{ route('fail_re_route_orders_data_table') }}',
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            branch_id: branch_id,
                            seller_id: seller_id,
                            staff_id: staff_id
                        }
                    },
                    columns: [{
                            data: 'st_11_at',
                            name: 'st_11_at'
                        },
                        {
                            data: 'waybill_id',
                            name: 'waybill_id'
                        },
                    ],
                });
            };

        </script>
    @endcan

    @can('order-receive.mark')
        <script>
            $('document').ready(function() {
                $('#scan_waybill').focus();
            });

            $('#btn-submit').click(function() {
                re_route();
            });

            function re_route() {
                let waybill = $('#scan_waybill').val();

                $.ajax({
                    url: '{{ route('fail_re_route') }}',
                    method: 'post',
                    data: {
                        waybill_id: waybill,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-submit').html('<i class="fa fa-spinner fa-spin"></i> loading...');
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.response == '0') {
                            notify('error', data.msg);

                            $('#btn-submit').html(
                                '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                            setTimeout(function() {
                                $('#btn-submit').html(
                                    'Make Re-Route');
                            }, 2000);
                            $('#scan_waybill').focus();

                            return;
                        }

                        $('#btn-submit').html(
                            '<i class="fa fa-check-circle" aria-hidden="true"></i> Save');
                        $('#scan_waybill').val('');

                        notify('success', 'Package Re-routed.');
                        $('#table-data').DataTable().destroy();
                        load_data();

                        setTimeout(function() {
                            $('#btn-submit').html('Make Re-Route');
                        }, 2000);

                    },
                    error: function(error) {
                        // console.log(error.responseJSON.exception);

                        notify('error', error.responseJSON.exception);
                        $('#btn-submit').html(
                            '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                        setTimeout(function() {
                            $('#btn-submit').html(
                                'Make Re-Route');
                        }, 2000);
                        $('#scan_waybill').focus();

                        return;
                    }
                });
            }
        </script>
    @endcan
@endsection
