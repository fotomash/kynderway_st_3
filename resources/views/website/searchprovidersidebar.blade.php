<div class="modal-dialog modal-dialog-aside" role="document" id="openModal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row" style="background-color: #F4F5F9;">
                <div class="col-md-12 p-0">
                    <div style=" display: flex;justify-content: flex-end;padding: 6px;height: 30px;">
                        <a type="button" onclick="backlist();" style=" color: black;" data-dismiss="modal"><i class="fas fa-times" ></i> </a>
                    </div>
{{--                    <img class="" src="/website/images/logo1.svg" width="140" style="float: right;"/>--}}
                </div>
            </div>
{{--            <ul class="nav nav-pills nav-justified m-3" id="pills-tab" role="tablist">--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link profileclass active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><i class="fas fa-user"></i><span class="remove"> Profile</span></a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link videoclass" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="fas fa-video"></i><span class="remove"> Video</span></a>--}}
{{--                </li>--}}
{{--            </ul>--}}

            <div class="tab-content m-0" id="pills-tabContent">
                <div class="tab-pane fade show mb-3 active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row mb-3 special" style=" width:100%; background-color: #F4F5F9">
                        <div class="col-md-3 p-0 text-center">
                            <div class="usy-dt p-4" style="width: 100%;">
                                <img src="{{ UserHelper::getProfileImage($profileposts['userdetails']['profile_picture']) }}"
                                     style="
    height: 150px;
    width: 150px;
    object-fit: cover;
    max-height: 300px;
    float: none;
    background-color: #fff;
    " width="100%" alt=""/>

                                {{-- @if( isset($profileposts['userdetails']['getVerified']) && ($profileposts['userdetails']['getVerified']['status'] == 1))
                                    <i class="fas fa-check-circle p-2 pt-4 text-white" title="{{ ($profileposts['userdetails']['getVerified']['adv_check'] == '0') ? 'Standard Check' : 'Advanced Check' }}"
                                       style="font-size: 17px;"> Verified
                                    </i>
                                @endif --}}
                            </div>
                        </div>
                        @php
                            if($profileposts->currency == 'EUR'){
                                $setsign = '€';
                            }
                            elseif($profileposts->currency == 'GBP'){
                                $setsign = '£';
                            }
                            elseif($profileposts->currency == 'USD'){
                                $setsign = '$';
                            }

                        @endphp

                        <div class="col-md-9 pt-4 pb-4 pl-0 pr-0">
                            <div class="row">
                                <div class="col-md-12 p-0 text-center-mob">
                                    <div class="usy-name sidebar-provider ml-0" style="display: flex; gap: 1rem" >
                                        {{-- <h3 style="font-size: 24px;">{{ Str::limit($profileposts['userdetails']['name'], 22) }}, {{  \Carbon\Carbon::parse($profileposts['userdetails']['birth_date'])->age  }}</h3> --}}

                                           <h3 style="font-size: 19px;color: #2F2F2F;font-weight: 500;font-size: 24px;line-height: 29px;">{{ $profileposts['userdetails']['name'] }}</h3>
                                        @if( isset($profileposts['userdetails']['getVerified']) && ($profileposts['userdetails']['getVerified']['status'] == 1))

                                                <svg style=" align-self: center;" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_308_1534)">
                                                        <mask id="mask0_308_1534" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                                            <path d="M0 0H20V20H0V0Z" fill="white"/>
                                                        </mask>
                                                        <g mask="url(#mask0_308_1534)">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6856 3.10027L15.632 5.9561C16.0564 6.20113 16.3178 6.65395 16.3178 7.144V12.8557C16.3178 13.3458 16.0564 13.7985 15.632 14.0436L10.6856 16.8994C10.2612 17.1444 9.73834 17.1444 9.31392 16.8994L4.36747 14.0436C3.94308 13.7985 3.68164 13.3458 3.68164 12.8557V7.144C3.68164 6.65395 3.94308 6.20113 4.36747 5.9561L9.31392 3.10027C9.73834 2.85524 10.2612 2.85524 10.6856 3.10027ZM8.68892 2.01774C9.50009 1.54943 10.4994 1.54943 11.3106 2.01773L16.257 4.87357C17.0682 5.34188 17.5678 6.20737 17.5678 7.144V12.8557C17.5678 13.7923 17.0682 14.6578 16.257 15.1261L11.3106 17.9819C10.4994 18.4503 9.50009 18.4503 8.68892 17.9819L3.74247 15.1261C2.93132 14.6578 2.43164 13.7923 2.43164 12.8557V7.144C2.43164 6.20737 2.93132 5.34188 3.74247 4.87357L8.68892 2.01774ZM12.9417 8.77508C13.1858 8.531 13.1858 8.1353 12.9417 7.89123C12.6976 7.64715 12.3019 7.64715 12.0578 7.89123L9.16642 10.7826L7.9417 9.55792C7.69762 9.31383 7.30189 9.31383 7.05782 9.55792C6.81374 9.802 6.81374 10.1977 7.05782 10.4418L8.72451 12.1084C8.96859 12.3525 9.36426 12.3525 9.60834 12.1084L12.9417 8.77508Z" fill="#3D3264"/>
                                                        </g>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_308_1534">
                                                            <rect width="20" height="20" fill="white"/>
                                                        </clipPath>
                                                    </defs>
                                                </svg>


                                        @endif


                                                                            @php
                                                                                switch ($profileposts['profilecat']['categoryname']) {
                                                                                    case 'Cleaner':
                                                                                        $bgColor = 'rgba(100, 180, 127, 0.2)';
                                                                                        $textColor = '#64B47F';
                                                                                        break;
                                                                                    case 'Nanny':
                                                                                        $bgColor = 'rgba(132, 85, 156, 0.2)';
                                                                                        $textColor = '#84559C';
                                                                                        break;
                                                                                    case 'Maternity':
                                                                                        $bgColor = 'rgba(51, 68, 128, 0.2)';
                                                                                        $textColor = '#334480';
                                                                                        break;
                                                                                    case 'Housekeeper':
                                                                                        $bgColor = 'rgba(237, 151, 55, 0.2)';
                                                                                        $textColor = '#ED9737';
                                                                                        break;
                                                                                    default:
                                                                                        $bgColor = 'rgba(237, 151, 55, 0.2)';
                                                                                        $textColor = '#ED9737';
                                                                                }
                                                                            @endphp


                                                                                <span style="align-self:center;font-weight:800;font-size:17px;color:{{ $textColor }}; background: {{ $bgColor }}; border-radius: 18px; padding:5px 10px;">{{ $profileposts['profilecat']['categoryname'] }}</span>






                                                                                </div>
                                                                                <div class="col-md-12 p-0">
                                                                                    <ul class="skill-tags profile pt-2" >
                                                                                        {{-- <li><a title="">Age: {{  \Carbon\Carbon::parse($profileposts['userdetails']['birth_date'])->age  }}</a></li> --}}
                                            {{-- <li><a title="">Pay: {{ $setsign }} {{$profileposts->payamount}} Per Hour</a></li> --}}
                                            <li><a title="" style="color:#282828;font-weight: 400;font-size: 14px;line-height: 17px;">{{  \Carbon\Carbon::parse($profileposts['userdetails']['birth_date'])->age  }}</a></li>
                                            <li><a title="" style="color:#282828;font-weight: 400;font-size: 14px;line-height: 17px;"> {{ $profileposts['userdetails']['nationality'] }}</a></li>
                                            <li><a title="" style="color: #84559C;opacity: 0.8;font-weight: 500;font-size: 14px;line-height: 17px;">{{ str_replace(' Year', '', str_replace(' Years', '', $profileposts->experience2)) }} Years of Experience</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 p-0 text-center-mob">
                                <a class="nav-link videoclass" style="display: inline-block;" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><span  style="border: 1px solid #CBCBCB; border-radius: 18px;padding: 0.5rem !important;font-weight: 500;font-size: 14px;line-height: 15px;color: #5C5C5C;"> Intro Video<i class="fa fa-play-circle-o" aria-hidden="true" style="margin-left: 0.5rem"></i></span></a>
                                    <a class="nav-link documentclass" style="display: inline-block;" id="pills-document-tab" data-toggle="pill" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="false">
                                        <span   style="border: 1px solid #CBCBCB; border-radius: 18px;padding: 0.5rem !important;font-weight: 500;font-size: 14px;line-height: 15px;color: #5C5C5C;"> Documents</span>
                                    </a>
                                </div>
                                {{--                                <div class="col-md-12 p-0 text-center-mob">--}}
                                {{--                                <a class="nav-link documentclass" style="display: inline-block; id="pills-document-tab" data-toggle="pill" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="false">--}}
                                {{--                                    <span  style="border: 1px solid #CBCBCB; border-radius: 18px;padding: 0.5rem !important;font-weight: 500;font-size: 14px;line-height: 15px;color: #5C5C5C;"> Documents</span>--}}
                                {{--                                </a>--}}
                                {{--                                </div>--}}

                                {{-- <div class="col-4 col-md-4 text-center text-white"
                                     style="border-right: 1px solid #fff;">
                                    <i class="fas fa-money-bill pb-2" style="font-size: 36px;"></i>
                                    <p class="text-white"> {!! config('kinderway.currencySymbols.'.$profileposts->currency)!!} {{$profileposts->payamount}}</p>
                                    <p class="text-white">{{ strtolower($profileposts->payfrequency) }}</p>
                                </div>
                                <div class="col-4 col-md-4 text-center text-white"
                                     style="border-right: 1px solid #fff;">
                                    <i class="fas fa-history pb-2" style="font-size: 36px;"></i>
                                    <p class="text-white">{{ $profileposts->job_duration }}</p>
                                </div>

                                <div class="col-4 col-md-4 text-center text-white" style="overflow-wrap:break-word;">
                                    <i class="fas fa-user pb-2" style="font-size: 36px;"></i>
                                    <p class="text-white">{{  UserHelper::getProviderJobType($profileposts->jobtypes) }}</p>
                                </div> --}}



                            </div>
                        </div>
                    </div>
                    <div class="row mt-1 mb-1 pt-3 pb-3  ml-4 mr-4" >
                        <div class="col-lg-12 p-0">
                            <div class="row text-black">

                                <div class="col-11 p-0 " style="display:flex">
                                  <span style="display: inline-flex; min-width:6rem; color:#6B6B6B"> Location: </span> <span>{{ strlen($profileposts['userdetails']['country']) > 0 ? $profileposts['userdetails']['country'] : ''  }}{{ strlen($profileposts['userdetails']['city']) > 0 ? ', ' . $profileposts['userdetails']['city'] : ''  }}{{ strlen($profileposts['userdetails']['landmark']) > 0 ? ', ' . $profileposts['userdetails']['landmark'] : ''  }}{{ strlen($profileposts['userdetails']['postalcode']) > 0 ? ', ' . $profileposts['userdetails']['postalcode'] : ''  }}</span>
                                </div>
                            </div>
                        </div>
                        @php
                            $otherlanguages = '';
                            $cnt = 0 ;
                            if(count($profileposts['userdetails']['userlanguages']) > 0)
                            {
                                foreach($profileposts['userdetails']['userlanguages'] as $key=>$val){
                                $cnt++;
                                if ($key == count($profileposts['userdetails']['userlanguages']) - 1) {
                                        $otherlanguages .= $val['language_name'];
                                    }else {
                                        $otherlanguages .= $val['language_name'].", ";
                                    }
                                }
                            }
                            if($cnt){
                                $final_lang_list = $profileposts['userdetails']['native_language'].", ".$otherlanguages;
                            }else{
                                $final_lang_list = $profileposts['userdetails']['native_language'];
                            }
                        @endphp
{{--                        <div class="col-lg-12 pad-left-mob mt-3">--}}
{{--                            <div class="row text-black">--}}

{{--                                <div class="col-11 p-0 pad-left-mob">--}}
{{--                                    <span style="display: inline-flex; min-width:6rem"> Languages: </span> <span>{{ Str::limit($final_lang_list, 60)}}</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-lg-12 p-0 mt-3">
                            <div class="row text-black">

                                <div class="col-11 p-0 " style="display:flex">
                                    <span style="display: inline-flex; min-width:6rem; color:#6B6B6B">Duration: </span><span>{!! str_replace(',',', ',$profileposts->job_duration) !!}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 p-0 mt-3">
                            <div class="row text-black">

                                <div class="col-11 p-0 " style="display:flex">
                                    <span style="display: inline-flex; min-width:6rem; color:#6B6B6B">Pay from:</span><span> {{ $setsign }}{{ $profileposts->payamount }} {{ $profileposts->payfrequency }}</span>
                                </div>
                            </div>
                        </div>

                        @php
                            $cntjt = 0;
                            $thisjobtype = '';
                            $alljobtypes = array();
                            $alljobtypes = explode(",", $profileposts->jobtypes);

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
{{--                        <div class="col-lg-12 pad-left-mob mt-3">--}}
{{--                            <ul class="job-tags mb-0">--}}
{{--                                @foreach($final_job_types as $key => $type)--}}
{{--                                    @if($key <= 4)--}}
{{--                                        <li class="limargin">--}}
{{--                                            <a class="shadow">--}}
{{--                                                <label class="" for="checkbox1_jtype">{{ $type }}</label>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </div>
{{--                    <div class="row mt-1 mb-1 pt-3 pb-3 ml-4 mr-4"--}}
{{--                         style="border-radius: 20px; border: 1px solid #e5e5e5;">--}}
{{--                        <div class="col-6 col-md-6 pl-0 pr-0">--}}
{{--                            <p style="font-weight: bold; color: #8c50a0;">--}}
{{--                                <i class="fas fa-circle pl-3 pr-2" style="color: #8c50a0"></i> Nationality--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                        <div class="col-6 col-md-6 pl-0 pr-0">--}}
{{--                            <p style="color: #334683;"> {{ $profileposts['userdetails']['nationality'] }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row mt-1 mb-1 pt-3 pb-3 ml-4 mr-4"--}}
{{--                         style="border-radius: 20px; border: 1px solid #e5e5e5;">--}}
{{--                        <div class="col-md-6 pl-0 pr-0">--}}
{{--                            <p style="font-weight: bold; color: #8c50a0;">--}}
{{--                                <i class="fas fa-circle pl-3 pr-2" style="color: #8c50a0"></i> Location--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6 pl-0 pr-0">--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <hr class="" />--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12 mb-2">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-6 col-md-6 pl-4">--}}
{{--                                    <p style="color: #334683;"><strong>Country</strong></p>--}}
{{--                                </div>--}}
{{--                                <div class="col-6 col-md-6 pl-0">--}}
{{--                                    <p style="color: #334683;">--}}
{{--                                        {{ $profileposts['userdetails']['country'] }}--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                                <div class="col-6 col-md-6 pl-4">--}}
{{--                                    <p style="color: #334683;"><strong>City</strong></p>--}}
{{--                                </div>--}}
{{--                                <div class="col-6 col-md-6 pl-0">--}}
{{--                                    <p style="color: #334683;">--}}
{{--                                        {{ $profileposts['userdetails']['city'] }}--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                                <div class="col-6 col-md-6 pl-4">--}}
{{--                                    <p style="color: #334683;"><strong>Area</strong></p>--}}
{{--                                </div>--}}
{{--                                <div class="col-6 col-md-6 pl-0">--}}
{{--                                    <p style="color: #334683;">--}}
{{--                                        {{ $profileposts['userdetails']['landmark'] }}--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                                --}}{{----}}
{{--                                <div class="col-md-6">--}}
{{--                                    <p style="color: #334683;"><strong>Postal Code</strong></p>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <p style="color: #334683;">EH14 4AS</p>--}}
{{--                                </div>--}}
{{--                                --}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0 ">
                            <h3 class="pb-4" style="font-weight: bold; font-size:16px; color: #304384;">Languages</h3>
{{--                            <hr class="bold" />--}}
                        </div>
                    </div>
                    <div class="row mt-1 mb-1 ml-4 mr-4">
                        <div class=" pl-0 pr-0">
                            <p style="font-weight: bold; color: #6B6B6B; display: inline-flex;min-width: 6rem">
                                 Native
                            </p>
                        </div>
                        <div class=" pl-0 pr-0">
                            <p style="color: #282828;">{{ $profileposts['userdetails']['native_language'] }}</p>
                        </div>
                    </div>
                    @if(count($profileposts['userdetails']['userlanguages']) > 0)
                        <div class="row mt-1 mb-1 pb-3 ml-4 mr-4">
                            <div class="pl-0">
                                <p style="font-weight: bold; color: #6B6B6B; display: inline-flex; min-width: 6rem">
                                    Beginner
                                </p>
                            </div>

{{--                            <div class="col-md-12">--}}
{{--                                <hr class="" />--}}
{{--                            </div>--}}
                            <div>
                                <div class="row">
                                    @foreach($profileposts['userdetails']['userlanguages'] as $key=>$val)
                                        <div>
                                            <p style="color: #282828;"><strong>{{ $val['language_name'] }}</strong></p>
                                        </div>


{{--                                        <div class="col-6 col-md-6 pl-0">--}}
{{--                                            <p style="color: #334683;">{{ $val['language_level'] }}</p>--}}
{{--                                        </div>--}}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-4" style="font-weight: bold; font-size:16px; color: #304384;">Job Types</h3>
{{--                            <hr class="bold" />--}}
                            <ul class="skill-tags">
                                @foreach($all_jtypes as $jtypes)
                                    <li><a href="javascript:void(0);" style="cursor:default;border: 1px solid #CBCBCB;border-radius: 18px;color:#5C5C5C" title="">{{ $jtypes }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr class="divide_sidebar_section" />
                    {{-- @if($profileposts->aidvalue==1 || $profileposts->recordvalue == 1 || $profileposts->carvalue == 1 || $profileposts->licensevalue == 1 || $profileposts->qualificationsvalue || $profileposts->refvalue) --}}
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-4" style="font-weight: bold; font-size:16px; color: #304384;">I Have</h3>

                            <div class="row">
                                @if($profileposts->aidvalue==1)
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-medkit" style="width: 20px"></i> First Aid</p></div>
                                @else
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-medkit" style="width: 20px"></i> First Aid</del></p></div>
                                @endif

                                @if($profileposts->recordvalue == 1)
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-gavel" style="width: 20px"></i> Criminal Record Check</p></div>
                                @else
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-gavel" style="width: 20px"></i> Criminal Record Check</del></p></div>
                                @endif

                                @if($profileposts->carvalue == 1)
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-paw" style="width: 20px"></i> Comfortable with Pets</p></div>
                                @else
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-paw" style="width: 20px"></i> Comfortable with Pets</del></p></div>
                                @endif

                                @if($profileposts->licensevalue == 1)
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-id-badge" style="width: 20px"></i> Driving License</p></div>
                                @else
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-id-badge" style="width: 20px"></i> Driving License</del></p></div>
                                @endif

                                @if($profileposts->qualificationsvalue == 1)
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-certificate" style="width: 20px"></i> Certified Qualification</p></div>
                                @else
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-certificate" style="width: 20px"></i> Certified Qualification</del></p></div>
                                @endif

                                @if($profileposts->refvalue == 1)
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><i class="fas fa-clipboard-list" style="width: 20px"></i> References</p></div>
                                @else
                                    <div class="col-md-6 p-0 mb-2 pr-2"><p class="full-width-tags pl-3 pr-3"><del><i class="fas fa-clipboard-list" style="width: 20px"></i> References</del></p></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr class="divide_sidebar_section" />
                    {{-- @endif --}}

                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-4" style="font-weight: bold; font-size:16px; color: #304384;">I Work With</h3>

                            <ul class="skill-tags">
                                @foreach($all_workwith as $wwith)
                                    <li><a href="javascript:void(0);" style="cursor:default;background: #F8F8F8;border-radius: 24px; color:#282828" title="">{{ $wwith }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr class="divide_sidebar_section" />
                    <div class="row ml-4 mr-4">
                        <div class="col-md-12 pl-0 pr-0">
                            <h3 class="pb-4" style="font-weight: bold; font-size:16px; color: #304384;">Education and Work Experience</h3>

                            <p class="text-justify pb-3" style="white-space: pre-wrap;">{{ $profileposts->edu_description }}
                            </p>
                        </div>
                    </div>
                    @if( (isset($datajobs['totalmatch'])) && ($datajobs['totalmatch'] > 1) )
                        <hr class="divide_sidebar_section" />
                    @endif
                    <form id="frmconnect" method="post" action="">
                        <div class="row ml-4 mr-4">
                            <div class="col-md-12 pl-0 pr-0">
                                @if($showconnect['remainingJob'] > 0)
                                    <input type="hidden" name="profileid" id="profileid"
                                           value="{{ $profileposts->id }}"/>
                                    <input type="hidden" name="providerid" id="providerid"
                                           value="{{ $profileposts->provider_id }}"/>
                                    <input type="hidden" name="profilecat" id="profilecat"
                                           value="{{ $profileposts->profile_category_id }}"/>

                                    @if($showconnect['remainingJob'] > 1)
                                        <h3 class="pb-2" style="font-weight: bold; font-size:24px; color: #304384;">
                                            Select Job</h3>
                                        <hr class="bold" />
                                    @endif

                                    @foreach($invitedJobs as $listJob)
                                    <div class="col-md-12 mt-2 mb-2 pl-0" {{ ($showconnect['remainingJob'] == 1) ? 'style=display:none' : '' }}>
                                        <div class="row">
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-radio pr-3">
                                                    <input type="radio" name="jobtitle" class="custom-control-input" disabled>
                                                    <label class="custom-control-label"
                                                        for="jobtitle{{$loop->iteration}}">{{$listJob->jobtitle}} (Already invited)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @foreach($listJobs as $listJob)
                                        <div class="col-md-12 mt-2 mb-2 pl-0" {{ ($showconnect['remainingJob'] == 1) ? 'style=display:none' : '' }}>
                                            <div class="row">
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio pr-3">
                                                        <input type="radio" id="jobtitle{{$loop->iteration}}"
                                                               data-jobid="{{ $listJob->id }}"
                                                               name="jobtitle" class="custom-control-input"
                                                               value="1" {{ (!$loop->index) ? 'Checked' : '' }}>
                                                        <label class="custom-control-label"
                                                               for="jobtitle{{$loop->iteration}}">{{$listJob->jobtitle}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="row">
                                    <div class="col-md-9 pl-0 no-pad-left-mob no-pad-right-mob text-center-mob">
                                            <a class="btn  btn-kinderway setwhitetext " @if($showconnect['buttonLink'] != '#') href="/user/client/{{ $showconnect['buttonLink'] }}" @endif id="{{ $showconnect['buttonID'] }}" style=" border-radius: 50px; cursor: pointer;padding: 5px 15px">{{ $showconnect['Message'] }}</a>
                                    </div>
                                    <div class="col-md-3 pr-0 pad-top-mob no-pad-left-mob no-pad-right-mob text-center-mob" style="display:block;align-self: center;">
                                        <a href="#" class="report-link-button " onclick="backlist();reportConnect({{ $profileposts->id }}, 'Report Profile');" style="border-radius: 50px;">Report an issue?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-document" role="tabpanel" aria-labelledby="pills-document-tab">
                <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">Only when you are connected to the  candidate you can see/request documentation</p>
            </div>

            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                @if(count($profileposts['userdetails']['videosets']) > 0)
                    @foreach($profileposts['userdetails']['videosets'] as $key=>$val)
                        <video class="mb-70px" width="100%" controls>
                            <source src="{{ url('storage/'. $val->videofile) }}" type="video/mp4">
                            Your browser does not support HTML video.
                        </video>
                    @endforeach
                @else
                    <p class="text-center pt-5" style="color: #884d9b; font-weight:bold; font-size: 16px;">No video uploaded</p>
                @endif
            </div>
        </div>
    </div>

</div>

