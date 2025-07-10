
<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Kynderway - Jobs newsletter</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      
      /*All the styling goes here*/
      
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; 
      }

      body {
        font-family: 'Montserrat',sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; 
      }

      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: 'Montserrat',sans-serif;
          font-size: 14px;
          vertical-align: top; 
      }

      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */

      .body {
        background: linear-gradient(90.59deg, #83559B 1.89%, #364681 98.92%),linear-gradient(0deg, #FFFFFF, #FFFFFF);
        width: 100%; 
        background-color: #364681 !important;
      }

      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; 
      }

      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        margin: 0 auto;
        max-width: 580px;
        padding: 10px; 
      }

      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #ffffff;
        border-radius:12px;
        width: 100%; 
      }

      .wrapper {
        box-sizing: border-box;
        padding: 20px; 
      }

      .content-block {
        padding-bottom: 10px;
        padding-top: 10px;
      }

      .footer {
        clear: both;
        margin-top: 10px;
        text-align: center;
        width: 100%; 
      }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; 
      }

      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: 'Montserrat',sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        margin-bottom: 30px; 
      }

      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
        text-transform: capitalize; 
      }

      p,
      ul,
      ol {
        font-family: 'Montserrat',sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        margin-bottom: 5px; 
      }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; 
      }

      a {
        color: #3498db;
        text-decoration: underline; 
      }

      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto; 
      }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; 
      }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
          text-transform: capitalize; 
      }

      .btn-primary table td {
        background-color: #253169; 
      }

      .btn-primary a {
        background-color: #253169;
        border-color: #253169;
        color: #ffffff; 
      }

      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; 
      }

      .first {
        margin-top: 0; 
      }

      .align-center {
        text-align: center; 
      }

      .align-right {
        text-align: right; 
      }

      .align-left {
        text-align: left; 
      }

      .clear {
        clear: both; 
      }

      .mt0 {
        margin-top: 0; 
      }

      .mb0 {
        margin-bottom: 0; 
      }

      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; 
      }

      .powered-by a {
        text-decoration: none; 
      }

      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        margin: 20px 0; 
      }

      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
        table.body h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; 
        }
        table.body p,
        table.body ul,
        table.body ol,
        table.body td,
        table.body span,
        table.body a {
          font-size: 16px !important; 
        }
        table.body .wrapper,
        table.body .article {
          padding: 10px !important; 
        }
        table.body .content {
          padding: 0 !important; 
        }
        table.body .container {
          padding: 0 !important;
          width: 100% !important; 
        }

        table.body .btn table {
          width: 100% !important; 
        }
        table.body .btn a {
          width: 100% !important; 
        }
        table.body .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; 
        }
      }

      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; 
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; 
        }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; 
        }
        #MessageViewBody a {
          color: inherit;
          text-decoration: none;
          font-size: inherit;
          font-family: inherit;
          font-weight: inherit;
          line-height: inherit;
        }
        .btn-primary table td:hover {
          background-color: #34495e !important; 
        }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; 
        } 
      }

    </style>
  </head>
  <body style="background: linear-gradient(90.59deg, #83559B 1.89%, #364681 98.92%),linear-gradient(0deg, #FFFFFF, #FFFFFF);background-color: #364681 !important;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <img style="display: block; width: 126px; height: auto; margin-bottom: 35px;" src="{{ asset('assets/media/logo6.png') }}">
            <img style="display: block;margin: auto;  margin-bottom: 35px;" src="{{ asset('assets/media/mail/bg-mail.png') }}">
            <h2 style="text-align: center; font-weight: 700; color: #fff; margin-bottom: 5px;">Hello, {{ $content['name'] }}</h2>
            <h3 style="text-align: center; font-weight: 500; color: #fff;">We’ve found some jobs that may interest you.</h3>
            <table role="presentation" class="main" style="background: linear-gradient(90.59deg, #83559B 1.89%, #364681 98.92%),linear-gradient(0deg, #FFFFFF, #FFFFFF);    background-color: #364681!important;">
              <tr>
                <td class="wrapper" style="background-color: #fff; border-radius: 12px;">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    @foreach ($content['jobs'] as $job)
                      <tr>
                        <td style="border-bottom: 1px solid #F0F0F0; padding: 5px; background-color: #fff; border-radius: 12px;">
                          <p style="display: inline-block; font-size: 14px; font-weight: 600; line-height: 17px; color: #243169;">{{ $job['jobtitle'] }}</p>
                          <p style="display: inline-block;font-size: 10px;font-weight: 500;line-height: 12px;letter-spacing: 0em;text-align: left;color: #242424;background: #F0F0F0;padding: 4px 8px;border-radius: 12px;">Full time, live out</p>
                          <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                              <tr>
                                <td align="left">
                                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                      <tr>
                                        <td>
                                          <img style="display: block;    margin: 5px auto;" src="{{ asset('assets/media/mail/location.png') }}">
                                        </td>
                                        <td><p>{{ (!empty($job['address']) ? $job['address'].', ' : '') }}{{ (!empty($job['postalcode']) ? $job['postalcode'].',' : '') }}{{ (!empty($job['city']) ? $job['city'].',' : '') }}{{ (!empty($job['country']) ? $job['country'] : '') }}</p></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <img style="display: block;    margin: 5px auto;" src="{{ asset('assets/media/mail/time.png') }}">
                                        </td>
                                        <td><p>Starting {{ !empty($job['start_date']) ? $job['start_date'] : 'ASAP' }}</p></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <p style="color:#808080">{{ substr($job['job_details'], 0, 75) }}...</p>
                          <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                            <tbody>
                              <tr>
                                <td align="left">
                                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                      <tr>
                                        <td> <a href="{{ url(env('APP_URL').'jobs/'.$job['slug']) }}" target="_blank">See More</a> </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      @endforeach
                  </table>
                </td>
              </tr>

            </table>

            <div class="footer">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    <span class="apple-link">Kynderway ©Copyright 2022.</span>
                    <br> Don't like these emails? <a href="{{ $content['email'] != null ? url(env('APP_URL').'unsubscribe/'.base64_encode($content['email'])) : '#' }}">Unsubscribe</a>.
                  </td>
                </tr>
              </table>
            </div>

          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
