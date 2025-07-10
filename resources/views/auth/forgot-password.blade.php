{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

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
                                            <h3>Forgot Password?</h3>
                                        </div>
                                        <div class="col-md-12">

                                            @include('errors.list')
                                            @if (session('status'))
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    {{ session('status') }}
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('password.email') }}" id="forgot_frm" novalidate="">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <p class="mb-4 text-justify">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <div class="sn-field error-ele">
                                                            <input type="email" class="set_box form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" required autofocus />
                                                            <i class="la la-envelope-o inputicon_cls"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <button type="submit" class="mt-0" value="submit">EMAIL PASSWORD RESET LINK</button>
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
       
        if ($("#forgot_frm").length) {           
            $("#forgot_frm").validate({
                errorPlacement: function($error, $element) {
                    $error.appendTo($element.closest("div.error-ele"));
                },
                rules: {
                    email: {
                        required: true
                    },                  
                },
                 messages:{
                    email:{
                        required:"Email is required",
                        email:"Email is not valid",
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
