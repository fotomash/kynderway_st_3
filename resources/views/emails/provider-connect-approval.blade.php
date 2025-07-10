@component('mail::message')
Hi {{ $content['providerName'] }},

{{ $content['jobPosterName'] }} who posted the job {{ $content['jobTitle'] }} has accepted your application. Click below to message {{ $content['jobPosterName'] }}.

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
        }
      </style>
    </head>
      <body>
      <span>Hi : {{ $providerName }}</span>
      <br/>
      <span>{{ $jobPosterName }}  who posted the job {{ $jobTitle }} has accepted your application. Click below to message {{ $jobPosterName }}.</span>
      <br/>
      <a href="{{ url('provider/dashboard') }}" class="button">Message</a>
      <br/>
      <span>Good luck!</span>
      </body>
    </html> --}}
