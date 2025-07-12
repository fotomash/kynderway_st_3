

@extends('layouts.master_user')

@section('css')
    <style>
        .modal .modal-dialog-aside {
            width: 800px;
            max-width: 100%;
            height: 100%;
            margin: 0;
            transform: translate(0);
            transition: transform .2s;
        }

        .modal .modal-dialog-aside .modal-content {
            height: inherit;
            border: 0;
            border-radius: 0;
        }

        .modal .modal-dialog-aside .modal-content .modal-body {
            overflow-y: auto
        }

        .modal.fixed-left .modal-dialog-aside {
            margin-left: auto;
            transform: translateX(100%);
        }

        .modal.fixed-right .modal-dialog-aside {
            margin-right: auto;
            transform: translateX(-100%);
        }

        .modal.show .modal-dialog-aside {
            transform: translateX(0);
        }

        .introjs-skipbutton{
            display: none;
        }

    </style>

    @if (App::environment('production'))

        <!-- Event snippet for Registered Provider conversion page -->
        <script> gtag('event', 'conversion', {'send_to': 'AW-499387801/cOEGCOr4-cICEJmbkO4B'}); </script>

    @endif

@endsection

@section('dashboard')
    active
@endsection

{{--@if(Auth::user()->is_new)--}}

{{--@endif--}}

