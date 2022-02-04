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
                        <div class="col-md-3">
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
                    <form action="">
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
                                <textarea class="form-control" name="" id="" rows="7" readonly></textarea>
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
                    <p>Waybill Start</p>
                </div>
                <div class="card-body">
                    <form action="">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Start From :</label>
                                <input type="text" name="" id="" class="form-control">
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
                    $('#btn-add-type').html('Save');
                    notify('success', 'Data insert Successful.');
                    getWaybillType();
                },
                error: function(error) {
                    // console.log(error);
                    $('#btn-add-type').html('Try Again');
                    notify('error', 'Data insert failed.');
                }
            });
        }

        function getWaybillType() {
            var option = "";
            // var tbody="";

            $.ajax({
                url: '{{ route('getWaybillTypes') }}',
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(i, value) {
                        option += "<option value=" + value.waybill_type_id + ">" + value.type +
                            "</option>";
                        // tbody += "<tr><td>"+value.waybill_type_id+"</td><td>"+value.type+"</td><td>"+value.description+"</td></tr>"
                    });
                    $('#waybill_type_selector').html("<option value='null' selected desabled>Select...</option>");

                    $('#waybill_type_selector').append(option);
                    
                    
                    // $('#datatable-basic tbody').html("");
                    // $('#datatable-basic tbody').append(tbody);

                },
                error: function(error) {
                    // console.log(error);
                    notify('error', 'Data showing failed.');
                }
            });
        }
    </script>
@endsection
@push('scripts')
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

@endpush
