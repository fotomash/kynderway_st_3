@component('mail::message')
    Dear {{ $notifiable->name }},
# Welcome to Kynderway!

Thank you for registering, we are delighted to have you join us.

Please use below code to activate your account.

# {{ $notifiable->otp }}

Have a great journey with Kynderway!

If you did not create an account, no further action is required.
<br/><br/>

Regards,<br/>
{{ config('app.name') }} Team

@endcomponent
