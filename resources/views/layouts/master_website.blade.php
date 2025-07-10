<!DOCTYPE html>
<html>
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
            <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" type="text/css" href="/website/css/animate.css">
        <link rel="stylesheet" type="text/css" href="/website/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/website/css/jquery.range.css">
        <link rel="stylesheet" type="text/css" href="/website/css/line-awesome.css">
        <link rel="stylesheet" type="text/css" href="/website/css/line-awesome-font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/website/vendor/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="/website/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/website/css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" type="text/css" href="/website/lib/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="/website/lib/slick/slick-theme.css">
        <link rel="stylesheet" type="text/css" href="/website/css/style.css">
        <link rel="stylesheet" type="text/css" href="/website/css/responsive.css">
        <link rel="stylesheet" type="text/css" href="/website/flaticons/flaticon.css">
        <link rel="icon" href="/website/images/favicon.png" type="image/png" sizes="32x32">
        <style>

            #loader-div{
                position: fixed;
                left: 0;
                top: 0;
                height: 100%;
                width: 100%;
                z-index: 10999;
                background-color: #0000008a;
            }
            #loader {
                position: absolute;
                left: 50%;
                top: 50%;
                z-index: 1;
                width: 120px;
                height: 120px;
                margin: -76px 0 0 -76px;
                border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid #424887;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
            }

            @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Add animation to "page content" */
            .animate-bottom {
                position: relative;
                -webkit-animation-name: animatebottom;
                -webkit-animation-duration: 1s;
                animation-name: animatebottom;
                animation-duration: 1s
            }

            @-webkit-keyframes animatebottom {
                from { bottom:-100px; opacity:0 }
                to { bottom:0px; opacity:1 }
            }

            @keyframes animatebottom {
                from{ bottom:-100px; opacity:0 }
                to{ bottom:0; opacity:1 }
            }
        </style>
        @yield('css')
    </head>
    <body >
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KWZTWZT"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
        <div id="loader-div" style="display: none;"><div id="loader"></div></div>
        <div class="wrapper">
            <header class="shadow">
                <div class="container">
                    <div class="header-data">
                        <div class="logo">
                            <a href="/" title=""><img src="/website/images/logo2.svg" alt=""></a>
                        </div>
                        <div class="menu-btn">
                            <a href="#" id="menu-btn" title=""><i id="menu_icon" class="fa fa-bars"></i></a>
                        </div>
                        <div class="user-account">
                            <div class="user-info" style="">
                                @if(Auth::check())
                                    <img src="{{ Helper::getProfileImage(Auth::user()->profile_picture) }}" alt="Profile Picture">
                                    {{-- <a href="#" title="">{{ \Illuminate\Support\Str::limit(Auth::user()->name, 5, $end='...') }}</a> --}}
                                    <i class="la la-sort-down"></i>
                                @else
                                    {{-- <a href="/login" title="" style="float: right;"><i class="la la-key"></i> LOGIN</a> --}}
                                    <a href="/register" title="" style="float: right; padding-left: 10px;"><!--<i class="la la-key"></i>--> Register</a>
                                    <a href="/login" title="" style="float: right; padding-right: 10px;"><!--<i class="la la-key"></i>--> Login</a>
                                @endif
                            </div>
                            @if(Auth::check())
                                <div class="user-account-settingss">
                                    <a href="Javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title=""><h3 class="tc" style="color: #304384"><i class="fas fa-sign-out-alt"></i> LOGOUT</h3></a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            @endif
                        </div>
                        <nav>
                            <ul>
                                @if(Auth::check() && Auth::user()->type == 'admin')
                                    <li>
                                        <a href="/admin/users">
                                            Admin Dashboard
                                        </a>
                                    </li>
                                @endif

                                @if(Auth::check() && Auth::user()->type != 'admin')
                                    <li class="@yield('dashboard')">
                                        <a href="{{ $user_type }}/dashboard" class="@yield('dashboard')" title="">
                                            My Dashboard
                                        </a>
                                    </li>
                                @endif

                                {{--
                                @if(Auth::check())
                                    @if(Auth::user()->type == 'service_seeker')
                                        <li class="@yield('search-providers')">
                                            <a href="/search-providers" class="@yield('search-providers')"  title="">
                                                Search Candidates
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li class="@yield('search-providers')">
                                        <a href="/search-providers" class="@yield('search-providers')"  title="">
                                            Search Candidates
                                        </a>
                                    </li>
                                @endif
                                --}}

                                @if(Auth::check())
                                    @if(Auth::user()->type == 'service_provider')
                                        <li class="@yield('search-jobs')">
                                            <a href="/search-jobs" class="@yield('search-jobs')"  title="">
                                                Search Jobs
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li class="@yield('search-jobs')">
                                        <a href="/search-jobs" class="@yield('search-jobs')"  title="">
                                            Search Jobs
                                        </a>
                                    </li>
                                @endif

                                @if(Auth::check() && Auth::user()->type == 'service_seeker')
                                    <li class="@yield('post-vacancy')">
                                        <a href="{{ $user_type }}/post-vacancy" class="@yield('post-vacancy')"  title="">
                                            Post Vacancy
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="https://kynderway.com/contact" target="_blank" title="">
                                        Contact
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </header>
            <hr />

            @yield('content')

            <footer>
                <div class="">
                    <div class="container">
                        <p class="pt-3" style="">&copy; Copyright 2021, All Rights Reserved</p>
                        <img class="pt-3 pb-2" src="/website/images/logo1.svg" style="" width="150px" alt="" />
                    </div>
                </div>
            </footer>
        </div>
        @if(Auth::check())
            <!--Start report job Modal -->
            <div id="reportModal" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-center">
                    <div class="modal-content">
                        <div class="modal-header d-block" style="padding-bottom: 20px;">
                            <div class="swal-icon swal-icon--warning">
                            <span class="swal-icon--warning__body">
                              <span class="swal-icon--warning__dot"></span>
                            </span>
                            </div>
                            <h3 class="modal-title swal-title aligncenter modal-text" id="reportTitle"> Report Job </h3>
                        </div>
                        <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal" action="{{ url($user_type.'/report-connection') }}">
                            <input type="hidden" name="referenceID" id="reportReferenceID" value="">
                            <input type="hidden" name="type" value="{{ Auth::user()->type == 'service_provider' ? 'Job' : 'Profile' }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="modal-body aligncenter">
                                <div class="form-group cp-field">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <span class="mintxt-modal">Provide reason for report</span>
                                        </label>
                                    </div>
                                    <div class="cpp-fiel">
                                        <textarea type="text" name="comment" required placeholder="Enter reason for report" style="white-space: pre-wrap;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="swal-button swal-button--cancel" data-dismiss="modal" style="border-radius: 20px; background-color: #8c50a0; color: #fff;">Cancel</button>
                                <button type="submit" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #404786; color: #fff;">Report</button>

                                {{-- <button type="button" class="swal-button swal-button--cancel modal_margin"  data-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="submit" class="swal-button swal-button--confirm">Report</button> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Model -->
            <!--Start suspended job Modal -->
            <div id="suspended-job" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-center">
                    <div class="modal-content">
                        <div class="modal-header d-block" style="padding-bottom: 20px;">
                            <div class="swal-icon swal-icon--warning">
                            <span class="swal-icon--warning__body">
                              <span class="swal-icon--warning__dot"></span>
                            </span>
                            </div>
                            <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2"> Suspended Job </h3>
                        </div>
                        <div class="modal-body aligncenter">
                            <label class="form-label p-3">
                                {{-- <span class="mintxt-modal">This job is suspended so you cant check detail or do messaging. Kindly contact admin for more help.</span> --}}
                                @if(Auth::user()->type == 'service_provider')
                                    <span class="mintxt-modal">Your connection's job post has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com" style="color: #007bff;">team@kynderway.com</a> to learn more.</span>
                                @else
                                    <span class="mintxt-modal">Your job post has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com" style="color: #007bff;">team@kynderway.com</a> regarding your job post suspension.</span>
                                @endif
                            </label>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="swal-button swal-button--cancel" data-dismiss="modal" style="border-radius: 20px; background-color: #8c50a0; color: #fff;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Model -->
            <!--Start suspended profile Modal -->
            <div id="suspended-profile" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-center">
                    <div class="modal-content">
                        <div class="modal-header d-block" style="padding-bottom: 20px;">
                            <div class="swal-icon swal-icon--warning">
                            <span class="swal-icon--warning__body">
                              <span class="swal-icon--warning__dot"></span>
                            </span>
                            </div>
                            <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2"> Profile Suspended</h3>
                        </div>
                        <div class="modal-body aligncenter">
                            <label class="form-label p-3">
                                @if(Auth::check())
                                    @if(Auth::user()->type == 'service_seeker')
                                        <span class="mintxt-modal">Your connection's profile has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com" style="color: #007bff;">team@kynderway.com</a> to learn more.</span>
                                    @else
                                        <span class="mintxt-modal">Your profile has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com" style="color: #007bff;">team@kynderway.com</a> regarding your profile suspension.</span>
                                    @endif
                                @endif
                            </label>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="swal-button swal-button--cancel" data-dismiss="modal" style="border-radius: 20px; background-color: #8c50a0; color: #fff;">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Model -->
        @endif
        <script type="text/javascript" src="/website/js/jquery.min.js"></script>
        <script type="text/javascript" src="/website/js/popper.js"></script>
        <script type="text/javascript" src="/website/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/website/js/jquery.mCustomScrollbar.js"></script>
        <script type="text/javascript" src="/website/js/jquery.range-min.js"></script>

        <script type="text/javascript" src="/website/lib/slick/slick.min.js"></script>
        <script type="text/javascript" src="/website/js/script.js"></script>


        <script>




            $(document).ajaxSend(function(event, request, settings) {

                $('#loader-div').show();

            });

            $(document).ajaxComplete(function(event, request, settings) {
                $('#loader-div').hide();
            });

            $('#menu-btn').on("click", function() {
                $("#menu_icon").toggleClass('fa-bars fa-close');
            });

            function reportConnect(referenceID, title) {
                $("#reportModal").modal('show');
                $("#reportReferenceID").val(referenceID);
                $("#reportTitle").text(title);
            }

            function clearChat(conid) {
                $("#chatCount-"+conid).html('0');
                $("#chatMessage-"+conid).html('');
            }
        </script>
        @yield('js')
    </body>
</html>
