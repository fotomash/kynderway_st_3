<div class="modal-dialog modal-dialog-aside" role="document" id="openModal">
    <div class="modal-content">

        <div class="modal-body">
            <div class="row p-3" style="background-color: #dfdfdf;">

                <div class="col-md-12 p-0">
                    <div class="shareAndViewDocuments">
                        <a class="btn-custom" id="shareDocuments" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="false"> Share Documents </a> 
                    </div>
                    <div class="pt-2" style="display: inline-block">
                        <a type="button" onclick="backList();" class="pt-2" style="font-weight: bold; color: #8c50a0;"
                        data-dismiss="modal"><i class="la la-chevron-left" style="font-weight: bold;"></i> Back to Profile</a>
                    </div>
                    <img class="" src="/website/images/logo1.svg" width="140" style="float: right;"/>
                </div>
            </div>
            <ul class="nav nav-pills nav-justified m-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link profileclass active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                       <i class="fas fa-user"></i>
                       <span class="remove"> Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link videoclass" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                        <i class="fas fa-video"></i>
                        <span class="remove"> Video</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link documentclass" id="pills-document-tab" data-toggle="pill" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="false">
                        <i class="fas fa-file"></i>
                        <span class="remove"> Documents</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link messageclass" id="pills-message-tab" data-toggle="pill" href="#pills-message" role="tab" aria-controls="pills-message" aria-selected="false" onclick="clearChat({{ $conid }});">
                       <i class="fas fa-comment-alt"></i>
                       <span class="remove"> Message</span>
                    </a>
                </li>
            </ul>
            {{-- <hr /> --}}
            <div class="tab-content m-0" id="pills-tabContent">
                <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="row mb-3 special" style=" width:100%; background-image:linear-gradient(to right, #8c50a0 , #304384);">
                        <div class="col-md-3 p-0 text-center">
                            <div class="usy-dt p-4" style="width: 100%;">
                                <img
                                    @if( isset($profile_posts['userdetails']['profile_picture']))
                                        src="{{ Helper::getProfileImage($profile_posts['userdetails']['profile_picture']) }}"
                                    @endif
                                     style="
                                        height: 150px;
                                        width: 150px;
                                        object-fit: cover;
                                        max-height: 300px;
                                        float: none;
                                        background-color: #fff;
                                        " width="100%" alt="">
                                     
                                    
                                 
                                @if( isset($profile_posts['userdetails']['getVerified']) && ($profile_posts['userdetails']['getVerified']['status'] == 1))
                                    <div style="width: 100%; text-align:center;">
                                        <i class="fas fa-check-circle text-white pt-4" title="{{ ($profile_posts['userdetails']['getVerified']['adv_check']??'N/A' == '0') ? 'Standard Check' : 'Advanced Check' }}" data-toggle="tooltip" data-placement="bottom" style="font-size: 17px;"></i>
                                        <p class="text-white" style="font-size: 17px; display: inline-block;">Verified</p>
                                    </div>
                                @else
                                    <div style="width: 100%; text-align:center;">
                                        <p class="pt-4 text-white" style="font-size: 17px; display: inline-block;">Not Verified</p>
                                    </div>
                                @endif

                            </div>
                        </div>
                        @php
                            if($profile_posts->currency == 'EUR'){
                                $setsign = '€';
                            }
                            elseif($profile_posts->currency == 'GBP'){
                                $setsign = '£';
                            }
                            elseif($profile_posts->currency == 'USD'){
                                $setsign = '$';
                            }
                        @endphp
                        <div class="col-md-9 pt-4 pb-4 pl-0 pr-0">
                            <div class="row">
                                <div class="col-md-12 p-0 text-center-mob">
                                    <div class="usy-name ml-0">
                                        <h3 style="font-size: 19px;">{{ $profile_posts['userdetails']['name']??'' }}, {{  isset($profile_posts['userdetails']['birth_date']) ? \Carbon\Carbon::parse($profile_posts['userdetails']['birth_date'])->age : '' }}</h3>
                                        <ul class="skill-tags profile pt-2">
                                            <li><a title="">Nationality: {{ $profile_posts['userdetails']['nationality']??'' }}</a></li>
                                            <li><a title="">Years of Experience: {{ str_replace(' Year', '', str_replace(' Years', '', $profile_posts['experience2']??'')) }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 pad-left-mob">
                                        <div class="row text-white">
                                            <div class="col-1 p-0">
                                                <i class="fas fa-map-marker-alt text-white mr-2" style="font-size: 17px; width:30px; text-align:center;"></i>
                                            </div>
                                            <div class="col-11 p-0 pad-left-mob">
                                                Location: {{ strlen($profile_posts['userdetails']['country']??'') > 0 ? $profile_posts['userdetails']['country'] : ''  }}{{ strlen($profile_posts['userdetails']['city']??'') > 0 ? ', ' . $profile_posts['userdetails']['city'] : ''  }}{{ strlen($profile_posts['userdetails']['landmark']??'') > 0 ? ', ' . $profile_posts['userdetails']['landmark'] : ''  }}{{ strlen($profile_posts['userdetails']['postalcode']??'') > 0 ? ', ' . $profile_posts['userdetails']['postalcode'] : ''  }}
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $otherlanguages = '';
                                        $cnt = 0 ;
                                        if(isset($profile_posts['userdetails']['userlanguages']) && count($profile_posts['userdetails']['userlanguages']) > 0)
                                        {
                                            foreach($profile_posts['userdetails']['userlanguages'] as $key=>$val){
                                            $cnt++;
                                            if ($key == count($profile_posts['userdetails']['userlanguages']) - 1) {
                                                    $otherlanguages .= $val['language_name'];
                                                }else {
                                                    $otherlanguages .= $val['language_name'].", ";
                                                }
                                            }
                                        }
                                        if($cnt){
                                            $final_lang_list = ($profile_posts['userdetails']['native_language'] ??'').", ".$otherlanguages;
                                        }else{
                                            $final_lang_list = $profile_posts['userdetails']['native_language']??'';
                                        }
                                    @endphp
                                    <div class="col-lg-12 pad-left-mob mt-3">
                                        <div class="row text-white">
                                            <div class="col-1 p-0">
                                                <i class="fas fa-comments text-white pb-2 mr-2" style="font-size: 17px;  width:30px; text-align:center;"></i>
                                            </div>
                                            <div class="col-11 p-0 pad-left-mob">
                                                Languages: {{ Str::limit($final_lang_list, 60)}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 pad-left-mob mt-3">
                                        <div class="row text-white">
                                            <div class="col-1 p-0">
                                                <i class="fas fa-history text-white mr-2" style="font-size: 17px; width:30px; text-align:center;"></i>
                                            </div>
                                            <div class="col-11 p-0 pad-left-mob">
                                                Duration: {!! str_replace(',',', ',$profile_posts['job_duration']??'') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 pad-left-mob mt-3">
                                        <div class="row text-white">
                                            <div class="col-1 p-0">
                                                <i class="fas fa-coins mr-2 text-white" style="font-size: 17px; width:30px; text-align:center;"></i>
                                            </div>
                                            <div class="col-11 p-0 pad-left-mob">
                                                Pay from: {{ $setsign }}{{ $profile_posts['payamount']??'' }} {{ $profile_posts['payfrequency']??'' }}
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $cntjt = 0;
                                        $thisjobtype = '';
                                        $alljobtypes = array();
                                        $alljobtypes = explode(",", $profile_posts['jobtypes']??'');

                                        $cntjt = count($alljobtypes);
                                        foreach($alljobtypes as $key=>$value){
                                            $tmp =  \App\Models\Job_Types::find($value);
                                            $tempjobtype =  $tmp->jobtype;

                                            if($key != $cntjt-1){
                                                $thisjobtype .= $tempjobtype.", ";
                                            }else{
                                                $thisjobtype .= $tempjobtype;
                                            }
                                        }
                                        $final_job_types = explode(",", $thisjobtype);
                                    @endphp
                                    <div class="col-lg-12 pad-left-mob mt-3">
                                        <ul class="job-tags mb-0">
                                            @foreach($final_job_types as $key => $type)
                                            <li class="limargin">
                                                <a class="shadow">
                                                    <label class="" for="checkbox1_jtype">{{ $type }}</label>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-1 mb-1 pt-3 pb-3 ml-4 mr-4" style="border-radius: 20px; border: 1px solid #e5e5e5;">
                        <div class="col-6 col-md-6 pl-0 pr-0">
                            <p style="font-weight: bold; color: #8c50a0;"><i class="fas fa-circle pl-3 pr-2" style="color: #8c50a0"></i> Nationality</p>
                        </div>
                        <div class="col-6 col-md-6 pl-0 pr-0">
                            <p style="color: #334683;"> {{ $profile_posts['userdetails']['nationality']??'' }}</p>
                        </div>
                    </div>
                    <div class="row mt-1 mb-1 pt-3 pb-3 ml-4 mr-4" style="border-radius: 20px; border: 1px solid #e5e5e5;">
                        <div class="col-md-6 pl-0 pr-0">
                            <p style="font-weight: bold; color: #8c50a0;"><i class="fas fa-circle pl-3 pr-2" style="color: #8c50a0"></i> Location
                            </p>
                        </div>

                        <div class="col-md-6 pl-0 pr-0">
                        </div>
                        <div class="col-md-12">
                            <hr class="" />
                        </div>

                        <div class="col-md-12 mb-2">
                            <div class="row">
                                <div class="col-6 col-md-6 pl-4"><p style="color: #334683;"><strong>Country</strong></p>
                                </div>
                                <div class="col-6 col-md-6 pl-0"><p style="color: #334683;">
                                        {{ $profile_posts['userdetails']['country']??'' }}</p></div>
                                <div class="col-6 col-md-6 pl-4"><p style="color: #334683;"><strong>City</strong></p>
                                </div>
                                <div class="col-6 col-md-6 pl-0"><p style="color: #334683;">
                                        {{ $profile_posts['userdetails']['city']??'' }}</p></div>
                                <div class="col-6 col-md-6 pl-4"><p style="color: #334683;"><strong>Area</strong></p>
                                </div>
                                <div class="col-6 col-md-6 pl-0"><p style="color: #334683;">
                                        {{ $profile_posts['userdetails']['landmark']??'' }}</p></div>
                            </div>
                        </div>
                    </div>
                    <hr class="" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:24px; color: #304384;">
                                Languages</h3>
                            <hr class="bold">
                        </div>
                    </div>
                    <div class="row mt-1 mb-1 pt-3 pb-3 ml-4 mr-4"
                         style="border-radius: 20px; border: 1px solid #e5e5e5;">
                        <div class="col-6 col-md-6 pl-0 pr-0">
                            <p style="font-weight: bold; color: #8c50a0;">
                                <i class="fas fa-circle pl-3 pr-2" style="color: #8c50a0"></i> Native
                                Language</p>
                        </div>
                        <div class="col-6 col-md-6 pl-0 pr-0">
                            <p style="color: #334683;">{{ $profile_posts['userdetails']['native_language']??'' }}</p>
                        </div>
                    </div>

                    @if(isset($profile_posts['userdetails']['userlanguages']) && count($profile_posts['userdetails']['userlanguages']) > 0)
                        <div class="row mt-1 mb-1 pt-3 pb-3 ml-4 mr-4"
                            style="border-radius: 20px; border: 1px solid #e5e5e5;">
                            <div class="col-6 col-md-6 pl-0 pr-0">
                                <p style="font-weight: bold; color: #8c50a0;">
                                    <i class="fas fa-circle pl-3 pr-2" style="color: #8c50a0"></i> Other
                                    Languages</p>
                            </div>

                            <div class="col-6 col-md-6 pl-0 pr-0">
                            </div>
                            <div class="col-md-12">
                                <hr class="" />
                            </div>

                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    @foreach($profile_posts['userdetails']['userlanguages'] as $key=>$val)
                                        <div class="col-6 col-md-6 pl-4">
                                            <p style="color: #334683;">
                                                <strong>{{ $val['language_name'] }}</strong>
                                            </p>
                                        </div>
                                        <div class="col-6 col-md-6 pl-0">
                                            <p style="color: #334683;">{{ $val['language_level'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <hr class="" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:24px; color: #304384;">Job
                                Types</h3>
                            <hr class="bold" />
                            <ul class="skill-tags">
                                @foreach($all_jtypes as $jtypes)
                                    <li><a href="javascript:void(0);" style="cursor:default" title="">{{ $jtypes }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <hr class="" />

                    {{-- @if($profile_posts->aidvalue==1 || $profile_posts->recordvalue == 1 || $profile_posts->carvalue == 1 || $profile_posts->licensevalue == 1 || $profile_posts->qualificationsvalue || $profile_posts->refvalue) --}}
                        <div class="row ml-4 mr-4">
                            <div class="col-md-12 pl-0 pr-0">
                                <h3 class="pb-2" style="font-weight: bold; font-size:24px; color: #304384;">I Have</h3>
                                <hr class="bold" />
                                <div class="row">
                                    @if($profile_posts->aidvalue==1)
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-medkit" style="width: 20px"></i> First Aid</p></div>
                                    @else
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-medkit" style="width: 20px"></i> First Aid</del></p></div>
                                    @endif

                                    @if($profile_posts->recordvalue == 1)
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-gavel" style="width: 20px"></i> Criminal Record Check</p></div>
                                    @else
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-gavel" style="width: 20px"></i> Criminal Record Check</del></p></div>
                                    @endif

                                    @if($profile_posts->carvalue == 1)
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-paw" style="width: 20px"></i> Comfortable with Pets</p></div>
                                    @else
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-paw" style="width: 20px"></i> Comfortable with Pets</del></p></div>
                                    @endif

                                    @if($profile_posts->licensevalue == 1)
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-id-badge" style="width: 20px"></i> Driving License</p></div>
                                    @else
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-id-badge" style="width: 20px"></i> Driving License</del></p></div>
                                    @endif

                                    @if($profile_posts->qualificationsvalue == 1)
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-certificate" style="width: 20px"></i> Certified Qualification</p></div>
                                    @else
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-certificate" style="width: 20px"></i> Certified Qualification</del></p></div>
                                    @endif

                                    @if($profile_posts->refvalue == 1)
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-clipboard-list" style="width: 20px"></i> References</p></div>
                                    @else
                                        <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-clipboard-list" style="width: 20px"></i> References</del></p></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr class="" />
                    {{-- @endif --}}

                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:24px; color: #304384;">I Work With</h3>
                            <hr class="bold" />
                            <ul class="skill-tags">
                                @foreach($all_workwith as $wwith)
                                    <li><a href="javascript:void(0);" style="cursor:default" title="">{{ $wwith }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <hr class="" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-2" style="font-weight: bold; font-size:24px; color: #304384;">Education
                                and
                                Work Experience</h3>
                            <hr class="bold" />
                            <p class="text-justify pb-3">{{ $profile_posts->edu_description }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    @if(count($profile_posts['userdetails']['videosets']) > 0)
                        @foreach($profile_posts['userdetails']['videosets'] as $key=>$val)
                            <video class="mb-70px" width="100%" controls>
                                <source src="{{ url('storage/'. $val->videofile) }}" type="video/mp4">
                                Your browser does not support HTML video.
                            </video>
                        @endforeach
                    @else
                        <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">No video uploaded</p>
                    @endif
                </div>

                <div class="tab-pane fade" id="pills-document" role="tabpanel" aria-labelledby="pills-document-tab">
                    @php
                        $isEmpty = true;
                        foreach($documents as $document) {
                            if (!empty((array)$document)) {
                                $isEmpty = false;
                                break;
                            }
                        }
                    @endphp
                    @if(!$fullconnect)
                        <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">Only when you are connected to the candidate you can see/request documentation</p>
                    @elseif(count($documents) > 0 && $isEmpty )
                        <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">Request access to documents via chatbox</p>
                    @elseif(count($documents) > 0 && !$isEmpty)
                        <div class="cp-field">
                            @foreach($documents as $document)
                                @php
                                    $temp_url = substr($document->document_url,18);
                                @endphp
                                <div class="row">
                                    <div class="col-md-12 p-0">
                                        <div class="row my-2">
                                            <div class="col-md-9 p-0" style="display: flex; align-items: center; font-size: 20px;">
                                                {{ $document->document_name }}
                                            </div>
                                            <div class="col-md-3">
                                                <a target="_blank" class="btn btn-block btn-success" href="/view-pdf?url={{ $temp_url }}">VIEW</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="linedBetweenDocuments">
                            @endforeach
                        </div>
                    @else
                        <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">No documents found</p>
                    @endif
                </div>

                <div class="tab-pane fade" id="pills-message" role="tabpanel" aria-labelledby="pills-message-tab">
                    @if($fullconnect)
                        <iframe src="/chatify/{{ $profile_posts['userdetails']['id'] }}/{{ $conid }}" style="width: 100%;height: calc(100dvh - 80px);min-height: 100%;"></iframe>
                    @else
                    <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">Chat will be enabled on accepting the job application.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
