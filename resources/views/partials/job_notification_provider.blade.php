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
                                    <i onclick="openEdOpts(this);"  style="cursor: pointer;" class="la la-ellipsis-v ed-opts-open three-dots-provider mt-2 pt-3"></i>
                                    <ul class="ed-options">
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