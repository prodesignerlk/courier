@extends('layouts.dashboard.main')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>Add Waybill Type</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Name :</label>
                            <input type="text" name="" id="type_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Description :</label>
                            <textarea class="form-control" name="" id="type_description" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary btn-block" id="btn-add-type">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>System Reservation Type</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Select Type :</label>
                            <select name="" id="waybill_type_selector" class="form-control js-example-basic-single">
                                <option value="" disabled selected>Select...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Description :</label>
                            <textarea class="form-control" name="" id="reserve_details" rows="7" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary btn-block" id="btn-reserve">Update</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>Waybill Start</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Start From :</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <p>Added Waybill Type</p>
                </div>
                <div class="card-body">
                    <div class="table-resposnive">
                        <table class="table table-bordered" id="waybill-type-table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>

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

            $('#btn-add-type').click(function() {
                inputWaybillType();
            });

            $('#waybill_type_selector').change(function() {
                $('#btn-reserve').html('Update');
                let waybill_type = $(this).val();
                get_waybill_description(waybill_type);
            });

            $('#btn-reserve').click(function() {
                let waybill_type = $('#waybill_type_selector').val();
                set_waybill_option(waybill_type);
            });

        });

        function inputWaybillType() {
            let type_name = $('#type_name').val();
            let type_description = $('#type_description').val();

            $.ajax({
                url: "{{ route('waybill_type_input') }}",
                method: 'POST',
                data: {
                    type_name: type_name,
                    type_description: type_description,
                    _token: "{{ csrf_token() }}",
                },
                beforeSend: function() {
                    $('#btn-add-type').html('<i class="fa fa-spinner fa-spin"></i> loading...');
                },
                success: function(data) {
                    // console.log(data);
                    $('#type_name').val('');
                    $('#type_description').val('');
                    $('#btn-add-type').html('<i class="fa fa-check-circle" aria-hidden="true"></i> Save');
                    notify('success', 'Data insert Successful.');
                    getWaybillType();
                },
                error: function(error) {
                    // console.log(error);
                    $('#btn-add-type').html('<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');
                    notify('error', 'Data insert failed.');
                }
            });
        }

        function getWaybillType() {
            var option = "";
            var tbody = "";

            $.ajax({
                url: '{{ route('getWaybillTypes') }}',
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {

                    $.each(data.waybill_types, function(i, w_type) {
                        tbody += "<tr><td>" + w_type.waybill_type_id + "</td><td>" + w_type.type +
                            "</td><td>" + w_type.description + "</td></tr>"
                    });

                    $('#waybill-type-table tbody').html("");
                    $('#waybill-type-table tbody').append(tbody);

                    $.each(data.waybill_option, function(j, w_option) {
                        // console.log(w_option);
                        option += "<option value=" + w_option.waybill_option_id + ">" + w_option
                            .option + "</option>";

                    });

                    $('#waybill_type_selector').html(
                        "<option value='null' disabled selected>Select...</option>");
                    $('#waybill_type_selector').append(option);
                },
                error: function(error) {
                    // console.log(error);
                    notify('error', 'Data showing failed.');
                }
            });
        }

        function set_waybill_option(type) {
            $.ajax({
                url: '{{ route('set_waybill_type') }}',
                method: 'post',
                data: {
                    wayabill_type: type,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#btn-reserve').html('<i class="fa fa-spinner fa-spin"></i> loading...');
                    // $('#reserve_details').html('');
                },
                success: function(data) {
                    // console.log(data);
                    notify('success', 'Data insert Successful.');
                    $('#btn-reserve').html('<i class="fa fa-check-circle" aria-hidden="true"></i> Saved');
                },
                error: function(error) {
                    // console.log(error);
                    notify('error', 'Data update failed.');
                    $('#btn-reserve').html(
                        '<i class="fa fa-times-circle" aria-hidden="true"></i></i> Try Again');

                }
            });
        }

        function get_waybill_description(type) {
            
            $.ajax({
                url: '{{ route('waybill_description_get') }}',
                method: 'post',
                data: {
                    wayabill_type: type,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#reserve_details').html('');
                },
                success: function(data) {
                    // console.log(data);
                    $('#reserve_details').text(data);
                    
                },
                error: function(error) {
                    // console.log(error);
                    notify('error', 'Data showing failed.');
                }
            });
        }

    </script>
@endsection
{{-- @push('scripts')
    <script>
        $(function() {
            $('#waybill-type-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('fill_waybill_type_table') }}",

                columns: [{
                        data: 'waybill_type_id',
                        name: 'waybill_type_id'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                ]
            });

        });
    </script>

@endpush --}}
