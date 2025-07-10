{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
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
                                        <div class="col-md-9 mx-auto text-center mb-4">
                                            <h3>Verify Your Email</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9 mx-auto">
                                                <p class="mb-4 text-justify">Thanks for signing up!</p>
                                                <p class="mb-4 text-justify">To get started, please verify your email address by clicking on the link we just emailed you. This link will expire in 60 minutes.</p>
                                                <p class="mb-4 text-justify">If you haven’t received the email, please check you spam/junk folder or click below and we will gladly send you another.</p>
                                            </div>
                                            <div class="col-lg-9 mx-auto p-0">
                                               {{-- <div class="container"> --}}
                                                    <div class="row">
                                                        <div class="col-lg-6 boxlayout">
                                                            <form method="POST" action="{{ route('verification.send') }}">
                                                                @csrf
                                                                <button type="submit" class="mt-2" value="RESEND VERIFICATION EMAIL">RESEND VERIFICATION EMAIL</button>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <form method="post" action="{{ url('logout')  }}">
                                                                @csrf
                                                                <button type="submit" class="secondary mt-2 logout-btn" style="border-radius: 20px;" value="LOGOUT">LOGOUT</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                {{-- </div>      --}}
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
</div>
@endsection

@section('js')
@endsection
