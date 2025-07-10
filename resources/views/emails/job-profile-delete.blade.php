@component('mail::message')
Hi {{ $content['userName'] }},

Your account {{ $content['setDeletedValue'] }} has been deleted due to the Terms of Service breach.

If you require additional support or have an enquiry, please don’t hesitate to contact us at <a href ="mailto:team@kynderway.com">team@kynderway.com</a>.


Regards,<br/>
{{ config('app.name') }} Team
@endcomponent

{{-- <!DOCTYPE html>
    <html>
    <head>
    </head>
      <body>
      <span>Hi {{ $userName }},</span>
      <br/><br/>
      <span>Your account {{ $setDeletedValue }} has been deleted due to the Terms of Service breach.</span>
      <br/><br/>
      <span>If you require additional support or have an enquiry, please don’t hesitate to contact us at <a href ="mailto:team@kynderway.com">team@kynderway.com</a>.</span>
      <br/><br/>
      <span>Kind regards,</span>
      <br/><br/>
      <span>Kynderway Team</span>
      </body>
    </html> --}}