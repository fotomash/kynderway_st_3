{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Login') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

@extends('layouts.master_auth')

@section('css')
    <link rel="stylesheet" href="/auth/form-wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="/auth/form-wizard/css/style.css">
@endsection

@section('content')
<div class="sign-in-page">
    <div class="signin-popup">
        <div class="signin-pop">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cmp-info">
                         @include('shared.response_msg')
                        <div class="cm-logo">
                            <img src="/website/images/logo1.svg" width="350" class="" style="display: block; margin: auto;" alt="">

                            <div class="sign-control">
                                <a href="/login" class="btn btn-auth selected mr-1">Login</a>
                                <a href="/register" class="btn btn-auth ml-1">Register</a>
                            </div>
                            {{-- <ul class="sign-control mt-4">
                                <li data-tab="tab-1" class="current"><a href="/login" onclick="redirect('/login')" title="">Login</a></li>
                                <li><a href="/register" onclick="redirect('/register')" title="">Register</a></li>
                            </ul> --}}
                        </div>
                        <div class="row">
                            <div class="sign_in_sec current" id="tab-1">
                                <div class="row">
                                    {{-- <div class="col-md-12 text-center mb-4">
                                        <h3>Login</h3>
                                    </div> --}}
                                    <div class="col-md-6 mb-5">
                                        <img class="hide-on-mobile" src="/website/images/login-img.png" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        {{-- @include('errors.list') --}}
                                        @if (session('status'))
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('login') }}" method="POST" id="login_frm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12 no-pdd error-ele mb-4">
                                                    <div class="sn-field mb-0">
                                                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                                                        <i class="la la-envelope-o"></i>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 no-pdd error-ele mb-4">
                                                    <div class="sn-field mb-0">
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                                                        <i class="la la-lock"></i>
                                                        <i class="la la-eye inputicon_cls" id="hide-password" onclick="togglePasswordView()"></i>
                                                        <i class="la la-eye-slash inputicon_cls" id="show-password" style="display: none;" onclick="togglePasswordView()"></i>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 no-pdd error-ele mb-4">
                                                    <div class="sn-field mb-0">
                                                        {{-- <!-- Remember Me -->
                                                        <div class="block mt-4">
                                                            <label for="remember_me" class="inline-flex items-center">
                                                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                                                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                                            </label>
                                                        </div> --}}
                                                        <div class="cpp-fiel error-ele">
                                                            <label for="remember_me">
                                                                <input type="checkbox" name="remember" id="remember_me" style="width: auto; height: auto;">
                                                                {{ __('Remember Me') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 no-pdd">
                                                    <div class="checky-sec">
                                                        <a href="/forgot-password" title=""><u>Forgot Password?</u></a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 no-pdd">
                                                    <button type="submit" value="submit">Login</button>
                                                </div>
                                            </div>
                                                <div class="social-login mt-3">
                                                    <a href="/login/google" class="btn btn-danger btn-block mb-2">Login with Google</a>
                                                    <a href="/login/apple" class="btn btn-dark btn-block mb-2">Login with Apple</a>
                                                    <a href="/login/linkedin" class="btn btn-primary btn-block">Login with LinkedIn</a>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="sign_in_sec" id="tab-2">

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
        $('[data-toggle="tooltip"]').tooltip();
        if ($("#login_frm").length) {
            $("#login_frm").validate({
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest("div.error-ele"));
                },
                rules: {
                    email: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        }
    });

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
</script>
@endsection