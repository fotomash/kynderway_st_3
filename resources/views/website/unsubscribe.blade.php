@extends('layouts.master_website')

@section('css')
    <style>
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .seearch {
            margin-bottom: auto;
        }
        .box-panel{
            background-color: #fff;
            border-radius: 12px;
        }
    </style>
@endsection

@section('content')
    <main class="seearch">
        <div class="main-section">
            <div class="container">
                <div class="row">
                    <div class="col-6 mx-auto box-panel p-4">
                        <h1 class="h2">You are unsubscribed!</h1>
                        <p>We are sorry to lose you, but we understand very well.</p>
                        <p>Did you log out by mistake? No need to worry! You can sign back in immediately by clicking the button below or changing the marketing button in your platform profile.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection