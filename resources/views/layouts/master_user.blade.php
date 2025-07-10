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
        <link rel="stylesheet" href="{{ asset('css/custom-messaging.css') }}">
        <link rel="stylesheet" type="text/css" href="/website/css/animate.css">
        <link rel="stylesheet" type="text/css" href="/website/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/website/css/line-awesome.css">
        <link rel="stylesheet" type="text/css" href="/website/css/line-awesome-font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/website/vendor/fontawesome-free/css/all.min.css" >
        <link rel="stylesheet" type="text/css" href="/website/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/website/css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" type="text/css" href="/website/lib/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="/website/lib/slick/slick-theme.css">
        <link rel="stylesheet" type="text/css" href="/website/css/style.css">
        <link rel="stylesheet" type="text/css" href="/website/css/responsive.css">
        <link rel="stylesheet" type="text/css" href="/website/flaticons/flaticon.css">
        <link rel="icon" href="/website/images/favicon.png" type="image/png" sizes="32x32">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@7.0.1/minified/introjs.min.css">
        <script src="https://cdn.jsdelivr.net/npm/intro.js@7.0.1/intro.min.js"></script>
            <style>

                .introjs-tooltip {
                    width: 40vw;
                    max-width: 90vw;
                }

                .introjs-tooltipbuttons {
                    display: none;
                }

                .introjs-arrow {
                    display: none;
                }

                .introjs-progress {
                    display: none;
                }
                .intro-container{
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .introjs-bullets ul{
                    display: none;
                }

                @media (min-width: 768px) {
                    .introjs-tooltip p {
                        width: 290px;
                        text-align: center;
                        white-space: pre-wrap;
                    }
                }

                @media (max-width: 767px) {
                    .introjs-tooltip p {
                        width: 80%;
                        text-align: center;
                        white-space: pre-wrap;
                    }
                }
                .introjs-tooltip h2 {
                    margin-bottom:2%;
                    text-align: center;
                    font-weight: 500;
                    font-size: 20px;

                }
                .introjs-tooltip .buttons {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                @media (min-width: 768px) {
                    .introjs-tooltip .buttons {
                        flex-direction: row;
                        justify-content: space-between;
                    }
                }
                .intro-title{
                    font-weight: 500;
                    font-size: 20px;
                    text-align: center;
                }


                .modal .modal-dialog-aside{
                width: 800px;
                max-width:100%;
                height: 100%;
                margin:0;
                transform: translate(0);
                transition: transform .2s;
            }
            .modal .modal-dialog-aside .modal-content{
                height: inherit;
                border:0;
                border-radius: 0;
            }
            .modal .modal-dialog-aside .modal-content .modal-body{
                overflow-y: auto
            }
            .modal.fixed-left .modal-dialog-aside{
                margin-left:auto;
                transform: translateX(100%);
            }
            .modal.fixed-right .modal-dialog-aside{
                margin-right:auto;
                transform: translateX(-100%);
            }
            .modal.show .modal-dialog-aside{
                transform: translateX(0);
            }
            .error{
                color: red;
                padding-top: 10px;
            }
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
                border: 16px solid #8c50a0;
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
                                    <a href="/login" title="" style="float: right;"><!--<i class="la la-key"></i>--> Login</a>
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
                                @if(Auth::check())
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
                                            <a href="/search-providers" class="@yield('search-providers')"   title="">
                                                Search Candidates
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                --}}

                                @if(Auth::check() && Auth::user()->type == 'service_seeker')
                                    <li class="@yield('post-vacancy')">
                                        <a href="{{ $user_type }}/post-vacancy" class="@yield('post-vacancy')"  title="">
                                            Post Vacancy
                                        </a>
                                    </li>
                                @elseif(Auth::check() && Auth::user()->type == 'service_provider')
                                    <li class="@yield('search-jobs')">
                                        <a href="/search-jobs" class="@yield('search-jobs')"  title="">
                                            Search Jobs
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
        <!--Start Job Notes Modal -->
        <div id="noteModal" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-center">
                <div class="modal-content">
                    <div class="modal-header d-block" style="padding-bottom: 20px;">
                        <div class="swal-icon swal-icon--warning">
                            <span class="swal-icon--warning__body">
                                <span class="swal-icon--warning__dot"></span>
                            </span>
                        </div>
                        <h3 class="modal-title swal-title aligncenter modal-text" id="noteTitle"> Update Note </h3>
                    </div>
                    <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal" action="{{ url($user_type.'/update-job-note') }}">
                        <input type="hidden" name="referenceID" id="noteReferenceID" value="">
                        <input type="hidden" name="type" value="{{ Auth::user()->type == 'service_provider' ? 'Job' : 'Profile' }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body aligncenter">
                            <div class="form-group cp-field">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="mintxt-modal">Note for this job post</span>
                                    </label>
                                </div>
                                <div class="cpp-fiel">
                                    <textarea type="text" name="comment" id="noteText" required placeholder="Enter notes" style="white-space: pre-wrap;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="swal-button swal-button--cancel" data-dismiss="modal" style="border-radius: 20px; background-color: #8c50a0; color: #fff;">Cancel</button>
                            <button type="submit" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #404786; color: #fff;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <!--Start Application Notes Modal -->
        <div id="applicationNoteModal" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-center">
                <div class="modal-content">
                    <div class="modal-header d-block" style="padding-bottom: 20px;">
                        <div class="swal-icon swal-icon--warning">
                            <span class="swal-icon--warning__body">
                                <span class="swal-icon--warning__dot"></span>
                            </span>
                        </div>
                        <h3 class="modal-title swal-title aligncenter modal-text" id="noteTitle"> Update Note </h3>
                    </div>
                    <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal" action="{{ url($user_type.'/update-application-job-note') }}">
                        <input type="hidden" name="referenceID" id="applicationNoteReferenceID" value="">
                        <input type="hidden" name="type" value="{{ Auth::user()->type == 'service_provider' ? 'Job' : 'Profile' }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body aligncenter">
                            <div class="form-group cp-field">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <span class="mintxt-modal">Note for this job post</span>
                                    </label>
                                </div>
                                <div class="cpp-fiel">
                                    <textarea type="text" name="comment" id="applicationNoteText" required placeholder="Enter notes" style="white-space: pre-wrap;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="swal-button swal-button--cancel" data-dismiss="modal" style="border-radius: 20px; background-color: #8c50a0; color: #fff;">Cancel</button>
                            <button type="submit" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #404786; color: #fff;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal -->
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
                            @if(Auth::user()->type == 'service_seeker')
                                <span class="mintxt-modal">Your connection's profile has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com" style="color: #007bff;">team@kynderway.com</a> to learn more.</span>
                            @else
                                <span class="mintxt-modal">Your profile has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com" style="color: #007bff;">team@kynderway.com</a> regarding your profile suspension.</span>
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
        <script type="text/javascript" src="/website/lib/slick/slick.min.js"></script>
        <script type="text/javascript" src="/website/js/script.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>var isGetUnseenMessageCountRunning = false;</script>
        <script>


            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
            $(document).ajaxSend(function(event, request, settings) {
                if (!isGetUnseenMessageCountRunning) {
                    $('#loader-div').show();
                }
            });

            $(document).ajaxComplete(function(event, request, settings) {
                if (!isGetUnseenMessageCountRunning) {
                    $('#loader-div').hide();
                }
            });

            function reportConnect(referenceID, title) {
                $("#reportModal").modal('show');
                $("#reportReferenceID").val(referenceID);
                $("#reportTitle").text(title);
            }

            function editJobNote(referenceID, note) {
                $("#noteModal").modal('show');
                $("#noteReferenceID").val(referenceID);
                $("#noteText").text(note);
            }

            function editApplicationNote(referenceID, note) {
                $("#applicationNoteModal").modal('show');
                $("#applicationNoteReferenceID").val(referenceID);
                $("#applicationNoteText").text(note);
            }

            function linkToClipboard(slug) {
                var tempInput = $("<input>");
                $("body").append(tempInput);
                tempInput.val(slug).select();
                console.log(tempInput.val(slug).select());
                document.execCommand("copy");
                tempInput.remove();

              //  alert("Copied job link to clipboard: " + slug);





            }

            function openDrawer(id) {
                console.log(id);
                $('.ed-options.'+id).toggleClass('active');
            }

            function clearChat(conid) {
                $("#chatCount-"+conid).html('0');
                $("#chatMessage-"+conid).html('');
            }

            function giveAccess(job_id, doc_id,connId) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('provider/give-access') }}",
                    "type": "POST",
                    data: {
                        job_id: job_id,
                        doc_id: doc_id,
                        connId: connId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success == '1') {
                            $('#access-'+doc_id).text('Granted').css('cursor', 'not-allowed').prop('disabled', true);
                        }else {
                            alert('something went wrong, contact support');
                        }
                    },
                    error: function (jqXHR, testStatus, error) {
                        console.log(error);
                        alert('something went wrong, contact support');
                    }
                });

            }

            function downloadFile(id, url) {

                $.ajax({
                    url: url,
                    "type": "GET",
                    success: function (response) {
                        // console.log(response);
                        //Do nothing
                    },
                    error: function (jqXHR, testStatus, error) {
                        console.log(error);
                        alert('something went wrong, contact support');
                    }
                });
            }
        </script>

        @yield('js')
    </body>
</html>
