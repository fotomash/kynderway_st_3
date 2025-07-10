@component('mail::message')
Hi  {{ $content['providerName'] }},

We have received your Account Verification request.

Our team of consultants will now review your application and should get back to you within 48 hours.

Please note, we keep your documents for the length of time you have an Account with us as a minimum. To learn more, please see our <a href="{{ url('privacy-policy') }}">Privacy Policy</a>.


Kynderway is designed to give you control over finding your perfect role, but if you require additional support or have an enquiry, please don’t hesitate to contact us at <a href ="mailto:team@kynderway.com">team@kynderway.com</a>.

We are happy to assist you!


Regards,<br/>
{{ config('app.name') }} Team
@endcomponent