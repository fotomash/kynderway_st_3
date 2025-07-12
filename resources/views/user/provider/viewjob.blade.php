<div class="modal-dialog modal-dialog-aside" role="document" id="openModal">
    <div class="modal-content">

        <div class="modal-body">
            <div class="row" style="background-color: #F4F5F9;">
                <div class="col-md-12 p-0 prantDivAlign">
                    <div id="shareAndViewDocuments" >
                        <div class="shareAndViewDocuments">
                            <div class="col-md-6 col-sm-6 col-lg-6 col-6 col-xs-6 chatNameProvClient flexDirectionStart" data-name="{{$jposts['userdetails']['name']}}">
                                <span>{{$jposts['userdetails']['name']}}</span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-6 col-xs-6 flexDirectionEnd">
                                <a class="btn-custom" id="shareDocuments" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="false"> Share Documents </a> 
                            </div>
                        </div>
                    </div>
                <div style=" display: flex;justify-content: flex-end;padding: 6px;height: 30px;z-index:9999999">
                        <a type="button"  id="getCloseChat" data-sender-id="{{$provider_id}}" data-rceiver-id="{{$seeker_id}}"  onclick="closeChat({{$provider_id}},{{$seeker_id}})" style=" color: black;" data-dismiss="modal"><i class="fas fa-times" ></i> </a>
                    </div>
                </div>
            </div>

            <div class="tab-content m-0" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row mb-3 special" style=" width:100%; background-color: #F4F5F9;">
                        <div class="col-md-3 p-0">
                            <div class="usy-dt pb-0 pt-4">
                                <img src="{{ UserHelper::getProfileImage($jposts['userdetails']['profile_picture']) }}" style="background-color: #fff;" class="mb-3" width="100%" alt="">

                            </div>
                        </div>
                        <div class="col-md-9 pt-4 pb-4 pl-0 pr-0">
                            <div class="row">
                                <div class="col-md-12 p-0 text-center-mob">
                                    <div class="usy-name ml-0 pl-0" style="padding: 0 20px;">
                                        <h3 style="font-size: 24px; color:#2F2F2F">
                                            {{ $jposts->jobtitle }}
                                        </h3>
                                        <strong style="align-self: center; padding-left: 5px" > {{ Str::limit($jposts['userdetails']['name'], 18) }}</strong>

                                    </div>
                                </div>
                                <div class="col-md-12 p-0 text-center-mob">
                                    <div class="usy-name ml-0">
                                        <ul class="skill-tags profile pt-2">
                                            <li><a title="" style="color:#282828;font-weight: 400;font-size: 14px;line-height: 17px;">{{ $jposts->usertype }}</a></li>
                                            <li><a title="" style="color:#282828;font-weight: 400;font-size: 14px;line-height: 17px;">Posted: {{ Carbon\Carbon::parse($jposts->created_at)->diffForHumans() }}</a></li>
                                            <li><a title="" style="color:#282828;font-weight: 400;font-size: 14px;line-height: 17px;">Starting: {{ ($jposts->asap) ? 'ASAP' : $jposts->start_date }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 p-0 text-center-mob" >
                                <a class="nav-link documentclass" style="display: inline-block;" id="pills-document-tab" data-toggle="pill" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="false">
                                    <span  style="border: 1px solid #CBCBCB; border-radius: 18px;padding: 0.5rem !important;font-weight: 500;font-size: 14px;line-height: 15px;color: #5C5C5C;">Share your documents</span>
                                </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-1 mb-1 pt-3 pb-3 ml-4 mr-4">
                            <div class="col-lg-12 pad-left-mob">
                                <div class="row text-black">

                                    <div class="col-11 p-0 pad-left-mob" style="display:flex">
                                        <span style="display: inline-flex; min-width:6rem;color: #6B6B6B">Location:</span> <span style="color:#282828"> {{ strlen($jposts->country) > 0 ? $jposts->country : ''  }}{{ strlen($jposts->city) > 0 ? ', ' . $jposts->city : ''  }}{{ strlen($jposts->landmark) > 0 ? ', ' . $jposts->landmark : ''  }}{{ strlen($jposts->postalcode) > 0 ? ', ' . $jposts->postalcode : ''  }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 pad-left-mob mt-3">
                                <div class="row text-black">

                                    <div class="col-11 p-0 pad-left-mob" style="display:flex">
                                        <span style="display: inline-flex; min-width:6rem;color: #6B6B6B">Schedule:</span> <span style="color:#282828"> {{ str_replace(' Hours', '', $jposts->hoursperweek) }} hours per week</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 pad-left-mob mt-3">
                                <div class="row text-black">

                                    <div class="col-11 p-0 pad-left-mob" style="display:flex">
                                       <span style="display: inline-flex; min-width:6rem;color: #6B6B6B">Duration:</span> <span style="color:#282828">{{ $jposts->jobduration }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 pad-left-mob mt-3">
                                <div class="row text-black">

                                    <div class="col-11 p-0 pad-left-mob" style="display:flex">
                                       <span style="display: inline-flex; min-width:6rem;color: #6B6B6B">Pay:</span>

                                        <span style="color:#282828">  @if($jposts->paymentOption == 'fix')
                                                {!! config('kinderway.currencySymbols.'.$jposts->payamountcurrency)!!}{{ $jposts->payamount_from }} - {!! config('kinderway.currencySymbols.'.$jposts->payamountcurrency)!!}{{ $jposts->payamount_to }} {{ $jposts->payfrequency }}
                                            @else
                                                {{ Str::of($jposts->paymentOption)->ucfirst() }}
                                            @endif</span>

                                    </div>
                                </div>
                            </div>

                    </div>
                    <hr class="divide_sidebar_section" />

                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">Job
                                Type</h3>

                            <ul class="skill-tags">
                                @foreach($all_jtypes as $jtypes)
                                    <li><a href="javascript:void(0);" style="cursor:default;border: 1px solid #CBCBCB;border-radius: 18px;color:#5C5C5C"
                                           title="">{{ $jtypes }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">You will
                                work with</h3>

                            <ul class="skill-tags">
                                @foreach($all_workwith as $wwith)
                                    <li><a href="javascript:void(0);" style="cursor:default;background: #F8F8F8;border-radius: 24px; color:#282828"
                                           title="">{{ $wwith }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">Work skills
                                required</h3>
                            <ul class="skill-tags">
                                @foreach($all_work_skills as $wskills)
                                    <li><a href="javascript:void(0);" style="cursor:default;background: #F8F8F8;border-radius: 24px; color:#282828"
                                           title="">{{ $wskills }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">Required
                                Languages</h3>
                            <ul class="skill-tags">
                                @foreach($reqlang as $rlang)
                                    <li><a href="javascript:void(0);" style="cursor:default; color:#282828"
                                           title="">{{ $rlang }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @if(is_array($preferredLanguages) && count($preferredLanguages))
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">Preferred
                                Languages</h3>
                            <ul class="skill-tags">
                                @foreach($preferredLanguages as $preferredLanguage)
                                    <li><a href="javascript:void(0);" style="cursor:default; color:#282828"
                                           title="">{{ $preferredLanguage }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4 mb-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">Work Schedule</h3>
                            <p class="p-2 text-justify" style="border-radius:10px; white-space: pre-wrap;color:#282828">{{ $jposts->workschedule }}</p>
                        </div>
                    </div>
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">About Job</h3>
                            <p class="text-justify pb-3" style="white-space: pre-wrap;color:#282828">{{ $jposts->job_details }}
                            </p>
                        </div>
                    </div>


                    <div class="row  ml-4 mr-4 mb-4">

                        <div class="col-md-9 pl-0 no-pad-left-mob no-pad-right-mob text-center-mob">
                            <a class="btn  btn-kinderway setwhitetext" id="pills-message-tab" data-toggle="pill" href="#pills-message" role="tab" aria-controls="pills-message" aria-selected="false" onclick="clearChat({{ $conid }}); "  style=" border-radius: 50px; cursor: pointer;padding: 5px 15px">
                                <span >Message</span>
                            </a>
                        </div>
                        </div>
                </div>

                <div class="tab-pane fade" id="pills-document" role="tabpanel" aria-labelledby="pills-document-tab">
                    @forelse($documents as $document)
                        <div class="cp-field">
                            @php
                                $accessData = $user_docs->firstWhere('document_id', $document->id);
                                $isAccessGranted = $accessData && $accessData->is_access_granted;
                                $isAccessBlocked = $accessData && $accessData->is_access_blocked;
                                $is_requested = $accessData && $accessData->is_requested;
                                $documentUserId = $accessData ? $accessData->id : null; 
                                $temp_url = substr($document->document_url, 18);
                            @endphp
                            <div class="row">
                                <div class="col-md-12 p-0">
                                    <div class="row my-2">
                                        <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8 p-0" style="display: flex; align-items: center; font-size: 20px;">
                                            {{ $document->document_name }}
                                        </div>
                                        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                            @if($isAccessGranted)
                                                <div class="alignItems">
                                                    <a class="btn-success-granted disabled">
                                                        <img src="/imgs/granted.png" width="16" height="16">
                                                        Granted
                                                    </a>
                                                    <div class="col-1">
                                                        <i class="la la-ellipsis-v ed-opts-open three-dots-provider" onclick="openEdOpts(this);"></i>
                                                        <ul class="ed-options">
                                                            <li data-id="{{ $document->id }}" data-id-seeker="{{ $accessData->seeker_id }}" data-id-provider="{{ $accessData->provider_id }}" class="btn-block-access-dropdown">Block Access</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @elseif($isAccessBlocked)
                                                <div class="alignItems">
                                                    <a class="btn btn-blocked">Blocked (Only visible to you)</a>
                                                    <div class="col-1">
                                                        <i class="la la-ellipsis-v ed-opts-open three-dots-provider" onclick="openEdOpts(this);"></i>
                                                        <ul class="ed-options">
                                                            <li data-id="{{ $document->id }}" data-id-seeker="{{ $accessData->seeker_id }}" data-id-provider="{{ $accessData->provider_id }}"  data-id-reference="{{ $conid }}" class="btn-grant-access-dropdown">Grant Access</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @else
                                                <button type="button" onclick="giveAccess({{ $jposts->user_id }}, {{ $document->id }}, {{$conid}})" id="access-{{ $document->id }}" class="btn btn-block btn-success" style="float: right;">
                                                    Grant Access
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="linedBetweenDocuments">
                        </div>
                    @empty
                        <div class="noDocument">
                            <p class="noDocumentText">To share your documents with a potential employer, please first add them in <a target="_blank" href="/provider/manage-documents">Manage Documents.</a></p>
                        </div>
                        <p class="text-center pt-5 mt-5 noDocumentTextChat" style="color: #727272; font-weight:bold; font-size: 16px;">No documents yet</p>
                    @endforelse
                </div>
            

                <div class="tab-pane fade" id="pills-message" role="tabpanel" aria-labelledby="pills-message-tab">
                    @if($fullconnect)
                        <div class="containerChat">
                            <iframe src="/chatify/{{ $jposts['userdetails']['id'] }}/{{ $conid }}" style="width: 100%; height: calc(100dvh - 80px); min-height: 100%; border: none;"></iframe>
                            
                        </div>

                        </div>
                    @else
                    <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">Chat Messaging will be enabled on accepting the job invite.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> 
