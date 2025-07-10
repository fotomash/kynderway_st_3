@component('mail::message')
Hi {{ $content['toUsername'] }},

{{ $content['fromUsername'] }} sent you a new message on Kynderway.

@component('mail::button', ['url' => env('APP_URL').'login'])
Go to Dashboard
@endcomponent

Good luck!


Regards,<br/>
{{ config('app.name') }} Team

@component('mail::subcopy')
If you’re having trouble clicking the "Go to Dashboard" button, copy and paste the URL below into your web browser: <a href="{{ env('APP_URL').'login' }}">{{ env('APP_URL').'login' }}</a> 
@endcomponent

@endcomponent


{{-- <!DOCTYPE html>
<html>
    <head>
        <style>
            .button {
                display: block;
                width: 110px;
                height: 25px;
                background: #8c50a0;
                padding: 10px;
                text-align: center;
                border-radius: 5px;
                color: white !important;
                font-weight: bold;
                line-height: 25px;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <span>Hi {{ $toUsername }},</span>
        <br/><br/>
        <span>{{ $fromUsername }} sent you a new message on Kynderway.</span>
        <br/><br/>
        <a href="{{ url('provider/dashboard') }}" class="button">View Message</a>
        <br/>
        Good luck!
        <br/><br/>
        <span>Kind regards,</span>
        <br/>
        <span>Kynderway Team</span>
    </body>
</html> --}}
