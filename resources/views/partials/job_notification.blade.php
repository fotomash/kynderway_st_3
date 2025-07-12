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
                                    <a href="#" title="" style="cursor: pointer;" class="ed-opts-open" onclick="openEdOpts(this);">
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
                                            <i onclick="openEdOpts(this);" style="cursor: pointer;" class="la la-ellipsis-v ed-opts-open three-dots-provider mt-2"></i>
                                            <ul class="ed-options">
                                                <li onclick=""><a href="#">View Documents</a></li>
                                                <li onclick="editApplicationNote({{ $post['id'] }}, '{{ $post['notes'] }}');"><a href="#">Edit Note</a></li>
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