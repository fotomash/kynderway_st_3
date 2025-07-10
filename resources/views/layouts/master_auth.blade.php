<!DOCTYPE html>
<html style="background: linear-gradient(to right, #8c50a0 0%, #304384 100%);">
    <head>
        @if (App::environment('production'))
            <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                    })(window,document,'script','dataLayer','GTM-KWZTWZT');</script>
                <!-- End Google Tag Manager -->
{{--            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-181441372-2"></script>--}}
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', 'UA-181441372-2');
                gtag('config', 'AW-499387801');
            </script>

        @endif
        <meta charset="UTF-8">
        <title>Kynderway</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Post private or business job offers for FREE. Reach potential candidates. Connect with nannies, maternity nurses, cleaners and housekeepers. No hidden cost." />
        <meta name="keywords" content="" />

        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ env('APP_URL') }}">
        <meta property="og:title" content="Kynderway - Platform designed to connect">
        <meta property="og:description" content="Post private or business job offers for FREE. Reach potential candidates. Connect with nannies, maternity nurses, cleaners and housekeepers. No hidden cost.">
        <meta property="og:image" content="{{ asset('assets/media/og-image.png') }}" />

        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" type="text/css" href="/auth/css/animate.css">
        <link rel="stylesheet" type="text/css" href="/auth/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/auth/css/line-awesome.css">
        <link rel="stylesheet" type="text/css" href="/auth/css/line-awesome-font-awesome.min.css">
        {{-- <link href="/auth/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> --}}
        <link rel="stylesheet" type="text/css" href="/auth/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/auth/lib/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="/auth/lib/slick/slick-theme.css">
        <link rel="stylesheet" type="text/css" href="/auth/css/style.css">
        <link rel="stylesheet" type="text/css" href="/auth/css/responsive.css">
        <link rel="icon" href="/auth/images/favicon.png" type="image/png" sizes="32x32">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <style>
        .error{
            color: red;
            padding-top: 10px;
        }
        </style>
        @yield('css')
    </head>
    <body class="sign-in" >
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KWZTWZT"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
        <div class="wrapper">

            @yield('content')

            <div class="footy-sec">
                <div class="container">
                    <p class="pt-3" style="display:inline-block; font-size: 17px;">&copy; Copyright 2021, All Rights Reserved</p>
                    <img class="pt-3 pb-2 footer-logo" src="/auth/images/logo2.svg" width="150px" alt="" />
                </div>
            </div>
        </div>
        {{-- <script data-cfasync="false" src="/auth/js/email-decode.min.js"></script> --}}
        <script type="text/javascript" src="/auth/js/jquery.min.js"></script>
        <script type="text/javascript" src="/auth/js/popper.js"></script>
        <script type="text/javascript" src="/auth/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/auth/lib/slick/slick.min.js"></script>
        <script type="text/javascript" src="/auth/js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        {{-- @foreach (['danger', 'warning', 'success', 'info'] as $msg)

        @if(Session::has($msg))

        <script>
            alert('{{ $msg }}'+'{{ Session::get($msg) }}');
        </script>

        @endif

        @endforeach --}}
        @yield('js')
    </body>
</html>
