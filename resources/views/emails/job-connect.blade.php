@component('mail::message')
Hi {{ $content['providerFullName'] }},

{{ $content['jobposterFullname'] }} has invited you to their job offer. Please click below to see more details.

@component('mail::button', ['url' => $content['dashboardUrl']])
Go to Dashboard
@endcomponent

Good luck!


Regards,<br/>
{{ config('app.name') }} Team

@component('mail::subcopy')
If you’re having trouble clicking the "Go to Dashboard" button, copy and paste the URL below into your web browser: <a href="{{ env('APP_URL').$content['dashboardUrl'] }}">{{ env('APP_URL').$content['dashboardUrl'] }}</a> 
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
      <span>Hi : {{ $providerFullName }}</span>
      <br/>
      <span>{{ $jobposterFullname }}  has invited you to their job offer. Please click below to see more details.</span>
      <br/>
      <a href="{{ url($dashboardUrl) }}" class="button">View Job</a>
      <br/>
      <span>Good luck!</span>
      </body>
    </html> --}}