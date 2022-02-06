@extends('layouts.dashboard.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>Waybill Reservation</p>
                </div>
                <div class="card-body">
                    <form action="" id="waybill_reserve_form">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">Waybill Type :</label>
                                <select name="waybill_type" id="waybill_type" class="form-control js-example-basic-single @error('waybill_type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Client :</label>
                                <select name="user_id" id="user_id" class="form-control js-example-basic-single" required>
                                    <option value="" disabled selected>Select...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Reserve from :</label>
                                <input type="number" name="reserve_from" id="reserve_from" class="form-control @error('reserve_from') is-invalid @enderror" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Reserve to :</label>
                                <input type="number" name="reserve_to" id="" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-block btn-reserve">Reserve waybill</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>Reserved Waybills</p>
                </div>
                <div class="card-body">
                    <div class="table-resposnive">
                        <table class="table table-bordered" id="datatable-basic">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Reserved Date</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                    <th scope="col">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
        $('document').ready(function() {
            getWaybillType();
            sellers();

            $('.btn-reserve').click(function() {
                form();
            });
        });



        function getWaybillType() {
            var waybill_option = "";

            $.ajax({
                url: '{{ route('get_waybill_types') }}',
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {

                    $.each(data.waybill_types, function(i, w_type) {
                        waybill_option += "<option value=" + w_type.waybill_type_id + ">" + w_type
                            .type +
                            "</option>";
                    });

                    $('#waybill_type').html(
                        "<option value='null' disabled selected >Select Waybill Type</option>");
                    $('#waybill_type').append(waybill_option);
                },
                error: function(error) {
                    // console.log(error);
                    notify('error', 'Waybill type data failed.');
                }
            });
        };

        function sellers() {
            var seller_option = "";
            $.ajax({
                url: '{{ route('get_seller_details') }}',
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#user_id').html("<option selected disabled>Select Seller</option>");
                },
                success: function(data) {

                    $.each(data, function(i, client_data) {
                        // use user id
                        seller_option += "<option value=" + client_data.id + ">" + client_data.name +
                            "</option>";
                    });

                    $('#user_id').html("<option value='null'selected disabled >Select Seller</option>");
                    $('#user_id').append(seller_option);

                },
                error: function(error) {
                    // console.log(error);
                    notify('error', 'Seller data failed.');

                }
            });
        };


        function form() {

            $("#waybill_reserve_form").validate({
                rules: {
                    waybill_type: "required",
                    user_id: "required",
                    reserve_from: "required",
                    reserve_to: "required",
                },
                messages: {
                    
                }
            });
        }
    </script>
@endsection
