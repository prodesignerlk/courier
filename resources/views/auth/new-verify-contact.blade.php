@extends('layouts.auth-layout')

@section('content')

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<div class="page-wrapper full-page">
    <div class="page-content d-flex align-items-center justify-content-center">

        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4 pr-md-0">
                            <div class="auth-left-wrapper">

                            </div>
                        </div>
                        <div class="col-md-8 pl-md-0">
                            <div class="auth-form-wrapper px-4 py-5">
                                <a href="#" class="noble-ui-logo d-block mb-3"><img class="ui-fc"
                                        src="{{url('./assets/images/logo.png')}}"></a>

                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification code has been sent to your
                                    XXXXXX'."68".' number') }}
                                </div>


                                <div class="alert alert-fill-warning" role="alert">
                                    Before proceeding, Please check your text message of
                                    <b>XXXXXX68</b> number.
                                </div>
                                <p>If you did not receive the verification code.</p>
                                <form class="d-inline" method="POST" action="">
                                    <button type="submit" class="btn btn-primary">{{ __('click here to request another')
                                        }}</button>
                                    <button type="button" class="btn btn-danger" id="change_con">{{ __('Change Contact
                                        No.') }}</button>
                                </form>

                                <form action="" method="POST">
                                    <br>

                                    @if(Session::has('error'))
                                    <div class="alert alert-icon-warning" role="alert">
                                        <i data-feather="alert-circle"></i>
                                        {{Session::get('error')}}
                                    </div>
                                    <br>
                                    @endif

                                    <input type="text" class="form-control" name="verification_code" id=""
                                        placeholder="Enter Verification Code" maxlength="6"><br>
                                    <button type="submit" class="btn btn-primary">{{ __('Verify') }}</button>
                                    <a class="btn btn-dark" href="">
                                        Logout
                                    </a>
                                </form>

                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- modal -->
<div class="modal fade" id="contact_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change your contat No.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="number" name="contact_no"
                        class="form-control "
                        placeholder="Enter your correct contact no." required>
                    {{-- @error('contact_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror --}}
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-change">Change</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#change_con').click(function() {
        $('#contact_modal').modal('show');
    });
</script>
@endsection