@section('content')
   <section class="profile-account-setting">
       <div class="container">
           <div class="account-tabs-setting">
               @include('shared.response_msg')
               <div class="row mb-4">
                   <div class="col-12 p-0">
                   @foreach($suspendedProfiles as $suspendedProfile)
                       <p class="alert alert-warning mt-3">
                           {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                           Your {{ $suspendedProfile->profilecat->categoryname }} profile has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com" style="color: #007bff;">team@kynderway.com</a> regarding your account suspension.
                           {{-- Your profile for {{ $suspendedProfile->profilecat->categoryname }} is suspended. Contact admin for more details. --}}
                       </p>
                   @endforeach
                   @if(Auth::user()->delete_request == 1)
                       <p class="alert alert-warning mt-3">
                           You have been reported by other Users. Admin is reviewing your pending reports and will contact you soon.
                       </p>
                   @endif
                   </div>
               </div>
               <div class="row">
                   @include('shared.sidebar', ['active' => 'dashboard'])
                   <div class="col-lg-9 pad-right-mob">
                       <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304184;" data-title="Welcome!" data-intro="Hello World! 👋">My Jobs</h3>
                       <hr class="bold" />

                       <div class="tab-content" id="nav-tabContent">
                           <div class="tab-pane fade show active" id="nav-acc" role="tabpanel"
                                aria-labelledby="nav-acc-tab">
                               <div class="shadow mb-2">
                                   <div class="posts-section">
                                       <p class="mb-3" style="color: #686868;">Check the messages or job invitations you have received.
                                           If you’re interested, accept the offer to enable the chat and talk directly to the families and agencies.</p>
                                       @if($total_dashbrd_jobs >0)
                                       <div class="contentJobProvider">
                                           @foreach($allUsersJobs as $key=>$allUserJob)
                                               <div class="post-bar" style="">
                                                   <div class="job_descp">
                                                       <div class="row">
                                                           <div class="col-lg-12 p-0">
                                                               <div class="provider-topbar mt-0 mb-0"
                                                                    style="">
                                                                   <div class="row">
                                                                       <div class="col-md-9 p-0">
                                                                           <div class="provider-picy" >
                                                                               <img src="{{ UserHelper::getProfilePic($allUserJob['job_userid']) }}" style="border-radius: 14px;" alt="">
                                                                           </div>
                                                                           <h3 class="mb-0"
                                                                               style="display: block;margin-left: 90px;padding-bottom: 27px;padding-top:27px;">
                                                                               <strong style="font-size: 22px;">
                                                                                   {{ $allUserJob['name'] }}
                                                                               </strong>
                                                                               <span class="float-right-desktop" style="font-size: 14px; font-style: italic; color: #304384; font-weight: bold; padding-top: 4px;" id="chatMessage-{{ $allUserJob['conid'] }}">
                                                                           
                                                                                @if (!$allUserJob['fullconnect'])
                                                                                    @if ($allUserJob['requested_by'] == 'service_provider')
                                                                                        has accepted your application
                                                                                    @else
                                                                                        {{ $allUserJob['name'] }} has invited you to their  {{ $allUserJob->profile->profilecat->categoryname }} job offer.
                                                                                    @endif
                                                                                @endif
                                                                                @if ($allUserJob['fullconnect'])
                                                                                  
                                                                                    @if (UserHelper::getTotalCount($allUserJob['conid'],$allUserJob['job_userid']) == 0 && $allUserJob['requested_by'] == 'service_provider')
                                                                                        @if (UserHelper::getUnseenCount($allUserJob['conid'], $allUserJob['provider_id']) > 0)
                                                                                            {{ $allUserJob['name'] }}  has accepted your job application.<br> You have a New Message from {{ $allUserJob['name'] }}
                                                                                        @else
                                                                                            {{ $allUserJob['name'] }}  has accepted your job application.<br> Chat with {{ $allUserJob['name'] }}  now.
                                                                                        @endif
                                                                                    @elseif (UserHelper::getTotalCount($allUserJob['conid'],$allUserJob['job_userid']) == 0 && $allUserJob['requested_by'] != 'service_provider')
                                                                                        Chat with {{ $allUserJob['name'] }} now
                                                                                    @elseif (UserHelper::getUnseenCount($allUserJob['conid'], $allUserJob['provider_id']) > 0)
                                                                                        You have a New Message from {{ $allUserJob['name'] }}
                                                                                    @endif
                                                                                @endif
                                                                               </span>
                                                                           </h3>
                                                                       </div>
                                                                       <div class="col-md-3 p-0 text-right-desktop-center-mob">
                                                                           <div class="row">
                                                                               <div class="col-11 p-0">

                                                                                   <ul class="bk-links mt-2 pt-3">


                                                                                       @if($allUserJob['fullconnect'])
                                                                                           <li><a id="chatbtn" type="button" class="message_now" style="color: #fff; padding: 0px;" data-toggle="modal"
                                                                                               @if($allUserJob->adstatus && $allUserJob->status)
                                                                                                  data-target="#modal_aside_right" onclick="viewfullprofile({{ $allUserJob['jobid'] }}, {{ $allUserJob['conid'] }},'messagewindow');clearChat({{ $allUserJob['conid'] }});"
                                                                                               @else
                                                                                                   @if(!$allUserJob->adstatus)
                                                                                                       data-target="#suspended-job"
                                                                                                   @else
                                                                                                       data-target="#suspended-profile"
                                                                                                   @endif
                                                                                               @endif
                                                                                               >

                                                                                                   <i class="fas fa-comment" style="background-color: transparent; width: 50px;">
                                                                                                       <span id="chatCount-{{ $allUserJob['conid'] }}">{{ UserHelper::getUnseenCount($allUserJob['conid'],$allUserJob['provider_id']) }}</span>
                                                                                                   </i>
                                                                                               </a>
                                                                                           </li>
                                                                                       @else
                                                                                           <li><a type="button" class="cancel" style="color: #fff; padding: 0px;" title="Approve"
                                                                                               @if($allUserJob->adstatus && $allUserJob->status)
                                                                                                  onclick="approveConnect({{ $allUserJob['conid'] }})" data-toggle="tooltip" data-placement="bottom"
                                                                                                  @else
                                                                                                   @if(!$allUserJob->adstatus)
                                                                                                       data-toggle="modal" data-target="#suspended-job"
                                                                                                   @else
                                                                                                       data-target="#suspended-profile" data-toggle="modal"
                                                                                                   @endif
                                                                                               @endif
                                                                                               >
                                                                                                   <i class="fas fa-check bg-success"></i>
                                                                                               </a>
                                                                                           </li>
                                                                                           <li><a type="button" class="cancel" title="Reject" data-toggle="tooltip" data-placement="bottom" style="color: #fff; padding: 0px;" onclick="cancelconnect({{ $allUserJob['conid'] }},'rejectbtn')">
                                                                                                   <i class="fas fa-close bg-danger" style="background-color: #fb9300 !important;"></i>
                                                                                               </a>
                                                                                           </li>
                                                                                       @endif

                                                                                       <li><a type="button" class="bid_now"
                                                                                           style="color: #fff; padding: 0 10px; top: 0px;"
                                                                                           data-toggle="modal"
                                                                                           @if($allUserJob->adstatus && $allUserJob->status)
                                                                                               data-target="#modal_aside_right"
                                                                                               onclick="viewfullprofile({{ $allUserJob['jobid'] }}, {{ $allUserJob['conid'] }}, '{{ $allUserJob['fullconnect'] }}');"
                                                                                           @else
                                                                                               @if(!$allUserJob->adstatus)
                                                                                                   data-target="#suspended-job"
                                                                                               @else
                                                                                                   data-target="#suspended-profile"
                                                                                               @endif
                                                                                           @endif
                                                                                           >View Job</a>
                                                                                       </li>

                                                                                   </ul>
                                                                               </div>
                                                                               <div class="col-1 p-0">
                                                                                   <i class="la la-ellipsis-v ed-opts-open three-dots-provider mt-2 pt-3" style="cursor: pointer;"></i>
                                                                                   <ul class="ed-options ed-options-provider">
                                                                                        <li onclick="viewDocuments({{ $allUserJob['jobid'] }}, {{ $allUserJob['conid'] }}, '{{ $allUserJob['fullconnect'] }}');">View Documents Permission</li>
                                                                                       @if($allUserJob['fullconnect'])
                                                                                           <li onclick="cancelconnect({{ $allUserJob['conid'] }},'deletebtn');">Delete Connection</li>
                                                                                       @endif
                                                                                       <li onclick="reportConnect({{ $allUserJob['jobid'] }}, 'Report Job');">Report Job</li>
                                                                                   </ul>
                                                                               </div>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>

                                           @endforeach
                                       </div>

                                           {{-- <div class="post-bar" style="">
                                               <div class="job_descp">
                                                   <div class="row">
                                                       <div class="col-lg-12 p-0">
                                                           <div class="provider-topbar mt-0 mb-0"
                                                                style="">
                                                               <div class="row">
                                                                   <div class="col-md-8 p-0">
                                                                       <div class="provider-picy">
                                                                           <img src="/website/images/resources/default-dp.jpg"
                                                                                style="border-radius: 14px;"
                                                                                alt="">
                                                                       </div>
                                                                       <h3 class="mb-0"
                                                                           style="display: block;margin-left: 90px;padding-bottom: 27px;padding-top:27px;">
                                                                           <strong style="font-size: 22px;">
                                                                               Murlidhar
                                                                           </strong>
                                                                           <span class="float-right-desktop" style="font-size: 14px; font-style: italic; color: #304384; font-weight: bold; padding-top: 4px;">
                                                                               has accepted your application
                                                                           </span>
                                                                       </h3>
                                                                   </div>
                                                                   <div class="col-md-4 p-0 text-right-desktop-center-mob">
                                                                       <div class="row">
                                                                           <div class="col-10 p-0">

                                                                               <ul class="bk-links mt-2 pt-3">

                                                                                   <li><a type="button" class="bid_now"
                                                                                       style="color: #fff; padding: 0 20px; top: 0px;"
                                                                                       data-toggle="modal"
                                                                                       data-target="#modal_aside_right">View Job</a>
                                                                                   </li>

                                                                                   <li><a type="button" class="" title="Approve" style="color: #fff; padding: 0px;">
                                                                                           <i class="fas fa-check bg-success"></i>
                                                                                       </a>
                                                                                   </li>

                                                                                   <li><a type="button" class="" title="Reject" style="color: #fff; padding: 0px;">
                                                                                           <i class="fas fa-close bg-danger"></i>
                                                                                       </a>
                                                                                   </li>
                                                                               </ul>
                                                                           </div>
                                                                           <div class="col-2 p-0">
                                                                               <i class="la la-ellipsis-v ed-opts-open three-dots-provider mt-2 pt-3" style=""></i>
                                                                               <ul class="ed-options">
                                                                                   <li>Delete Job</li>
                                                                                   <li>Report Job</li>
                                                                               </ul>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div> --}}


                                           <div class="job_pagin_links">
                                               {{ $allUsersJobs->links('vendor.pagination.custom') }}
                                           </div>
                                       @else
                                           <div class=""
                                                style="text-align:center; padding: 20px 20px 20px 20px; color: #884d9b; font-weight:bold; border-radius: 20px; width:100%;">
                                               No application(s) received
                                           </div>
                                       @endif

                                   </div>
                               </div>

                           </div>
                       </div>

                   </div>
               </div>
           </div>
       </div>
   </section>

   <div id="modal_aside_right" class="modal fixed-left fade searchsidemodalId pr-0" tabindex="-1" role="dialog">
   </div>

   <!--Start Delete Confirm Modal -->
   <div id="deleteConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-center">
           <div class="modal-content">
               <div class="modal-header d-block">
                   <div class="swal-icon swal-icon--warning">
                       <span class="swal-icon--warning__body">
                         <span class="swal-icon--warning__dot"></span>
                       </span>
                   </div>
                   <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                       Delete Confirmation
                   </h3>
               </div>
               <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <div class="modal-body aligncenter">
                       <div class="form-group">
                           <div class="mt-3">
                               <label class="form-label modal_margin">
                                   <span class="mintxt-modal">This will delete your connection and messages. Are you sure?</span>
                               </label>
                           </div>
                       </div>
                   </div>

                   <div class="modal-footer">
                       <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #fb9300; border: 1px solid #fb9300; color: #fff;" id="delete_yes">Delete
                       </button>
                       <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" id="delete_no"
                               data-dismiss="modal">Cancel
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
   <!-- End Model -->

   <!--Start Delete Success Modal -->
   <div id="deleteSuccessModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-center">
           <div class="modal-content">
               <div class="modal-header d-block">
                   <div class="swal-icon swal-icon--warning">
                       <span class="swal-icon--warning__body">
                         <span class="swal-icon--warning__dot"></span>
                       </span>
                   </div>
                   <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                       Done
                   </h3>
               </div>
               <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <div class="modal-body aligncenter">
                       <div class="form-group">
                           <div class="mt-3">
                               <label class="form-label modal_margin">
                                   <span class="mintxt-modal">Connection removed successfully</span>
                               </label>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="swal-button swal-button--cancel modal_margin" id="delete_ok"
                               data-dismiss="modal">Ok
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
   <!-- End Model -->

   <!--Start Delete Confirm Modal -->
   <div id="approveConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-center">
           <div class="modal-content">
               <div class="modal-header d-block">
                   <div class="swal-icon swal-icon--warning">
                       <span class="swal-icon--warning__body">
                         <span class="swal-icon--warning__dot"></span>
                       </span>
                   </div>
                   <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                       Approval Confirmation
                   </h3>
               </div>
               <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <div class="modal-body aligncenter">
                       <div class="form-group">
                           <div class="mt-3">
                               <label class="form-label modal_margin">
                                   <span class="mintxt-modal">Do you want to approve this job invite?</span>
                               </label>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="swal-button swal-button--confirm bg-success" style="border-radius: 20px; color: #fff;" id="approval_yes">Approve
                       </button>
                       <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" id="appoval_no"
                               data-dismiss="modal">Cancel
                       </button>
                       <input type="hidden" name="userconnectionid" id="userconnectionid" value="">
                   </div>

               </form>
           </div>
       </div>
   </div>
   <!-- End Model -->

   <!--Start Approve Confirm Modal -->
   <div id="approveSuccessModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-center">
           <div class="modal-content">
               <div class="modal-header d-block">
                   <div class="swal-icon swal-icon--warning">
                       <span class="swal-icon--warning__body">
                         <span class="swal-icon--warning__dot"></span>
                       </span>
                   </div>
                   <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                       Done
                   </h3>
               </div>
               <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <div class="modal-body aligncenter">
                       <div class="form-group">
                           <div class="mt-3">
                               <label class="form-label modal_margin">
                                   <span class="mintxt-modal">Connection approved successfully. The chat between you is now open.</span>
                               </label>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="swal-button swal-button--cancel modal_margin" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" id="approve_ok" data-dismiss="modal">Close
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
   <!-- End Model -->

   <!--Start Reject Confirm Modal -->
   <div id="rejectConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-center">
           <div class="modal-content">
               <div class="modal-header d-block">
                   <div class="swal-icon swal-icon--warning">
                       <span class="swal-icon--warning__body">
                         <span class="swal-icon--warning__dot"></span>
                       </span>
                   </div>
                   <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                       Reject Confirmation
                   </h3>
               </div>
               <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <div class="modal-body aligncenter">
                       <div class="form-group">
                           <div class="mt-3">
                               <label class="form-label modal_margin">
                                   <span class="mintxt-modal">Do you want to reject the invite?</span>
                               </label>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #fb9300; border: 1px solid #fb9300; color: #fff;" id="reject_yes">Reject
                       </button>
                       <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" id="reject_no"
                               data-dismiss="modal">Cancel
                       </button>
                       <input type="hidden" name="userconnectionid" id="userconnectionid" value="">
                   </div>

               </form>
           </div>
       </div>
   </div>
   <!-- End Model -->

   <!--Start Reject Success Modal -->
   <div id="rejectSuccessModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-center">
           <div class="modal-content">
               <div class="modal-header d-block">
                   <div class="swal-icon swal-icon--warning">
                       <span class="swal-icon--warning__body">
                         <span class="swal-icon--warning__dot"></span>
                       </span>
                   </div>
                   <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                       Done
                   </h3>
               </div>
               <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <div class="modal-body aligncenter">
                       <div class="form-group">
                           <div class="mt-3">
                               <label class="form-label modal_margin">
                                   <span class="mintxt-modal">Connection rejected successfully</span>
                               </label>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="swal-button swal-button--cancel modal_margin" id="reject_ok"
                               data-dismiss="modal">Ok
                       </button>
                   </div>
               </form>
           </div>
       </div>
   </div>
   <!-- End Model -->
@endsection

@section('js')
   <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
{{--    <script src="{{ mix('js/app.js') }}"></script>--}}
   <script>

      var hasProfile = @json(UserHelper::hasProfile());
       if(!hasProfile) {
           $.ajax({
               url: '/user/check-new',
               type: 'GET',
               success: function (response) {
                   if (response.is_new === 1) {
                       var intro = introJs().setOptions({
                           steps: [{
                               title: null,
                               element: document.querySelector('.card__image'),
                               intro: '<div class="intro-container"><h2 class="intro-title">Let us get to know you better!</h2><p>Complete your personal profile to access the platform. </br> It takes 1 minute.</p><a id="profileButton" href="/provider/manage-profile" style="display: block; border: 0; padding: 17px 20px; border-radius: 7px; background-color: #253159; margin-top: 39px; color: white;">Create My Profile</a></div>'
                           }]
                       });

                       intro.start();
                   }
               },
               error: function (error) {
                   console.log(error);
               }
           });
       }

   </script>



   <script>
       // Enable pusher logging - don't include this in production
       Pusher.logToConsole = false;

       var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
           encrypted: false,
           cluster: "{{ config('chatify.pusher.options.cluster') }}",
           authEndpoint: '{{route("pusher.auth")}}',
           auth: {
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           }
       });

       var channel = pusher.subscribe('private-chatify');

       channel.bind('client-contactItem', function () {

           var chats = @json($allUsersJobs);
           var chatCount = {};
           var chatData = chats.data;

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           chatData.forEach(function (chat) {

               var chatContainer = $("#chatbtn");
              var provider_id = chatContainer.find('chatCount-'+ chat.conid);

               let previousCount = $('#chatCount-'+ chat.conid).text()
               isGetUnseenMessageCountRunning = true;

               function getUnseenMessageCount(userId, connectionId) {
                   //Make an AJAX call to a route on your server
                   $.ajax({
                       "type": 'GET',
                      // url: "/get-unseen-message-count",
                       url: "{{ url('/get-unseen-message-count') }}",

                       data: {
                           connectionId: connectionId,
                           userId: userId,
                           _token: '{{csrf_token()}}'
                       },
                       success: function (data) {
                           if (data.count != previousCount) {
                                $('#chatCount-'+ chat.conid).text(data.count);
                                var clientName = $('#chatMessage-' + chat.conid).closest('h3').find('strong').text().trim();
                                $('#chatMessage-' + chat.conid).text("You have a New Message from " + clientName);
                                previousCount = data.count;
                           }else {
                               return false;
                           }

                       },  complete: function() {
                           isGetUnseenMessageCountRunning = false;
                       }

                   });

                   return false;
               }
               if (Array.isArray(chat['provider_id']) || chat['provider_id'].length != 0) {
                    getUnseenMessageCount(chat['provider_id'],chat['conid']);
                }
           });
       })

   </script>
   <script>

        var Pusher2 = new Pusher("{{ config('chatify.pusher.key') }}", {
            encrypted: false,
            cluster: "{{ config('chatify.pusher.options.cluster') }}",
            authEndpoint: '{{route("pusher.auth")}}',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });
        Pusher2.logToConsole = false;

        var channel2 = Pusher2.subscribe('private-chatify-notification');
        {{--<span id="chatCount-{{ $post['id'] }}">{{ UserHelper::getUnseenCount($post['id'],$post['job_userid']) }}</span>--}}
        channel2.bind('messaging', function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function NewJobNotification() {
            isGetNewJobNotificationRunning = true;
            let page = getParameterByName('page');
            $.ajax({
                type: 'GET',
                url: "{{ url('/get-new-job-notification-provider') }}",
                data: {
                    page : page,
                    _token: '{{csrf_token()}}'
                },
                success: function (data) {
                    // console.log(data);
                    $(".contentJobProvider").html('');
                    $(".contentJobProvider").append(data.html);
                },
                complete: function() {
                    isGetNewJobNotificationRunning = false;
                }
            });

            return false;
        }

        NewJobNotification();
        // chatData2.forEach(function (chat) {
        function getParameterByName(name) {
            let url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            let regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
        
        // });
    })
    </script>
   <script src="{{ asset('js/chatify/code.js') }}"></script>
   <script>
       // Messenger global variable - 0 by default
       messenger = "{{ @$id }}";
   </script>


   <script>

       $("#delete_yes, #reject_yes").click(function (e) {
           var connectid = $("#userconnectionid").val();
           var id = $(this).attr('id');
           e.preventDefault();
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "{{ url('provider/cancelconnection') }}",
               "type": "POST",
               data: {
                   connectid: connectid,
                   _token: '{{csrf_token()}}'
               },
               success: function (response) {
                   // console.log(response);
                   if (response.success == '1') {
                       if(id == 'reject_yes'){
                           $("#rejectConfirmModal").modal('hide');
                           $("#rejectSuccessModal").modal('show');
                       }else {
                           $("#deleteConfirmModal").modal('hide');
                           $("#deleteSuccessModal").modal('show');
                       }
                   }else {
                       alert('something went wrong, contact support');
                   }
               },
               error: function (jqXHR, testStatus, error) {
                   console.log(error);
                   alert('something went wrong, contact support');
               }
           });
       });

       $("#delete_ok,#approve_ok,#reject_ok").click(function (e) {
           e.preventDefault();
           var id = $(this).attr('id');

           if(id == 'reject_ok'){
               $("#rejectSuccessModal").modal('hide');
           }
           else if(id == 'approve_ok'){
               $("#approveSuccessModal").modal('hide');
           }
           else {
               $("#deleteSuccessModal").modal('hide');
           }

           var SITEURL = '{{URL::to('')}}';
           window.location.href = SITEURL + '/provider/dashboard';

       });

       $("#approval_yes").click(function (e) {
           var connectid = $("#userconnectionid").val();
           e.preventDefault();

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "{{ url('provider/approve-connection') }}",
               "type": "POST",
               data: {
                    connectid: connectid,
                    userId: connectid,
                   _token: '{{csrf_token()}}'
               },
               success: function (response) {
                   // console.log(response);
                   if (response.success == '1') {
                       $("#approveConfirmModal").modal('hide');
                       $("#approveSuccessModal").modal('show');
                   }else {
                       alert('something went wrong, contact support');
                   }
               },
               error: function (jqXHR, testStatus, error) {
                   console.log(error);
                   alert('something went wrong, contact support');
               }
           });
       });

       function approveConnect(connectid) {
           $("#approveConfirmModal").modal('show');
           $("#userconnectionid").val(connectid);
       }

       function openEdOpts(element) {
            $(element).next(".ed-options").toggleClass("active");
        }

       function cancelconnect(connectid,btnpressed) {

           if (btnpressed == 'rejectbtn') {
               $("#rejectConfirmModal").modal('show');
               $("#userconnectionid").val(connectid);
           } else {
               $("#deleteConfirmModal").modal('show');
               $("#userconnectionid").val(connectid);
           }
       }
       
        function backlist() {
           if ($(".modal").is(":visible")) {
               $("#modal_aside_right").hide();
               $('.modal-backdrop').hide();
               $('body').css('overflow', 'auto');
           }
        }
       
        function viewfullprofile(jobid, conid, msgwindow) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('provider/viewjobdetails') }}",
                /*async: false,*/
                "type": "POST",
                data: {
                    jobid: jobid,
                    conid: conid,
                    fullconnect: msgwindow,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    if (response.success == '1') {
                        $("#modal_aside_right").show();
                        $('.modal-backdrop').show();
                        $('body').css('overflow', 'hidden');
                        $('.searchsidemodalId').html(response.html);

                        if(msgwindow == 'messagewindow'){
                            $(".messageclass").addClass("active");
                            $(".profileclass").removeClass("active");
                            $('#pills-home').hide();
                            $('#pills-document').hide();
                            $('#pills-message').tab('show');
                            $("#shareAndViewDocuments").show();
                        }
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

        function viewDocuments(jobid, conid, msgwindow) {
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $.ajax({
               url: "{{ url('provider/viewjobdetails') }}",
               /*async: false,*/
               "type": "POST",
               data: {
                   jobid: jobid,
                   conid: conid,
                   fullconnect: msgwindow,
                   _token: '{{csrf_token()}}'
               },
               success: function (response) {
                   if (response.success == '1') {
                    $("#modal_aside_right").show();
                        $('.modal-backdrop').show();
                        $('body').css('overflow', 'hidden');
                        $('.searchsidemodalId').html(response.html);
                        $('#pills-home').removeClass('show active');
                        $('#pills-message').removeClass('show active');
                        $('#pills-document').addClass('show active');
                        $('#pills-document').show();
                        $('#pills-message').hide();
                        $('#pills-home').hide();
                        $('.searchsidemodalId').addClass('show');
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

       $(document).ready(function () {
           $('[data-toggle="tooltip"]').tooltip();

           $(document).on('click', '#pills-home-tab', function (e) {
               $("#modal_aside_right").show();
               $('.modal-backdrop').show();
               $('#pills-home').show();
               $('#pills-message').hide();
               $("#shareAndViewDocuments").hide();
               $('#pills-document').hide();
           });

           $(document).on('click', '#pills-message-tab', function (e) {
               $("#modal_aside_right").show();
               $('.modal-backdrop').show();
               $('#pills-message').show();
               $("#shareAndViewDocuments").show();
               $('#pills-home').hide();
               $('#pills-document').hide();
           });

           $(document).on('click', '#pills-document-tab', function (e) {
               $("#modal_aside_right").show();
               $('.modal-backdrop').show();
               $('#pills-document').show();
               $('#pills-message').hide();
               $("#shareAndViewDocuments").hide();
               $('#pills-home').hide();
           });


           $("body").click(function (event) {
                var senderId = $("#getCloseChat").data('sender-id');
                var rceiver = $("#getCloseChat").data('rceiver-id');
                if ($('.searchsidemodalId').children().length > 0) {
                    if (!$(event.target).closest('#openModal').length && !$(event.target).is('#openModal')) {

                        if ($(".modal").is(":visible")) {
                            closeChat(senderId,rceiver);
                            $(".modal").hide();
                            $('.modal-backdrop').hide();
                            $('body').css('overflow', 'auto');
                        }
                    }
                }
           });

       });
       $(document).ready(function () {

            $(document).on('click', '.btn-block-access', function (e) {
                e.preventDefault();
                let documentId = $(this).data('id');
                let seekerId = $(this).data('id-seeker');
                let providerId = $(this).data('id-provider');
                let button = $(this);

                $.ajax({
                    url: '{{ route("documents.block-access") }}',
                    type: 'POST',
                    data: {
                        document_id: documentId,
                        seeker_id: seekerId,
                        provider_id: providerId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        button.closest('.boxSentRequest').remove();
                        console.log(response.message);
                    },
                    error: function(response) {
                        console.log('Error: ' + response.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '.btn-grant-access', function (e) {
                e.preventDefault();
                let documentId = $(this).data('id');
                let seekerId = $(this).data('id-seeker');
                let providerId = $(this).data('id-provider');
                let referenceId = $(this).data('id-reference');

                let button = $(this);

                $.ajax({
                    url: '{{ route("documents.grant-access") }}',
                    type: 'POST',
                    data: {
                        document_id: documentId,
                        seeker_id: seekerId,
                        provider_id: providerId,
                        reference_id: referenceId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        button.closest('.boxSentRequest').remove();
                    },
                    error: function(response) {
                        console.log('Error: ' + response.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '#shareDocuments', function (e) {
                $('#pills-home').removeClass('show active');
                $('#pills-message').removeClass('show active');
                $('#pills-document').addClass('show active');
                $('#pills-message').hide();
                $('#pills-home').hide();
                var name = $(".chatNameProvClient").data("name");
                $(".chatNameProvClient").html("<a id='clickBackToChat'><i class='la la-angle-left'></i></a><span >Documents Permissions <strong>"+name+"</strong></span>");
            });

            $(document).on('click', '.btn-block-access-dropdown', function (e) {
                e.preventDefault();
                let documentId = $(this).data('id');
                let seekerId = $(this).data('id-seeker');
                let providerId = $(this).data('id-provider');
                let referenceId = $(this).data('id-reference');
                let button = $(this);

                $.ajax({
                    url: '{{ route("documents.block-access") }}',
                    type: 'POST',
                    data: {
                        document_id: documentId,
                        reference_id: referenceId,
                        seeker_id: seekerId,
                        provider_id: providerId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        button.closest('.alignItems').replaceWith(
                            '<div class="alignItems">' +
                            '<a class="btn btn-blocked">Blocked (Only visible to you)</a>' +
                            '<div class="col-1">' +
                            '<i class="la la-ellipsis-v ed-opts-open three-dots-provider" onclick="openEdOpts(this);"></i>' +
                            '<ul class="ed-options">' +
                            '<li data-id="' + documentId + '" data-id-seeker="' + seekerId + '" data-id-provider="' + providerId + '" data-id-reference="' + referenceId + '" class="btn-grant-access-dropdown">Grant Access</li>' +
                            '</ul>' +
                            '</div>' +
                            '</div>'
                        );
                    },
                    error: function(response) {
                        console.log('Error: ' + response.responseJSON.message);
                    }
                });
            });

            $(document).on('click', '.btn-grant-access-dropdown', function (e) {
                e.preventDefault();
                let documentId = $(this).data('id');
                let seekerId = $(this).data('id-seeker');
                let providerId = $(this).data('id-provider');
                let referenceId = $(this).data('id-reference');
                let button = $(this);

                $.ajax({
                    url: '{{ route("documents.grant-access") }}',
                    type: 'POST',
                    data: {
                        document_id: documentId,
                        reference_id: referenceId,
                        seeker_id: seekerId,
                        provider_id: providerId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        button.closest('.alignItems').replaceWith(
                        '<div class="alignItems">' +
                        '<a class="btn-success-granted disabled">' +
                        '<img src="/imgs/granted.png" width="16" height="16">' +
                        'Granted' +
                        '</a>' +
                        '<div class="col-1">' +
                        '<i class="la la-ellipsis-v ed-opts-open three-dots-provider" onclick="openEdOpts(this);"></i>' +
                        '<ul class="ed-options">' +
                        '<li data-id="' + documentId + '" data-id-seeker="' + seekerId + '" data-id-provider="' + providerId + '" data-id-reference="' + referenceId + '" class="btn-block-access-dropdown">Block Access</li>' +
                        '</ul>' +
                        '</div>' +
                        '</div>'
                    );
                    },
                    error: function(response) {
                        console.log('Error: ' + response.responseJSON.message);
                    }
                });
            });
            $(document).on('click', '#clickBackToChat', function (e) {
                $('#pills-home').removeClass('show active');
                $('#pills-message').addClass('show active');
                $('#pills-document').removeClass('show active');
                $('#pills-document').hide();
                $('#pills-message').show();
                $('#pills-home').hide();
                var name = $(".chatNameProvClient").data("name");
                $(".chatNameProvClient").html("<span> "+name+"</span>");
            });
            
       });
   </script>
@endsection
