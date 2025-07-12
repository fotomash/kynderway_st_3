@extends('layouts.master_user')

@section('css')
    <style>
        .modal {
            overflow: auto !important;
        }

        .post-vacancy-edit-modal .modal-content,.post-vacancy-edit-modal .modal-header{
        border-radius: 1rem !important;
        background-color: #fff;
        border: none !important;
        }

        .post-vacancy-edit-modal .close{
        position: inherit;
        color: #2f2f2f;
        opacity: 1;
        border: none !important;
        border-radius: 0;
        font-size: 2rem;
        float: none;
        font-weight: lighter;
        display: block;
        margin: .5rem .5rem .5rem auto;
        padding: 0;
        }

        .post-vacancy-edit-modal .title-h3{
        font-weight:bold;
        font-size: 1.3rem;
        color: #304384;
        }

        .post-vacancy-edit-modal .edit-header{
        background-color: #ecedf3;
        padding: .4rem;
        border-radius: 1rem;
        font-size: .8rem;
        text-align: right;
        color: #686868;
        }
        .post-vacancy-edit-modal .edit-header a,.post-vacancy-edit-modal .edit-header a:hover{
        color: #686868;
        }


        .post-vacancy-edit-modal .modal-body .row .col-3{
        color: #686868;
        }

        .post-vacancy-edit-modal .btn.btn-kinderway-2{
        background-color:rgb(48, 67, 132);
        border-radius: 3rem;
        margin: auto;
        display: block;
        padding: .5rem 2rem;
        border-color: rgb(48, 67, 132);

        }

        .post-vacancy-edit-modal .btn.btn-kinderway-2:hover {
        background-color: #8c50a0;
        border-color: #8c50a0;
        }
    </style>

    @if (App::environment('production'))

        <!-- Event snippet for Registered Private/Business Offer conversion page -->
        <script> gtag('event', 'conversion', {'send_to': 'AW-499387801/gHEYCM7i-cICEJmbkO4B'}); </script>

    @endif

@endsection

@section('dashboard')
    active
@endsection

