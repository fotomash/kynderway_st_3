@component('mail::message')
Hi {{ $content['providerName'] }},

Congratulations! Your Account Verification has been successful. Kynderway has changed your profile to state your Identity was verified.

If you require additional support or have an enquiry, please don’t hesitate to contact us at <a href ="mailto:team@kynderway.com">team@kynderway.com</a>.

We are happy to assist you!

Good luck!


Regards,<br/>
{{ config('app.name') }} Team
@endcomponent