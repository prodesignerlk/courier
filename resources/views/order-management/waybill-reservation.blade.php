@extends('layouts.dashboard.main')

@section('content')
    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <p>Waybill Reservation</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('waybill_reservation_post') }}" method="POST" id="waybill_reserve_form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="waybill_type">Waybill Type :</label>
                                <select name="waybill_type" id="waybill_type"
                                    class="form-control js-example-basic-single @error('waybill_type') is-invalid @enderror">
                                    <option value="" disabled selected>Select Waybill Type</option>
                                    @foreach ($waybill_type_details as $waybilltype)
                                        <option value="{{ $waybilltype->waybill_type_id }}" @if (old('waybill_type') == $waybilltype->waybill_type_id) {{ 'selected' }} @endif>
                                            {{ $waybilltype->type }}</option>
                                    @endforeach
                                </select>
                                @error('waybill_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="user_id">Client :</label>
                                <select name="user_id" id="user_id"
                                    class="form-control @error('user_id') is-invalid @enderror js-example-basic-single">
                                    <option value="" disabled selected>Select Seller</option>
                                    @foreach ($seller_details as $seller)
                                        {{-- user_id --}}
                                        <option value="{{ $seller->id }}" @if (old('user_id') == $seller->id) {{ 'selected' }} @endif>
                                            {{ $seller->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="reserve_from">Reserve from :</label>
                                <input type="number" name="reserve_from" id="reserve_from"
                                    class="form-control @error('reserve_from') is-invalid @enderror"
                                    value="{{ old('reserve_from') }}">
                                @error('reserve_from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="reserve_to">Reserve to :</label>
                                <input type="number" name="reserve_to" id="reserve_to"
                                    class="form-control @error('reserve_to') is-invalid @enderror"
                                    value="{{ old('reserve_to') }}">
                                @error('reserve_to')
                                    <span class=" invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                        <table class="table table-bordered" id="regular-table">
                            <thead>
                                <tr>
                                    <th scope="col">Batch No</th>
                                    <th scope="col">Reserved Date</th>
                                    @if (!Auth::user()->hasRole('Seller'))
                                        <th scope="col">Store Name</th>
                                        {{-- <th scope="col">Seller Name</th> --}}
                                    @endif
                                    <th scope="col">To</th>
                                    <th scope="col">From</th>
                                    <th scope="col">Unused Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($waybill_unused as $waybill)
                                @php
                                    $batch_details = App\Models\Package::where('batch_number', $waybill->batch_number)->first();
                                    $reserved_date = $batch_details->reserved_date;
                                    $seller_info = $batch_details->seller;
                                    $user_details = $seller_info->user;
                                @endphp
                                    <tr>
                                        <td>{{ $waybill->batch_number }}</td>
                                        <td>{{ $reserved_date }}</td>
                                        @if (!Auth::user()->hasRole('Seller'))
                                            <td>{{ $user_details->name }}</td>
                                            {{-- <td>{{ $seller_info->seller_name }}</td> --}}
                                        @endif
                                        <td>{{ $waybill->min_waybill }}</td>
                                        <td>{{ $waybill->max_waybill }}</td>
                                        <td>{{ $waybill->qnt }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        $('document').ready(function() {
            getWaybillType();
            sellers();

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
                        waybill_option += "<option value="+w_type.waybill_type_id+">" + w_type
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
    </script> --}}
@endsection
