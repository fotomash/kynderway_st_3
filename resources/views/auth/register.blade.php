{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

@extends('layouts.master_auth')

@section('css')
    <link rel="stylesheet" href="/auth/form-wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="/auth/form-wizard/css/style.css">
    <style>
        .tooltip, .tooltip-inner {
            min-width: 250px !important;
        }
        .tooltip-inner> p{
            max-width: 100% !important;
            color: white !important;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('content')
<div class="sign-in-page">
    <div class="signin-popup">
        <div class="signin-pop">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cmp-info">
                        {{-- @include('shared.response_msg') --}}
                        <div class="cm-logo">
                            <img src="/website/images/logo1.svg" width="350" class="" style="display: block; margin: auto;" alt="">

                            <div class="sign-control">
                                <a href="/login" class="btn btn-auth mr-1">Login</a>
                                <a href="/register" class="btn btn-auth selected ml-1">Register</a>
                            </div>
                            {{-- <ul class="sign-control mt-4">
                                <li data-tab="tab-1"><a href="/login" onclick="redirect('/login')" title="">Login</a></li>
                                <li class="current"><a href="/register" onclick="redirect('/register')" title="">Register</a></li>
                            </ul> --}}
                        </div>
                        <div class="row">
                            <div class="sign_in_sec current" id="tab-2">
                                @include('errors.list')
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form action="{{ route('register') }}" method="POST" id="wizard" class="">
                                    @csrf
                                    <!-- SECTION 1 -->
                                    <h2></h2>
                                    <section>
                                        <input type="hidden" name="type" value="" />
                                        <input type="hidden" name="client_type" value="" />
                                        <div class="form-content">
                                            {{-- <div class="">
                                                <h3 class="mb-5 text-center">New User</h3>
                                            </div> --}}
                                            <div class="col-lg-6 mx-auto" style="border: 1px solid #ccc; border-radius: 20px; margin: 100px 0px 0;">
                                                <div class="form-row">
                                                    <div class="col-lg-8 mx-auto text-center">
                                                        <button type="button" onclick="goTo('first', 'last');set_type_val('service_provider');" class="btn secondary" style="width:225px">I am looking for a job</button>
                                                    </div>
                                                </div>
                                                <div class="form-row mb-0">
                                                    <div class="col-lg-8 mx-auto mb-3 pb-3 text-center">
                                                        <button type="button" onclick="goTo('first', 'second');set_type_val('service_seeker');" id="posting" class="btn secondary mt-2" style="width:225px">I am posting a job</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- SECTION 2 -->
                                    <h2></h2>
                                    <section>
                                        <div class="form-content">
                                            {{-- <div class="">
                                                <h3 class="mb-5 text-center">New User</h3>
                                            </div> --}}
                                            <div class="col-lg-6 mx-auto" style="border: 1px solid #ccc; border-radius: 20px; margin: 100px 0px 0;">
                                                <div class="form-row">
                                                    <div class="col-lg-6 mx-auto text-center">
                                                        <button type="button" onclick="goTo('second', 'last');set_client_type_val('Private');" data-toggle="tooltip" data-placement="right" title="I am a individual or a parent looking to hire a service provider privately" class="btn secondary" style="width:225px">Private Offer</button>
                                                    </div>
                                                </div>
                                                <div class="form-row mb-0">
                                                    <div class="col-lg-6 mx-auto mb-3 pb-3 text-center">
                                                        <button type="button" onclick="goTo('second', 'last');set_client_type_val('Business');" data-toggle="tooltip" data-placement="right" title="I am looking for a service provider on behalf of my client. Business offers are for Nanny Agencies, Cleaning Companies, Recruitment Agencies etc." class="btn secondary mt-2" style="width:225px">Business Offer</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 rm-pad-mobile">
                                                    <button type="button" onclick="goBack()" class="btn">Back</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- SECTION 3 -->
                                    <h2></h2>
                                    <section>
                                        <div class="form-content">
                                            {{-- <div class="">
                                                <h3 class="mb-5 text-center">New User</h3>
                                            </div> --}}

                                            <div class="row pt-5" style="">
                                                <div class="col-md-6 error-ele mb-4">
                                                    <div class="sn-field mb-0">
                                                        <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
                                                        <i class="la la-user"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 error-ele mb-4">
                                                    <div class="sn-field mb-0">
                                                        <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
                                                        <i class="la la-user"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 error-ele mb-4">
                                                    <div class="sn-field mb-0">
                                                        <input type="email" class="form-control" name="email" placeholder="Email" data-toggle="tooltip" data-html="true" data-placement="top" title="<p>Please make sure that you enter valid email address, as you will be receiving the verification link.</p>" required>
                                                        <i class="la la-envelope-o"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 error-ele mb-4">
                                                    <div class="sn-field mb-0">
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                                        <i class="la la-lock"></i>
                                                        <i class="la la-eye inputicon_cls" id="hide-password" onclick="togglePasswordView()"></i>
                                                        <i class="la la-eye-slash inputicon_cls" id="show-password" style="display: none;" onclick="togglePasswordView()"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 error-ele mb-4">
                                                    <div class="form-group">
                                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                                                        <input type="hidden" class="hiddenRecaptcha" name="hiddenRecaptcha" data-callback="recaptchaCallback" id="hiddenRecaptcha">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 error-ele mb-4">
                                                    <div class="checky-sec st2">
                                                        <div class="signup-tick">
                                                            <div class="row">
                                                                <div class="col-1 p-0" style="max-width: 20px;">
                                                                    <input type="checkbox" class="form-control" style="display: none;" name="terms_condition" id="c2" value="1" required="required"/>
                                                                    <label for="c2"><span></span></label>
                                                                </div>
                                                                <div class="col-11 p-0">
                                                                    <small>Yes, I understand and agree to the Kynderway <a href="https://kynderway.com/terms" target="_blank">Terms & Conditions</a>.</small>
                                                                    <br>
                                                                    <span class="cond_error"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" onclick="goBack()"  class="btn logout-btn-left">Back</button>
                                                    <button type="submit" class="btn subbtn logout-btn" style="">Create Account</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </form>
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

<!-- JQUERY STEP for Form Wizard -->
<script src="/website/form-wizard/js/jquery.steps.js"></script>
<script src="/website/form-wizard/js/main.js"></script>

<script>
    function redirect(url) {
        window.location.href = url;
    }

    var previousPage = '-';

    function goTo(from, to) {

        if(from == "first" && to == 'second') {

            $( ".actions li:nth-child(2) a" ).click();

        }else if(from == "first" && to == 'last') {

            // $( ".actions li:nth-child(2) a" ).click();
            // $( ".actions li:nth-child(2) a" ).click();
            $( "a#wizard-t-2" ).click();

        }else if(from == "second" && to == 'last') {

            $( ".actions li:nth-child(2) a" ).click();

        }
        // else if(from == "last" && to == 'second') {

        //     $( ".actions li:nth-child(1) a" ).click();

        // }else if(from == "second" && to == 'first') {

        //     $( ".actions li:nth-child(1) a" ).click();

        // }
        previousPage = from;
    }

    function goBack() {

        if(previousPage == "first") {

            $( "a#wizard-t-0" ).click();

        }else if(previousPage == "second") {

            previousPage = "first";
            $( "a#wizard-t-1" ).click();

        }else {
            alert('something went wrong');
        }
    }

    $(document).ready(function(){

        $(".subbtn").on("click", function(){
                if($('input[type="checkbox"]').prop("checked") == false){
                    $('.cond_error').text('You must agree to terms and conditions');
                    $('.cond_error').addClass('error');
                }
        });

        $('input[type="checkbox"]').click(function(){
            if($('input[type="checkbox"]').prop("checked") == true){
                $('.cond_error').removeClass('error');
                $('.cond_error').text(' ');
            }else if($('input[type="checkbox"]').prop("checked") == false){
                $('.cond_error').text('You must agree to terms and conditions');
                $('.cond_error').addClass('error');
            }
        });

        window.onresize = tooltip = function() {
            if(window.innerWidth < 768) {
                $('body').tooltip('destroy');
            }
            $('body').tooltip({
                selector: window.innerWidth < 768  ? '[data-toggle="tooltip"]' : ''
            });
        }
        tooltip();
        $('[data-toggle="tooltip"]').tooltip();

        jQuery.validator.addMethod("recaptcha", function(value, element, params) {
            if(grecaptcha.getResponse() == ''){
                return false;
            }else{
                return true;
            }
        }, "Please confirm captcha code.");

        if ($("#wizard").length) {
            $.validator.addMethod("passwordComplexity", function(value, element) {
                return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(value);
            }, "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.");
            $.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-z-\s]+$/i.test(value);
            }, "Only alphabetical letters are allowed.");
            $("#wizard").validate({
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest("div.error-ele"));
                },
                ignore: "",
                rules: {
                    firstname: {
                        required: true,
                        lettersonly: true

                    },
                    lastname: {
                        required: true,
                        lettersonly: true

                    },
                    email: {
                        required: true,
                        email:true
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        passwordComplexity: true

                    },
                    hiddenRecaptcha: {
                        recaptcha: true
                    }
                },
                messages: {
                    'firstname': {
                        required: "First Name field is required",
                        lettersonly: "Only alphabetical letters are allowed."

                    },
                    'lastname': {
                        required: "Last Name field is required",
                        lettersonly: "Only alphabetical letters are allowed."

                    },
                    'email': {
                        required: "Email field is required",
                        email: "Please enter a valid email address."

                    },
                    'password': {
                        required: "Password field is required",
                        passwordComplexity: "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character."

                    },
                    'terms_condition': {
                        required: "You must agree to the Terms & Conditions!"
                    },
                    'hiddenRecaptcha': {
                        recaptcha: "Please confirm recaptcha!"
                    }
                },
                submitHandler: function (form) {
                    if($('input[type="checkbox"]').prop("checked") == true){
                        form.submit();
                    }
                }
            });
        }
    });

    function set_type_val(type_val){
        $('form[id="wizard"] input[name="type"]').val(type_val);
    }
    function set_client_type_val(type_val){
        $('form[id="wizard"] input[name="client_type"]').val(type_val);
    }

    function togglePasswordView() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            $('#hide-password').hide();
            $('#show-password').show();
        } else {
            x.type = "password";
            $('#hide-password').show();
            $('#show-password').hide();
        }
    }

    function recaptchaCallback() {
        $('#hiddenRecaptcha').valid();
    };
</script>
@endsection
