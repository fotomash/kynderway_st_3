@component('mail::message')

Dear {{ $content['firstName'] }},

@if($content['type'] == 'Hard')

Your account has been successfully deleted.

Please let us know if there's anything else we can assist you with or if you have any questions, by emailing us at team@kynderway.com.

@else
    
Your activity on Kynderway has been reported by other Users.  We have reviewed the raised concerns and found that you have violated Kynderway Terms of Service. We went ahead with your request and deleted your account.

Please do not attempt to use our service in the future.

If you require additional information or have an enquiry, please don’t hesitate to contact us at team@kynderway.com.

@endif

Regards,<br/>
{{ config('app.name') }} Team
@endcomponent