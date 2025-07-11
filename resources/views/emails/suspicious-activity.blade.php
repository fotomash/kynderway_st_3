@component('mail::message')
Suspicious activity has been detected for user **{{ $content['user']->email }}**.

@foreach ($content['flags'] as $flag)
- {{ $flag }}
@endforeach

Please review this account as soon as possible.

Regards,<br>
{{ config('app.name') }} Team
@endcomponent
