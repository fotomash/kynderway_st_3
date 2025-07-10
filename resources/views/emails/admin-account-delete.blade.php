@component('mail::message')

Account of user {{ $content['firstName'] }} is Deleted successfully.

Name : {{ $content['firstName'] . ' ' . $content['lastName'] }} <br/>
Type : {{ $content['type'] }} Account <br/>
Email : {{ $content['email'] }} <br/>

Regards,<br/>
{{ config('app.name') }} Team
@endcomponent
