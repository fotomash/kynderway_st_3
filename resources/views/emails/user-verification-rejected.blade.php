@component('mail::message')
Hi {{ $content['providerName'] }},

Unfortunately, we were unable to positively confirm your identity.

If you still wish to proceed, please attach different document.

If you require additional support or have an enquiry, please don’t hesitate to contact us at <a href ="mailto:team@kynderway.com">team@kynderway.com</a>.

We are happy to assist you!

Good luck!


Regards,<br/>
{{ config('app.name') }} Team
@endcomponent