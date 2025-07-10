<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{ env('APP_NAME') }} | @yield('title')</title>

        <meta name="description" content="Post private or business job offers for FREE. Reach potential candidates. Connect with nannies, maternity nurses, cleaners and housekeepers. No hidden cost." />
        <meta name="keywords" content="" />
        <meta name="author" content="{{ env('APP_NAME') }}">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ env('APP_URL') }}">
        <meta property="og:title" content="Kynderway - Platform designed to connect">
        <meta property="og:description" content="Post private or business job offers for FREE. Reach potential candidates. Connect with nannies, maternity nurses, cleaners and housekeepers. No hidden cost.">
        <meta property="og:image" content="{{ asset('assets/media/og-image.png') }}" />

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/favicon.png') }}">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Fonts and OneUI framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/amethyst.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/custom.css') }}">
        <!-- END Stylesheets -->

        @yield('css')
    </head>
    <body>
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed page-header-dark">


            <nav id="sidebar" aria-label="Main Navigation">
                <!-- Side Header -->
                <div class="content-header bg-white-5">
                    <!-- Logo -->
                    <span class="smini-visible">
                        <img class="img-responsive" style="height: 26px;" src="{{ asset('assets/media/favicons/white-favicon.png') }}" />
                    </span>
                    <a class="font-w600 text-dual" href="/user">
                        <span class="smini-hide">
                            <img class="img-responsive" src="{{ asset('assets/media/logo2.svg') }}" width="180px" />
                        </span>
                    </a>
                    <!-- END Logo -->

                    <!-- Extra -->
                    <div>
                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="d-lg-none btn btn-sm btn-dual ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                        <!-- END Close Sidebar -->
                    </div>
                    <!-- END Extra -->
                </div>
                <!-- END Side Header -->

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('users')" href="/admin">
                                <i class="nav-main-link-icon fa fa-users"></i>
                                <span class="nav-main-link-name">Users</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('deleted-users')" href="/admin/deleted-users">
                                <i class="nav-main-link-icon fa fa-users"></i>
                                <span class="nav-main-link-name">Blacklisted Users</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('user-request')" href="/admin/delete-request">
                                <i class="nav-main-link-icon fa fa-user-times"></i>
                                <span class="nav-main-link-name">Delete Request</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('job-post')" href="/admin/job-post">
                                <i class="nav-main-link-icon fa fa-tasks"></i>
                                <span class="nav-main-link-name">Job Posts</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('job-offer')" href="/admin/job-offer">
                                <i class="nav-main-link-icon fa fa-tasks"></i>
                                <span class="nav-main-link-name">Job Offers</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('deleted-jobs')" href="/admin/deleted-jobs">
                                <i class="nav-main-link-icon fa fa-tasks"></i>
                                <span class="nav-main-link-name">Deleted Job Posts</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('work-profiles')" href="/admin/work-profiles">
                                <i class="nav-main-link-icon fa fa-address-book"></i>
                                <span class="nav-main-link-name">Work Profiles</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('messages')" href="/admin/messages">
                                <i class="nav-main-link-icon fa fa-comments"></i>
                                <span class="nav-main-link-name">Messages</span>
                            </a>
                        </li>
                        {{--<li class="nav-main-item">
                            <a class="nav-main-link @yield('reports')" href="/admin/reports/job-post">
                                <i class="nav-main-link-icon fa fa-desktop"></i>
                                <span class="nav-main-link-name">Reports</span>
                            </a>
                        </li>--}}

                        <li class="nav-main-item @yield('reports')">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon fa fa-desktop"></i>
                                <span class="nav-main-link-name">Reports</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('reports-job-pending')" href="/admin/reports/job-post/pending">
                                        <span class="nav-main-link-name">Jobs Pending</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('reports-job-history')" href="/admin/reports/job-post/history">
                                        <span class="nav-main-link-name">Jobs History</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('reports-profile-pending')" href="/admin/reports/profile-post/pending">
                                        <span class="nav-main-link-name">Profiles Pending</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('reports-profile-history')" href="/admin/reports/profile-post/history">
                                        <span class="nav-main-link-name">Profiles History</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- <li class="nav-main-item @yield('reports')">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon fa fa-user-check"></i>
                                <span class="nav-main-link-name">Reports</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('pre-checked-providers-pending')" href="/admin/reports/job-post">
                                        <span class="nav-main-link-name">Job Posts Reported</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('pre-checked-providers-history')" href="/admin/reports/detail">
                                        <span class="nav-main-link-name">Detail of Reports</span>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                        <li class="nav-main-item @yield('pre-checked-providers')">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon fa fa-user-check"></i>
                                <span class="nav-main-link-name">Pre-Checked Providers</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('pre-checked-providers-pending')" href="/admin/pre-checked-provider/pending">
                                        <span class="nav-main-link-name">Pending Request</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link @yield('pre-checked-providers-history')" href="/admin/pre-checked-provider/history">
                                        <span class="nav-main-link-name">History</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link @yield('emails')" href="admin/emails">
                                <i class="nav-main-link-icon fa fa-desktop"></i>
                                <span class="nav-main-link-name">Emails</span>
                            </a>
                        </li> --}}
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('change-password')" href="/admin/change-password">
                                <i class="nav-main-link-icon fa fa-lock"></i>
                                <span class="nav-main-link-name">Change Password</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link @yield('change-password')" href="/admin/mailing">
                                <i class="nav-main-link-icon fa fa-mail-reply"></i>
                                <span class="nav-main-link-name">Mailing</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END Side Navigation -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="d-flex align-items-center">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <!-- END Toggle Sidebar -->

                        <!-- Toggle Mini Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
                            <i class="fa fa-fw fa-ellipsis-v"></i>
                        </button>
                        <!-- END Toggle Mini Sidebar -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="d-flex align-items-center">
                        <!-- User Dropdown -->
                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn btn-sm btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img class="rounded" src="assets/media/avatars/avatar10.jpg" alt="Header Avatar" style="width: 18px;"> --}}
                                <span class="d-none d-sm-inline-block ml-1">{{ Auth::user()->name }}</span>
                                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-user-dropdown">
                                <div class="p-2">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="/admin/change-password">
                                        <span>Change Password</span>
                                        <i class="si si-lock ml-1"></i>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="/admin/logout">
                                        <span>Logout</span>
                                        <i class="si si-logout ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END User Dropdown -->

                        <!-- Toggle Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        {{-- <button type="button" class="btn btn-sm btn-dual ml-2" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>
                        </button> --}}
                        <!-- END Toggle Side Overlay -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Loader -->
                <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-white">
                    <div class="content-header">
                        <div class="w-100 text-center">
                            <i class="fa fa-fw fa-circle-notch fa-spin"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                <!-- Hero -->
                <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h1 class="flex-sm-fill h3 my-2">
                                @yield('title')
                            </h1>
                        </div>
                    </div>
                </div>
                <!-- END Hero -->

                <!-- Page Content -->
                <div class="content">
                    @include('errors.list')
                    @yield('content')
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-body-light">
                <div class="content py-3">
                    <div class="row font-size-sm">
                        <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-right">
                            <img class="img-responsive" src="{{ asset('assets/media/logo1.svg') }}" width="130px" />
                        </div>
                        <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-left">
                            &copy; Copyright {{ \Carbon\Carbon::now()->format('Y') }}, All Rights Reserved
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->

            <!-- Apps Modal -->
            <!-- Opens from the modal toggle button in the header -->
            <div class="modal fade" id="one-modal-apps" tabindex="-1" role="dialog" aria-labelledby="one-modal-apps" aria-hidden="true">
                <div class="modal-dialog modal-dialog-top modal-sm" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Apps</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row gutters-tiny">
                                    <div class="col-6">
                                        <!-- CRM -->
                                        <a class="block block-rounded block-themed bg-default" href="javascript:void(0)">
                                            <div class="block-content text-center">
                                                <i class="si si-speedometer fa-2x text-white-75"></i>
                                                <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                                                    CRM
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END CRM -->
                                    </div>
                                    <div class="col-6">
                                        <!-- Products -->
                                        <a class="block block-rounded block-themed bg-danger" href="javascript:void(0)">
                                            <div class="block-content text-center">
                                                <i class="si si-rocket fa-2x text-white-75"></i>
                                                <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                                                    Products
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END Products -->
                                    </div>
                                    <div class="col-6">
                                        <!-- Sales -->
                                        <a class="block block-rounded block-themed bg-success mb-0" href="javascript:void(0)">
                                            <div class="block-content text-center">
                                                <i class="si si-plane fa-2x text-white-75"></i>
                                                <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                                                    Sales
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END Sales -->
                                    </div>
                                    <div class="col-6">
                                        <!-- Payments -->
                                        <a class="block block-rounded block-themed bg-warning mb-0" href="javascript:void(0)">
                                            <div class="block-content text-center">
                                                <i class="si si-wallet fa-2x text-white-75"></i>
                                                <p class="font-w600 font-size-sm text-white mt-2 mb-3">
                                                    Payments
                                                </p>
                                            </div>
                                        </a>
                                        <!-- END Payments -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Apps Modal -->
        </div>
        <!-- END Page Container -->
         <script type="text/javascript" src="{{ asset('/website/js/jquery.min.js') }}"></script>
         <script type="text/javascript" src="{{ asset('/website/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/oneui.core.min.js') }}"></script>
        <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>

        <!-- Validation -->
        <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

        @yield('js')
    </body>
</html>