@section('content')
    <section class="profile-account-setting">
        <div class="container">
            <div class="account-tabs-setting">
                @include('shared.response_msg')
                <div class="row mb-4">
                 
                    @if(Auth::user()->delete_request == 1)
                        <p class="alert alert-warning mt-3">
                            You have been reported by other Users. Admin is reviewing your pending reports and will contact you soon.
                        </p>
                    @endif
                </div>
                <div class="row">
                    @include('shared.sidebar', ['active' => 'dashboard'])
                    <div class="col-lg-9 pad-right-mob">
                        <h3 class="pb-2 title-h3" style="font-weight:bold;font-size: 26px; color: #304384;">My Job Posts</h3>
                        <hr class="bold" />
                        <p class="mb-3" style="color: #686868;">Below you can track candidates who applied for your job or responded to your invitation.</p>
                            <div class="contentJobCLient">
                            @if($total_dashbrd_jobs >0)
                                @foreach($alluser_jobs as $key=>$alljobs)
                                    <div class="tab-pane fade show active" id="nav-acc" role="tabpanel"
                                        aria-labelledby="nav-acc-tab">
                                        <div class="acc-setting shadow mb-4">
                                            <div class="posts-section">
                                                <div class="post-bar" style="margin-bottom: 0;">
                                                    <div class="post_topbar">
                                                        {{-- <div class="usy-dt"> --}}
                                                            <div class="row">
                                                                <div class="col-1 pl-0 pr-0 remove">
                                                                    <img src="{{ UserHelper::getIcon($alljobs['profile_category_id']) }}" width="50" />
                                                                </div>
                                                                <div class="col-11 pl-0 pr-0 mob-max-width">
                                                                    <div class="usy-name" style="display: inline-block; width: 93%;">
                                                                        <h3 style="font-size: 17px;">{{ $alljobs['jobtitle'] }}</h3>
                                                                        <span><i class="far fa-clock"></i> Posted {{ Carbon\Carbon::parse($alljobs['created_at'])->diffForHumans()  }}</span>
                                                                    </div>
                                                                    <div class="ed-opts">
                                                                        <a href="#" title="" class="ed-opts-open" style="cursor: pointer;">
                                                                            <i class="la la-ellipsis-v" style="color: #fff;"></i></a>
                                                                        <ul class="ed-options">
                                                                            <li onCLick="showEditPopup({{$alljobs->id}});"><a href="#">Edit Job</a></li>
                                                                            <li onclick="linkToClipboard('{{ env('APP_URL').'jobs/'.$alljobs->slug }}');"><a href="#">Copy/Share Link</a></li>
                                                                            <li onclick="editJobNote({{$alljobs->id}}, '{{ $alljobs->notes }}');"><a href="#">Edit Note</a></li>
                                                                            <li onclick="viewJobPost({{$alljobs->id}});" title="" data-toggle="modal" data-target="#modal_aside_right_view"><a href="#">View Job</a></li>
                                                                            <li onclick="deleteJobConfirm({{$alljobs->id}});" title=""><a href="#">Delete Job</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="epi-sec">
                                                        <hr style="margin-top: 0;"/>
                                                    </div>
                                                    <div class="job_descp">
                                                        <div class="row" id="mainjobdiv">
                                                            @if(count( $alljobs->userconnection) > 0)

                                                            @foreach ($alljobs->userconnection as $post)
                                                            @if($loop->iteration <= 4)
                                                            <div class="col-lg-12 pl-0 pr-0"  id="job_{{$alljobs->id}}_connection_{{$post['id']}}">
                                                                <div class="post-topbar mt-1 mb-1"
                                                                    style="border-top: 1px solid #e5e5e5; background-color: #f7f7f7">
                                                                    <div class="row">
                                                                        <div class="col-md-8 p-0">
                                                                            <div class="user-picy">
                                                                                <img src="{{ UserHelper::getProfilePic($post['provider_id']) }}" style="border-radius: 14px;" alt="">
                                                                            </div>
                                                                            <h3 style="display: inline-block; padding-left:12px; padding-top:18px;">
                                                                                {{ UserHelper::getUserName($post['provider_id']) }}
                                                                            </h3>
                                                                            <span class="float-right-desktop" style="break-word;overflow-wrap: break-word;width: 70%;font-size: 14px; font-style: italic; color: #304384; font-weight: bold; padding-top: 15px;" id="chatMessage-{{ $post['id'] }}">

                                                                                @if(!$post->jobconnect)
                                                                                    @if($post['requested_by'] == 'service_provider')
                                                                                        {{$post['NameProvider']}} has applied to your {{$post['categoryname']}} job offer.
                                                                                    @endif
                                                                                @endif
                                                                                @if($post->jobconnect)
                                                                                    @if(UserHelper::getTotalCount($post['id'],$post['provider_id']) == 0 && $post['requested_by'] != 'service_provider')
                                                                                        @if(UserHelper::getUnseenCount($post['id'],$post['job_userid']) > 0)
                                                                                            {{$post['NameProvider']}} has accepted your job invitation. <br>You have a New Message from {{$post['NameProvider']}}
                                                                                        @else
                                                                                            {{$post['NameProvider']}} has accepted your job invitation. <br>Chat with  {{$post['NameProvider']}} now
                                                                                        @endif
                                                                                    @elseif (UserHelper::getTotalCount($post['id'],$post['job_userid']) == 0 && $post['requested_by'] == 'service_provider')
                                                                                        Chat with  {{$post['NameProvider']}} now.
                                                                                    @elseif(UserHelper::getUnseenCount($post['id'],$post['job_userid']) > 0)
                                                                                        You have a New Message
                                                                                    @endif
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-4 p-0">
                                                                            <div class="row">
                                                                            <div class="col-11 p-0">
                                                                            
                                                                            <ul class="bk-links mt-2">
                                                                                @if($post->jobconnect)
                                                                                <li><a id="chatbtn" type="button" data-toggle="modal" class="message_now" style="color: #fff; padding: 0 5px;"
                                                                                    @if($alljobs->adstatus && $post->profile->status)
                                                                                        data-target="#modal_aside_right" onclick="viewFullProfile({{ $post['providerprofileid'] }}, {{ $post['id'] }},'messagewindow' );"
                                                                                    @else
                                                                                        @if(!$alljobs->adstatus)
                                                                                            data-target="#suspended-job"
                                                                                        @else
                                                                                            data-target="#suspended-profile"
                                                                                        @endif
                                                                                    @endif
                                                                                    >
                                                                                        <i class="fas fa-comment" style="background-color: transparent; width:45px;">
                                                                                            <span id="chatCount-{{ $post['id'] }}">{{ UserHelper::getUnseenCount($post['id'],$post['job_userid']) }}</span>
                                                                                        </i>
                                                                                    </a></li>

                                                                            
                                                                                @else
                                                                                    <li><a type="button" class="cancel" title="Approve"
                                                                                        @if($alljobs->adstatus && $post->profile->status)
                                                                                            data-toggle="tooltip"
                                                                                            data-placement="bottom"
                                                                                            onclick="approveConnect({{ $post['id'] }});"
                                                                                        @else
                                                                                            @if(!$alljobs->adstatus)
                                                                                                data-target="#suspended-job" data-toggle="modal"
                                                                                            @else
                                                                                                data-target="#suspended-profile" data-toggle="modal"
                                                                                            @endif
                                                                                        @endif
                                                                                    style="color: #fff; padding: 0;"><i class="la la-check bg-success"></i></a>
                                                                                    </li>
                                                                                    <li><a type="button"
                                                                                        class="cancel"
                                                                                        title="Reject"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="bottom"
                                                                                        onclick="cancelConnect({{ $post['id'] }},'rejectbtn');"
                                                                                        style="color: #fff; padding: 0;"><i class="la la-close" style="background-color: #fb9300;"></i></a>
                                                                                    </li>
                                                                                @endif
                                                                                <li><a type="button" class="bid_now"
                                                                                    style="color: #fff; padding: 0 20px;"
                                                                                    data-toggle="modal"
                                                                                    @if($alljobs->adstatus && $post->profile->status)
                                                                                        onclick="viewFullProfile({{ $post['providerprofileid'] }}, {{ $post['id'] }}, {{ $post['jobconnect'] }});"
                                                                                        data-target="#modal_aside_right">
                                                                                    @else
                                                                                        @if(!$alljobs->adstatus)
                                                                                            data-target="#suspended-job">
                                                                                        @else
                                                                                            data-target="#suspended-profile">
                                                                                        @endif
                                                                                    @endif
                                                                                    View Profile</a>
                                                                                </li>
                                                                            </ul>
                                                                            </div>
                                                                            <div class="col-1 p-0">
                                                                                <i class="la la-ellipsis-v ed-opts-open three-dots-provider mt-2" style="cursor: pointer;"></i>
                                                                                <ul class="ed-options">
                                                                                    <li onclick="editApplicationNote({{ $post['id'] }}, '{{ $post['notes'] }}');"><a href="#">Edit Note</a></li>
                                                                                    <li onclick="viewDocuments({{ $post['providerprofileid'] }}, {{ $post['id'] }}, {{ $post['jobconnect'] }});"  data-target="#modal_aside_right"><a href="#">View Documents</a></li>
                                                                                    @if($post->jobconnect)
                                                                                        <li onclick="cancelConnect({{ $post['id'] }}, 'deletebtn');">Delete Connection</li>
                                                                                    @endif
                                                                                    <li onclick="reportConnect({{ $post['providerprofileid'] }}, 'Report Profile');">Report Profile</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @endforeach

                                                                @if(count($alljobs->userconnection) >4)
                                                            <div class="col-lg-12 text-center mt-4 seemorebtn{{ $alljobs->id}}">
                                                                <input type="hidden" name="jobattachid" id="jobattachid"
                                                                    value="{{ $alljobs->id  }}"/>
                                                                <input type="hidden" name="skipval{{ $alljobs->id  }}"
                                                                    id="skipval{{ $alljobs->id  }}" value="4"/>
                                                                <input type="hidden" name="totalpply{{ $alljobs->id  }}"
                                                                    id="totalapply{{ $alljobs->id  }}"
                                                                    value="{{ count( $alljobs->userconnection) }}"/>

                                                                <a type="button" onclick="loadMore({{$alljobs->id}});"
                                                                class="bid_now show_more_now{{$alljobs->id}}"
                                                                style="color: #fff; padding: 6px 24px;">SEE MORE
                                                                    <span class="setcounter{{$alljobs->id}}">
                                                                    ({{ count($alljobs->userconnection) - 4 }}) </span>
                                                                </a>

                                                            
                                                            </div>
                                                                @endif
                                                            @else
                                                            <div id="job_{{$alljobs->id}}_connection_0" class="col-lg-12 pl-0 pr-0" >
                                                                <div style="text-align:center; padding: 20px 20px 20px 20px; color: #884d9b; font-weight:bold; border-radius: 20px; width:100%;">
                                                                    No applications
                                                                </div>
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <div class="job-status-bar">
                                                        <div class="row">
                                                            <div class="col-lg-6 pl-0">
                                                                <ul class="like-com" style="margin-top:30px;">
                                                                    <li>
                                                                        <a class="com"> Ad Status:
                                                                            @if ($alljobs->expirydt >= date('Y-m-d'))
                                                                                @if($alljobs->adstatus)
                                                                                    <strong style="color: green;">Active</strong>
                                                                                @else
                                                                                    <strong style="color: #fb9300;">Suspended By {{ $alljobs->suspendBy }}</strong>
                                                                                @endif
                                                                            @else
                                                                                <strong style="color: #fb9300;">Will remove in {{Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($alljobs->grace_date))}} days</strong>
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-lg-6 text-right no-pad-top-mob post-status pr-0">
                                                                <a href="#" class=""> Applications <strong>{{ count( $alljobs->userconnection) }}</strong></a>
                                                                <a href="#" class=""> Views <strong>{{ ($alljobs->view_count != '') ? $alljobs->view_count : '0' }}</strong></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <div class=""
                                    style="text-align:center; padding: 20px 20px 20px 20px; color: #884d9b; font-weight:bold; border-radius: 20px; width:100%;">
                                    No Jobs Posted
                                </div>
                            @endif
                            <div class="job_pagin_links">
                                {{ $alluser_jobs->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="modal_aside_right" class="modal fixed-left fade searchsidemodalId pr-0" tabindex="-1" role="dialog">
    </div>

    <div id="modal_aside_right_view" class="modal fixed-left fade viewsidemodalId pr-0" tabindex="-1" role="dialog">
    </div>

    <!--Start Delete Job Post Confirm Modal -->
    <div id="deleteJobConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
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
                       Delete Confirmation
                   </h3>
               </div>
               <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <div class="modal-body aligncenter">
                       <div class="form-group">
                           <div class="mt-3">
                               <label class="form-label modal_margin">
                                   <span class="mintxt-modal">Are you sure you want to delete this Job Post?</span>
                               </label>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #fb9300; border: 1px solid #fb9300; color: #fff;" id="delete_job_yes">Delete
                       </button>
                       <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" id="delete_job_no"
                               data-dismiss="modal">Cancel
                       </button>
                       <input type="hidden" name="userconnectionid" id="userconnectionid" value="">
                   </div>

               </form>
           </div>
       </div>
   </div>
   <!-- End Modal -->


    <!--Start Delete Confirm Modal -->
    <div id="deleteConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
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
                        <input type="hidden" name="userconnectionid" id="userconnectionid" value="">
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- End Model -->

    <!--Start Delete Confirm Modal -->
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
    <div id="statusSuccessModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
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
                        Success
                    </h3>
                </div>
                <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body aligncenter">
                        <div class="form-group">
                            <div class="mt-3">
                                <label class="form-label modal_margin">
                                    <span class="mintxt-modal changetxt">Job Status Changed Successfully</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="swal-button swal-button--cancel modal_margin" id="status_ok"
                                data-dismiss="modal">Ok
                        </button>
                        <input type="hidden" name="chkJobDelete" id="chkJobDelete" value=""/>
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
                                    <span class="mintxt-modal">Do you want to approve the application?</span>
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
                                    <span class="mintxt-modal">Do you want to reject the application?</span>
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

    <div class="modal fade post-vacancy-edit-modal" id="post-vacancy-edit" tabindex="-1" role="dialog" aria-labelledby="post-vacancy-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body p-4">
            </div>
            <div class="modal-footer">
              <a href="#" id="submit-edit-form" class="btn btn-kinderway-2">Edit Now</a>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

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
        {{--<span id="chatCount-{{ $post['id'] }}">{{ UserHelper::getUnseenCount($post['id'],$post['job_userid']) }}</span>--}}
        channel.bind('client-contactItem', function () {

            var chats = @json($alluser_jobs);
            var chatCount = {};
            var chatData = chats.data;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            chatData.forEach(function (chat) {
              
                    let isGetUnseenMessageCountRunning = false;

                    function getUnseenMessageCount(userIds, connectionId) {  
                        if (!Array.isArray(userIds) || userIds.length === 0) {
                            return;
                        }

                        let userId = userIds[0].id;

                        if (!userId) {
                            console.error('userId is not defined');
                            return;
                        }

                        let previousCount = $('#chatCount-' + userId).text();

                        if (isGetUnseenMessageCountRunning) {
                            return;
                        }

                        isGetUnseenMessageCountRunning = true;

                        $.ajax({
                            type: 'GET',
                            url: "{{ url('/get-unseen-message-count') }}",
                            data: {
                                connectionId: userId,
                                userId: connectionId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (data) {
                                if (data.count != previousCount) {
                                    $('#chatCount-' + userId).text(data.count);
                                    console.log('#chatMessage-' + userId);
                                    $('#chatMessage-' + userId).text("You have a New Message");
                                    previousCount = data.count;
                                }
                            },
                            complete: function () {
                                isGetUnseenMessageCountRunning = false;
                            },
                            error: function (xhr, status, error) {
                                console.error('Error fetching unseen message count:', status, error);
                                isGetUnseenMessageCountRunning = false;
                            }
                        });

                        return false;
                    }
              
                    if (Array.isArray(chat['userconnection']) || chat['userconnection'].length != 0) {
                        getUnseenMessageCount(chat['userconnection'],chat['user_id']);
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
                    url: "{{ url('/get-new-job-notification') }}",
                    data: {
                        page : page,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        // console.log(data);
                        $(".contentJobCLient").html('');
                        $(".contentJobCLient").append(data.html);
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

        var deletejobid = undefined;
        $("#status_ok").click(function (e) {
            e.preventDefault();
            $("#statusSuccessModal").modal('hide');
            var chkJobDelete = $("#chkJobDelete").val();
            if(chkJobDelete == 'jobdel'){
                var siteurl = '{{ URL::to('')}}' + '/user/client/dashboard';
                window.location.href = siteurl;
            }else {
                location.reload();
            }
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
                url: "{{ url('user/client/approve-connection') }}",
                "type": "POST",
                data: {
                    connectid: connectid,
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

        $("#delete_ok, #reject_ok, #approve_ok").click(function (e) {
            e.preventDefault();
            var id = $(this).attr('id');

            if(id == 'reject_ok'){
                $("#rejectSuccessModal").modal('hide');
            }else if(id == 'approve_ok'){
                $("#approveSuccessModal").modal('hide');
            }
            else{
                $("#deleteSuccessModal").modal('hide');
            }
            location.reload();
        });

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
                url: "{{ url('user/client/cancel-connection') }}",
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

        function openEdOpts(element) {
            $(element).next(".ed-options").toggleClass("active");
        }

        function cancelConnect(connectid,btnpressed) {
            if (btnpressed == 'rejectbtn') {
                $("#rejectConfirmModal").modal('show');
                $("#userconnectionid").val(connectid);
            } else {
                $("#deleteConfirmModal").modal('show');
                $("#userconnectionid").val(connectid);
            }
        }

        function approveConnect(connectid) {
            $("#approveConfirmModal").modal('show');
            $("#userconnectionid").val(connectid);
        }
    

        function showEditPopup(id){
            $('#post-vacancy-edit').modal('show');
            let url = '{{ env('APP_URL')}}';
            $('#submit-edit-form').attr('href',url + 'user/client/post-vacancy/' + id);

            $.ajax({
                url: url + 'user/client/post-vacancy-model/' + id,
                "type": "GET",
                success: function(response) {
                    console.log(response);
                        $('#post-vacancy-edit .modal-body').html(response);
                        $('#submit-edit-form').attr('href',url + 'user/client/post-vacancy/' + id);
                        $('#post-vacancy-edit a.goto-edit[data-target="0"]').attr('href',url + 'user/client/post-vacancy/' + id + '#edit-section-1');
                        $('#post-vacancy-edit a.goto-edit[data-target="1"]').attr('href',url + 'user/client/post-vacancy/' + id + '#edit-section-2');
                        $('#post-vacancy-edit a.goto-edit[data-target="2"]').attr('href',url + 'user/client/post-vacancy/' + id + '#edit-section-3');

                        $('#post-vacancy-edit').modal('show');
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                }
            });
        }
        
        
        function loadMore(jobid) {
            var jobattachid = jobid;
            var passjob = "skipval" + jobattachid;
            var jobid = jobattachid;
            var skipval = $('#' + passjob).val();
            var totalapply = $('#totalapply' + jobid).val();

            //Check to show less button:
            if (skipval < totalapply) {
                var chkshowmorebtn = totalapply - skipval;
                if (chkshowmorebtn <= 4) {
                    $('.show_more_now' + jobid).hide(); //hide show more if only less then 4 records
                }
                $('.show_less_now' + jobid).show();
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('user/client/dashboard-loadmore') }}",
                "type": "POST",
                data: {
                    jobid: jobid,
                    skipval: skipval,
                    totalapply: totalapply,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    // console.log(response);
                    if (response.success == '1') {

                        if (response.jobid) {
                            var jid = response.jobid
                            $('#skipval' + jid).val(response.newskip);
                            $(".seemorebtn" + jid).before(response.setNext);

                            if (response.displayremains > 0) {
                                $('.setcounter' + jid).text("(" + response.displayremains + ")");
                            }

                            if (response.displayremains > 0) {
                                $('.setcounter' + jid).text("(" + response.displayremains + ")");
                            }

                            if (response.addremains == 0) {
                                $('.show_more_now' + jid).hide();
                                $('.show_less_now' + jid).show();
                            }
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

        };

        function backList() {
            if ($(".modal").is(":visible")) {
                $("#modal_aside_right_view").hide();
                $("#modal_aside_right").hide();
                $('.modal-backdrop').hide();
                $('body').css('overflow', 'auto');
            }
        };

        function viewFullProfile(profileid, conid, msgwindow = '') {

            var currpopup = profileid;
            if(msgwindow == 'messagewindow'){
                clearChat(conid);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('user/client/view-userdetails') }}",
                "type": "POST",
                data: {
                    currpopup: currpopup,
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
                            $('#pills-message').tab('show');
                            $("#shareAndViewDocuments").show();
                            //openChat();
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

        function viewDocuments(profileid, conid, msgwindow = '') {

            var currpopup = profileid;
            if(msgwindow == 'messagewindow'){
                clearChat(conid);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('user/client/view-userdetails') }}",
                "type": "POST",
                data: {
                    currpopup: currpopup,
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

        function deleteJobConfirm(id) {
            //set job id global to this js file
            deletejobid = id;

            //show delete job confirm modal
            $('#deleteJobConfirmModal').modal('show');
        }

        $("#delete_job_yes").click(function (e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('user/client/delete-job') }}",
                "type": "POST",
                data: {
                    jobid: deletejobid,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    if (response.success == '1') {
                        $("#statusSuccessModal").modal('show');
                        $("#chkJobDelete").val("jobdel");
                        $(".changetxt").text("Job deleted Successfully");
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

        $("#delete_job_no").click(function (e) {
            $('#deleteJobConfirmModal').modal('hide');
        });

        function jobStatusChange(jobid, status) {
            var jobid = jobid
            var jobstatus = status;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('user/client/pause-job') }}",
                "type": "POST",
                data: {
                    jobid: jobid,
                    jobstatus: jobstatus,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    if (response.success == '1') {
                        $("#statusSuccessModal").modal('show');
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

        function viewJobPost(jobid) {
            var jobid = jobid;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('user/client/view-job') }}",
                "type": "POST",
                data: {
                    jobid: jobid,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    if (response.success == '1') {
                        $("#modal_aside_right_view").show();
                        $('.modal-backdrop').show();
                        $('body').css('overflow', 'hidden');
                        $('#modal_aside_right_view').html(response.html);
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

            $(document).on('click', '#pills-profile-tab', function (e) {
                $(".searchsidemodalId").show();
                $('.modal-backdrop').show();
                $('#pills-home').hide();
                $('#pills-message').hide();
                $("#shareAndViewDocuments").hide();
                $('#pills-document').hide();
                $('#pills-profile').show();
            });

            $(document).on('click', '#pills-home-tab', function (e) {
                $(".searchsidemodalId").show();
                $('.modal-backdrop').show();
                $('#pills-home').show();
                $('#pills-message').hide();
                $("#shareAndViewDocuments").hide();
                $('#pills-document').hide();
                $('#pills-profile').hide();
            });

            $(document).on('click', '#pills-message-tab', function (e) {
                $(".searchsidemodalId").show();
                $('.modal-backdrop').show();
                $("#shareAndViewDocuments").show();
                $('#pills-message').show();
                $('#pills-home').hide();
                $('#pills-document').hide();
                $('#pills-profile').hide();
            });
            
            $(document).on('click', '#pills-document-tab', function (e) {
                $(".searchsidemodalId").show();
                $('.modal-backdrop').show();
                $('#pills-message').hide();
                $("#shareAndViewDocuments").hide();
                $('#pills-home').hide();
                $('#pills-document').show();
                $('#pills-profile').hide();
            });

            $("body").click(function (event) {
                var senderId = $("#getCloseChat").data('sender-id');
                var rceiver = $("#getCloseChat").data('rceiver-id');
                if ($('.searchsidemodalId').children().length > 0) {
                    if (!$(event.target).closest('#openModal').length && !$(event.target).is('#openModal')) {
                        if ($("#openModal").is(":visible")) {
                            closeChat(senderId,rceiver);
                            $(".searchsidemodalId").hide();
                            $('.modal-backdrop').hide();
                            $('body').css('overflow', 'auto');
                        }
                    }
                }

                if ($('.viewsidemodalId').children().length > 0) {
                    if (!$(event.target).closest('#viewModal').length && !$(event.target).is('#viewModal')) {
                        if ($("#viewModal").is(":visible")) {
                            closeChat(senderId,rceiver);
                            $(".viewsidemodalId").hide();
                            $('.modal-backdrop').hide();
                            $('body').css('overflow', 'auto');
                        }
                    }
                }
            });
        });

        $(document).ready(function () {

            $(document).on('click', '.btn-request', function (e) {
                e.preventDefault();
                let documentUserId = $(this).data('id'); 
                let referenceId = $(this).data('reference-id'); 
                let $button = $(this); // Reference to the clicked button
                $.ajax({
                    url: '{{ route("documents.request-access") }}',
                    type: 'POST',
                    data: {
                        id: documentUserId,
                        referenceId: referenceId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $button.text("Requested"); 
                    },
                    error: function(response) {
                        console.log('Error: ' + response.responseJSON.message);
                    }
                });
            });
            
            $(document).on('click', '#viewDocuments', function (e) {
                $('#pills-home').removeClass('show active');
                $('#pills-message').removeClass('show active');
                $('#pills-document').addClass('show active');
                $('#pills-document').show();
                $('#pills-message').hide();
                $('#pills-home').hide();
                var name = $(".chatNameProvClient").data("name");
                $(".chatNameProvClient").html("<a id='clickBackToChat'><i class='la la-angle-left'></i></a><span >Documents Permissions <strong>"+name+"</strong></span>");
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
