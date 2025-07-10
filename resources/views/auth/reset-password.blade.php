{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
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
                                            <h3>Password Reset</h3>
                                        </div>
                                        <div class="col-md-12">

                                            @include('errors.list')
                                            @if (session('status'))
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    {{ session('status') }}
                                                </div>
                                            @endif

                                            <form method="POST" id="reset_frm" action="{{ route('password.update') }}">
                                                @csrf

                                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <div class="sn-field error-ele">
                                                            <input type="email" class="form-control" name="email" placeholder="Email" required value="{{ old('email', $request->email) }}">
                                                            <i class="la la-envelope-o"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <div class="sn-field error-ele">
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                                            <i class="la la-lock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <div class="sn-field error-ele">
                                                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                                            <i class="la la-lock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <button type="submit" class="mt-0" value="submit">RESET PASSWORD</button>
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
<script>
    $(document).ready(function(){       
     
      if ($("#reset_frm").length) {           
          $("#reset_frm").validate({
              errorPlacement: function($error, $element) {
                  $error.appendTo($element.closest("div.error-ele"));
              },
              rules: {
                  email: {
                      required: true
                  }, 
                  password: {
                      required: true,
                      minlength: 8
                  }, 
                  password_confirmation: {
                      required: true,
                      equalTo: "#password",
                      minlength: 8
                  },                  
              },
               messages:{
                  email:{
                      required:"Email is required",
                      email:"Email is not valid",
                  }, 
                  password:{
                      required:"Password is required",  
                      minlength:"Password must have 8 characters"
                  }, 
                  password_confirmation:{
                      required:"Password Confirmation is required"
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
