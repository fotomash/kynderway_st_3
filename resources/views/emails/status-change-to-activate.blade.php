@component('mail::message')
Dear {{ $content['userName'] }},

Your {{ $content['activationValue'] }} has been reactivated.

Regards,<br/>
{{ config('app.name') }} Team
@endcomponent
