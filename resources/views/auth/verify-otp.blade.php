@extends('layouts.master_auth')

@section('css')
@endsection

@section('content')
<div class="sign-in-page">
    <div class="signin-popup">
        <div class="signin-pop">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cmp-info">
                        <div class="cm-logo">
                            <img src="/website/images/logo1.svg" width="350" class="" style="display: block; margin: auto;" alt="">

                            <div class="row">
                                <div class="sign_in_sec current" id="tab-1">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-4">
                                            <h3>Verify Email using OTP</h3>
                                        </div>
                                        <div class="col-md-12">

                                            @include('errors.list')
                                            @if (session('status'))
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-9 mx-auto">
                                                    <p class="mb-4 text-justify">Thanks for signing up!</p>
                                                    <p class="mb-4 text-justify">To get started, please verify your email address by providing OTP we just emailed you. This OTP will expire in 60 minutes.</p>
                                                    <p class="mb-4 text-justify">If you haven’t received the email, please check you spam/junk folder or click below and we will gladly send you another.</p>
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('verification.resend.otp') }}">
                                                @csrf
                                                <div class="row mb-4">
                                                    <div class="col-lg-9 mx-auto">
                                                        <button type="submit" class="mt-0">Resend OTP</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <form method="POST" action="{{ route('verification.otp') }}" id="verify_otp" novalidate="">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-9 mx-auto">
                                                        <div class="sn-field error-ele">
                                                            <input type="number" class="set_box form-control" id="otp" name="otp" value="{{ old('otp') }}" placeholder="Enter OTP" required autofocus />
                                                            <i class="la la-key inputicon_cls"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-9 mx-auto">
                                                        <button type="submit" class="mt-0">Verify Account</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="/website/form-wizard/js/jquery.steps.js"></script>
<script src="/website/form-wizard/js/main.js"></script>

<script>
      $(document).ready(function(){

        if ($("#verify_otp").length) {
            $("#verify_otp").validate({
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest("div.error-ele"));
                },
                rules: {
                    otp: {
                        required: true
                    },
                },
                 messages:{
                     otp:{
                        required:"Please enter OTP to verify your email",
                    },
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        }
    });

</script>
@endsection
