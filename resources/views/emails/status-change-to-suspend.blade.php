@component('mail::message')
Hi {{ $content['userName'] }},

Your account {{ $content['suspensionValue'] }} has been temporarily suspended.

We are looking into this, please bear with us. We will get back to you as soon as possible.

Please feel free to contact us at <a href ="mailto:team@kynderway.com">team@kynderway.com</a> with any questions or concerns. We are here to help.


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
      <span>Your account {{ $suspensionValue }} has been temporarily suspended.</span>
      <br/><br/>
      <span>We are looking into this, please bear with us. We will get back to you as soon as possible.</span>
      <br/><br/>
      <span>Please feel free to contact us at <a href ="mailto:team@kynderway.com">team@kynderway.com</a> with any questions or concerns. We are here to help.</span>
      <br/><br/>
      <span>Kind regards,</span>
      <br/><br/>
      <span>Kynderway Team</span>
      </body>
    </html> --}}