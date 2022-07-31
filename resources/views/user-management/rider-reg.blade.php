@extends('layouts.dashboard.main')

@section('content')
    @can('rider.create')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Rider Registration</p>
                    </div>
                    <div class="card-body">
                        <form action="{{route('rider_register')}}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Rider Name</label>
                                    <input type="text" class="form-control @error('rider_name')  is-invalid @enderror"
                                           name="rider_name" value="{{old('rider_name')}}" placeholder="Rider Name"
                                           required autocomplete="rider_name">
                                    @error('rider_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">NIC</label>
                                    <input type="text" class="form-control @error('staff_nic')  is-invalid @enderror"
                                           name="staff_nic" value="{{old('staff_nic')}}"
                                           required autocomplete="staff_nic" placeholder="National Identity Card No.">
                                    @error('staff_nic')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Contact No.</label>
                                    <input type="text"
                                           class="form-control @error('staff_contact_1')  is-invalid @enderror"
                                           name="staff_contact_1" value="{{old('staff_contact_1')}}"
                                           required placeholder="Contact No.">
                                    @error('staff_contact_1')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Contact No. (Optional)</label>
                                    <input type="text"
                                           class="form-control @error('staff_contact_2')  is-invalid @enderror"
                                           name="staff_contact_2" value="{{old('staff_contact_2')}}"
                                            placeholder="Contact No. (Optional)">
                                    @error('staff_contact_2')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Vehicle No.</label>
                                    <input type="text"
                                           class="form-control @error('vehicle_no_1')  is-invalid @enderror"
                                           name="vehicle_no_1" value="{{old('vehicle_no_1')}}"
                                           required placeholder="Eg:- AAA7452">
                                    @error('vehicle_no_1')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Vehicle No (Optional)</label>
                                    <input type="text"
                                           class="form-control @error('vehicle_no_2')  is-invalid @enderror"
                                           name="vehicle_no_2" value="{{old('vehicle_no_2')}}"
                                           placeholder="Eg:- AAA7452">
                                    @error('vehicle_no_2')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Address</label>
                                <input type="text"
                                       class="form-control @error('staff_address')  is-invalid @enderror"
                                       name="staff_address" value="{{old('vehicle_no_2')}}"
                                       placeholder="Address line1, City, District, Postal Code">
                                @error('staff_address')
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                @enderror
                            </div>
                    </div>

                            <div class="form-row">
                                <div class="form-group col-md-4 col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('rider.view')
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <p>Seller View</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display" id="rider-view-table" style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">NIC</th>
                                    <th scope="col">Contact No.</th>
                                    <th scope="col">Vehicle No.</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Actions</th>
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
    @endcan

    <script>
        $('document').ready(function () {
            load_data();
        });

        function load_data() {
            $('#rider-view-table').DataTable({
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
                    url: '{{ route('rider_view_table') }}',
                },
                columns: [
                    {
                        data: 'rider_name',
                        name: 'rider_name'
                    },
                    {
                        data: 'staff_nic',
                        name: 'staff_nic'
                    },
                    {
                        data: 'staff_contact_no',
                        name: 'staff_contact_no'
                    },
                    {
                        data: 'vehicle_no',
                        name: 'vehicle_no'
                    },
                    {
                        data: 'staff_address',
                        name: 'staff_address'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
        }
    </script>

@endsection
