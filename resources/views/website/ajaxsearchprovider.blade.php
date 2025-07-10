                <div class="posts-section">

{{--                    {{dd($providerPosts)}}--}}
                    @if($totalProviders > 0)
                    @foreach($providerPosts as $providerPost)
                    <div class="post-bar shadow">
                        <div class="row" style=" width:100%;">
                            <div class="col-md-3 p-0">
                                <div class="usy-dt pb-0 pt-4">
                                {{-- <div class="usy-dt pl-4 pr-4 pb-0 pt-4"> --}}
                                    <img src="{{Helper::getProfileImage($providerPost['userdetails']['profile_picture']) }}" width="100%" alt="">

{{--                                    @if( isset($providerPost['userdetails']['getVerified']) && ($providerPost['userdetails']['getVerified']['status'] == 1))--}}
{{--                                        <div style="width: 100%; text-align:center;">--}}
{{--                                            <i class="fas fa-check-circle pt-4" title="{{ ($providerPost['userdetails']['getVerified']['adv_check'] == '0') ? 'Standard Check' : 'Advanced Check' }}" style="font-size: 17px; color:#444;"></i>--}}
{{--                                            <p style="font-size: 17px; color:#444; display: inline-block;">Verified</p>--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <div style="width: 100%; text-align:center;">--}}
{{--                                            <p class="pt-4" style="font-size: 17px; color:#444; display: inline-block;">Not Verified</p>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
                                </div>
                            </div>
                            <div class="col-md-9 pt-4 pb-4 pl-0 pr-0">
                                <div class="row">
                                    <div class="col-md-7 p-0">
                                        <div class="usy-name ml-0" style="display: flex; gap: 1rem;">
{{--                                             <h3 style="font-size: 24px; color: #304384;">{{ Str::limit($providerPost['userdetails']['name'], 22) }}, {{ \Carbon\Carbon::parse($providerPost['userdetails']['birth_date'])->age }}</h3>--}}
                                            <h3 style="font-size: 19px; color: #304384; line-height: 1.5rem;">{{ $providerPost['userdetails']['name'] }}</h3>
                                            @if( isset($providerPost['userdetails']['getVerified']) && ($providerPost['userdetails']['getVerified']['status'] == 1))

{{--                                                    <i class="fas fa-check-circle pt-4" title="{{ ($providerPost['userdetails']['getVerified']['adv_check'] == '0') ? 'Standard Check' : 'Advanced Check' }}" style="font-size: 17px; color:#444;"></i>--}}
                                                    <svg style="align-self: center;" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                        </div>

                                    </div>



{{--                                    @php--}}
{{--                                        switch ($providerPost['profilecat']['categoryname']) {--}}
{{--                                            case 'Cleaner':--}}
{{--                                                $bgColor = 'rgba(100, 180, 127, 0.2)';--}}
{{--                                                $textColor = '#64B47F';--}}
{{--                                                break;--}}
{{--                                            case 'Nanny':--}}
{{--                                                $bgColor = 'rgba(132, 85, 156, 0.2)';--}}
{{--                                                $textColor = '#84559C';--}}
{{--                                                break;--}}
{{--                                            case 'Maternity':--}}
{{--                                                $bgColor = 'rgba(51, 68, 128, 0.2)';--}}
{{--                                                $textColor = '#334480';--}}
{{--                                                break;--}}
{{--                                            case 'Housekeeper':--}}
{{--                                                $bgColor = 'rgba(237, 151, 55, 0.2)';--}}
{{--                                                $textColor = '#ED9737';--}}
{{--                                                break;--}}
{{--                                            default:--}}
{{--                                                $bgColor = 'rgba(237, 151, 55, 0.2)';--}}
{{--                                                $textColor = '#ED9737';--}}
{{--                                        }--}}
{{--                                    @endphp--}}

{{--                                    <div class="col-md-5 pl-4 pr-4 label-provider">--}}
{{--                                        <span style="align-self:center;font-weight:800;font-size:17px;color:{{ $textColor }}; background: {{ $bgColor }}; border-radius: 18px; padding:5px 10px;">{{ $providerPost['profilecat']['categoryname'] }}</span>--}}
{{--                                    </div>--}}
{{--<div class="col-md-5 pl-4 pr-4" style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: flex-end">--}}
{{--    <span style="align-self:center;font-weight:800;font-size:17px;color:#ED9737; background: rgba(237, 151, 55, 0.2);border-radius: 18px; padding:5px 10px;border-radius: 18px; ">{{ $providerPost['profilecat']['categoryname'] }}</span>--}}

{{--</div>--}}
{{--                                    <div class="col-md-5 pl-4 pr-4">--}}
{{--                                        <div class="usy-name ml-0 text-center" style="width: 100%;">--}}
{{--                                            <ul class="bk-links">--}}
{{--                                                @if(count($providerPost['userdetails']['videosets']) > 0)--}}
{{--                                                <li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="video" data-popup="{{ $providerPost->id }}"  class="videopush" id="videobutton"><i class="fas fa-video"></i></li>--}}
{{--                                                @endif--}}

{{--                                                <li class="viewprofile view_profile_see_more_btn" data-popup="{{ $providerPost->id }}" id="profilebutton">View Profile <i class="fas fa-chevron-right" style="background-color: transparent;"></i></li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    @php
                                        if($providerPost->currency == 'EUR'){
                                            $setsign = '€';
                                        }
                                        elseif($providerPost->currency == 'GBP'){
                                            $setsign = '£';
                                        }
                                        elseif($providerPost->currency == 'USD'){
                                            $setsign = '$';
                                        }
                                    @endphp
                                    <div class="col-md-12 p-0">
                                        <div class="usy-name ml-0">
                                            <ul class="job-tags profile pt-2 pad-right-mob-24" >

                                                <li >
                                                    <a style="font-size: 14px; color: #282828; font-weight: 400;" title="">{{ \Carbon\Carbon::parse($providerPost['userdetails']['birth_date'])->age }}
                                                    </a>
                                                </li>
                                                <li>                                            <span style="align-self: center;color:#282828; font-size: 14px;">{{ $providerPost['userdetails']['nationality'] }}</span>
                                                </li>
                                                <li >
                                                    <a style="font-size: 14px; color: #84559C;" title=""><span style="color:#84559C; font-size: 14px;">{{ str_replace(' Year', '', str_replace(' Years', '', $providerPost->experience2)) }}</span> years of experience
                                                        {{-- <strong style="color:#8c50a0;">{{ str_replace(' Year', '', str_replace(' Years', '', $providerPost->experience2)) }}</strong> --}}

                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 pad-top-mob pad-left-mob">
                                    <div class="row">
{{--                                        <div class="col-1 p-0">--}}
{{--                                            <i class="fas fa-map-marker-alt mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>--}}
{{--                                        </div>--}}
                                        <div class="col-11 p-0 pad-left-mob" style="color: #6B6B6B; font-size: 14px; display:flex">
                                           <span style=" display: inline-flex; min-width:6rem; color:#6B6B6B "> Location</span>
                                            <span style="color: #282828; font-size: 16px; line-height: 20px;display: inline-block;">{{ strlen($providerPost['userdetails']['country']) > 0 ? $providerPost['userdetails']['country'] : ''  }}{{ strlen($providerPost['userdetails']['city']) > 0 ? ', ' . $providerPost['userdetails']['city'] : ''  }}{{ strlen($providerPost['userdetails']['landmark']) > 0 ? ', ' . $providerPost['userdetails']['landmark'] : ''  }}{{ strlen($providerPost['userdetails']['postal_code']) > 0 ? ', ' . $providerPost['userdetails']['postal_code'] : ''  }}</span>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $otherlanguages = '';
                                    $cnt = 0 ;
                                    if(count($providerPost['userdetails']['userlanguages']) > 0)
                                    {
                                        foreach($providerPost['userdetails']['userlanguages'] as $key=>$val){
                                        $cnt++;
                                        if ($key == count($providerPost['userdetails']['userlanguages']) - 1) {
                                                $otherlanguages .= $val['language_name'];
                                            }else {
                                                $otherlanguages .= $val['language_name'].", ";
                                            }
                                        }
                                    }
                                    if($cnt){
                                        $final_lang_list = $providerPost['userdetails']['native_language'].", ".$otherlanguages;
                                    }else{
                                        $final_lang_list = $providerPost['userdetails']['native_language'];
                                    }
                                @endphp
                                <div class="col-lg-12 pad-left-mob mt-3">
                                    <div class="row">
{{--                                        <div class="col-1 p-0">--}}
{{--                                            <i class="fas fa-comments mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>--}}
{{--                                        </div>--}}
                                        <div class="col-11 p-0 pad-left-mob" style="color: #6B6B6B; font-size: 14px; display:flex">
                                            <span style=" display: inline-flex; min-width:6rem; color:#6B6B6B "> Languages</span> <span style="display: inline-block;color: #282828; font-size: 16px; line-height: 20px">{{ Str::limit($final_lang_list, 60)}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 pad-left-mob mt-3">
                                    <div class="row">
{{--                                        <div class="col-1 p-0">--}}
{{--                                            <i class="fas fa-history mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>--}}
{{--                                        </div>--}}
                                        <div class="col-11 p-0 pad-left-mob" style="color: #6B6B6B; font-size: 14px;display:flex">
                                            <span style=" display: inline-flex; min-width:6rem; color:#6B6B6B "> Duration</span> <span style="display: inline-block;color: #282828; font-size: 16px; line-height: 20px">{!! str_replace(',',', ',$providerPost->job_duration) !!}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 pad-left-mob mt-3">
                                    <div class="row">
{{--                                        <div class="col-1 p-0">--}}
{{--                                            <i class="fas fa-coins mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>--}}
{{--                                        </div>--}}
                                        <div class="col-11 p-0 pad-left-mob" style="color: #6B6B6B; font-size: 14px; display:flex">
                                            <span style=" display: inline-flex; min-width:6rem; color:#6B6B6B">Pay from</span>  <span style="display: inline-block;color: #282828; font-size: 16px; line-height: 20px">{{ $setsign }}{{ $providerPost->payamount }}  {{ $providerPost->payfrequency }}</span>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $cntjt = 0;
                                    $thisjobtype = '';
                                    $alljobtypes = array();
                                    $alljobtypes = explode(",", $providerPost->jobtypes);

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
{{--                                <div class="col-lg-12 pad-left-mob mt-3">--}}
{{--                                    <ul class="job-tags-search-provider mb-0">--}}
{{--                                        @foreach($final_job_types as $key => $type)--}}
{{--                                            @if($key <= 4)--}}
{{--                                                <li class="limargin">--}}
{{--                                                    <a class="shadow">--}}
{{--                                                        <label class="" for="checkbox1_jtype">{{ $type }}</label>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}



                            </div>
                                <div class="row" style="justify-content: flex-end; padding-top:3% ">
                                <div class="col-md-5 pl-4 pr-4">
                                    <div class="usy-name ml-0 text-center" style="width: 100%;">
                                        <ul class="bk-links">
{{--                                            @if(count($providerPost['userdetails']['videosets']) > 0)--}}
{{--                                                <li data-toggle="tooltip" data-placement="bottom" title="" data-original-title="video" data-popup="{{ $providerPost->id }}"  class="videopush" id="videobutton"><i class="fas fa-video"></i></li>--}}
{{--                                            @endif--}}

                                            <li class="viewprofile view_profile_see_more_btn" data-popup="{{ $providerPost->id }}" id="profilebutton">View Profile <i class="fas fa-chevron-right" style="background-color: transparent;"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                </div>

                        </div>
                    </div>
                </div>
             @endforeach
             @else
             <div class="post-bar shadow" style="padding: 10px 20px 10px 20px; color: #884d9b; font-weight:bold;">No Service Provider Found</div>
             @endif
        </div>

        @if(Auth::check() )

            @if($haveJob)

                <div class="job_pagin_links">
                    {{ $providerPosts->links('vendor.pagination.custom') }}
                </div>
            @elseif($totalProviders > 10)
                <button data-toggle="modal" data-target="#postVacancyModal" type="button" class="btn btn-kinderway btn-block" style="float: right;">See More Results</button>
            @endif
        @else
            @if(sizeof($providerPosts) >= 1)
                <button data-toggle="modal" data-target="#loginConfirmModal" type="button" class="btn btn-kinderway btn-block" style="float: right;">See More Results</button>
            @endif
        @endif
