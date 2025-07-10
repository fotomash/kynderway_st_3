{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex justify-end mt-4">
                <x-button>
                    {{ __('Confirm') }}
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
                                            <h3>Confirm Password</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <form method="POST" action="{{ route('password.confirm') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <p class="mb-4 text-justify">This is a secure area of the application. Please confirm your password before continuing.</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <div class="sn-field">
                                                            <input type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Password">
                                                            <i class="la la-lock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-8 mx-auto">
                                                        <button type="submit" class="mt-0" value="submit">CONFIRM</button>
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
@endsection
