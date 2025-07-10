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

            <div class="tab-content m-0" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row mb-3 special" style=" width:100%; background-color: #F4F5F9;">
                        <div class="col-md-3 p-0">
                            <div class="usy-dt pb-0 pt-4">
                                <img src="{{ Helper::getProfileImage($jposts['userdetails']['profile_picture']) }}" style="background-color: #fff;" class="mb-3" width="100%" alt="">

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
{{--                                <div class="col-md-12 p-0 text-center-mob">--}}
{{--                                <a class="nav-link documentclass" style="display: inline-block; id="pills-document-tab" data-toggle="pill" href="#pills-document" role="tab" aria-controls="pills-document" aria-selected="false">--}}
{{--                                    <span  style="border: 1px solid #CBCBCB; border-radius: 18px;padding: 0.5rem !important;font-weight: 500;font-size: 14px;line-height: 15px;color: #5C5C5C;"> Documents</span>--}}
{{--                                </a>--}}
{{--                                </div>--}}


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

                        {{--                            <div class="col-lg-12 pad-left-mob mt-3">--}}
                        {{--                                <ul class="job-tags-search-provider mb-0">--}}
                        {{--                                    @php--}}
                        {{--                                        $cntjt = 0;--}}
                        {{--                                        $thisjobtype = '';--}}
                        {{--                                        $alljobtypes = array();--}}
                        {{--                                        $alljobtypes = explode(",", $jposts->jobtypes);--}}

                        {{--                                        $cntjt = count($alljobtypes);--}}
                        {{--                                        foreach($alljobtypes as $key=>$value){--}}
                        {{--                                            $tmp =  \App\Models\Job_Types::find($value);--}}
                        {{--                                            $tempjobtype =  $tmp->jobtype;--}}

                        {{--                                            if($key != $cntjt-1){--}}
                        {{--                                                $thisjobtype .= $tempjobtype.", ";--}}
                        {{--                                            }else{--}}
                        {{--                                                $thisjobtype .= $tempjobtype;--}}
                        {{--                                            }--}}
                        {{--                                        }--}}
                        {{--                                        $final_job_types = explode(",", $thisjobtype);--}}
                        {{--                                    @endphp--}}
                        {{--                                    @foreach($final_job_types as $key => $type)--}}
                        {{--                                        @if($key <= 4)--}}
                        {{--                                            <li class="limargin">--}}
                        {{--                                                <a class="shadow">--}}
                        {{--                                                    <label class="" for="checkbox1_jtype">{{ $type }}</label>--}}
                        {{--                                                </a>--}}
                        {{--                                            </li>--}}
                        {{--                                        @endif--}}
                        {{--                                    @endforeach--}}
                        {{--                                </ul>--}}

                        {{--                        </div>--}}
                        {{--                        <div class="col-md-6 pl-0 pr-0">--}}
                        {{--                            <p style="font-weight: bold; color: #8c50a0;">--}}
                        {{--                                <i class="fas fa-circle pl-3 pr-2" style="color: #8c50a0"></i> Location--}}
                        {{--                            </p>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="col-md-6 pl-0 pr-0">--}}
                        {{--                        </div>--}}
                        {{--                        <div class="col-md-12">--}}
                        {{--                            <hr class="divide_sidebar_section" />--}}
                        {{--                        </div>--}}

                        {{--                        <div class="col-md-12 mb-2">--}}
                        {{--                            <div class="row">--}}
                        {{--                                <div class="col-6 col-md-6 pl-4"><p style="color: #334683;"><strong>Country</strong></p>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-6 col-md-6 pl-0"><p style="color: #334683;">{{ $jposts->country}}</p>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-6 col-md-6 pl-4"><p style="color: #334683;"><strong>City</strong></p>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-6 col-md-6 pl-0"><p style="color: #334683;">{{ $jposts->city}}</p></div>--}}
                        {{--                                <div class="col-6 col-md-6 pl-4"><p style="color: #334683;"><strong>Area</strong></p>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="col-6 col-md-6 pl-0"><p style="color: #334683;">{{ $jposts->landmark}}</p>--}}
                        {{--                                </div>--}}
                        {{--                                @if($jposts->postalcode != '')--}}
                        {{--                                    <div class="col-6 col-md-6 pl-4"><p style="color: #334683;"><strong>Postal--}}
                        {{--                                                Code</strong></p></div>--}}
                        {{--                                    <div class="col-6 col-md-6 pl-0"><p--}}
                        {{--                                                style="color: #334683;">{{ $jposts->postalcode}}</p></div>--}}
                        {{--                                @endif--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
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
{{--                    @if(is_array($preferredLanguages) && count($preferredLanguages))--}}
{{--                        <hr class="divide_sidebar_section" />--}}
{{--                        <div class="row ml-4 mr-4">--}}
{{--                            <div class="col-md-12 pl-0 pr-0">--}}
{{--                                <h3 class="pb-2" style="font-weight: bold; font-size:16px; color: #304384;">Preferred--}}
{{--                                    Languages</h3>--}}
{{--                                <ul class="skill-tags">--}}
{{--                                    @foreach($preferredLanguages as $preferredLanguage)--}}
{{--                                        <li><a href="javascript:void(0);" style="cursor:default; color:#282828"--}}
{{--                                               title="">{{ $preferredLanguage }}</a></li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
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
                    {{-- <hr class="" /> --}}

                    <form id="frmapply" class="mb-4" method="post" action="">
                        <div class="row ml-4 mr-4">
                            <div class="col-md-12 pl-0 pr-0">

                                @if($datajobs['totmatch'] > 0)
                                    <input type="hidden" name="profileid" id="profileid"
                                           value="{{ $datajobs['providerprofileid'] }}"/>
                                    <input type="hidden" name="jobappliedid" id="jobappliedid"
                                           value="{{ $datajobs['jobappliedid'] }}"/>
                                    <input type="hidden" name="jobuserid" id="jobuserid"
                                           value="{{ $datajobs['jobuserid'] }}"/>
                                    <input type="hidden" name="categoryid" id="categoryid"
                                           value="{{ $datajobs['categoryid'] }}"/>
                                @endif

                                <div class="row">
                                    <div class="col-md-9 pl-0 no-pad-left-mob no-pad-right-mob">
                                        <button type="button" id="{{ $showconnect['buttonID'] }}" data-url="{{ $showconnect['buttonData'] }}"  class="btn btn-lg btn-block btn-kinderway" style=" border-radius: 50px; cursor: pointer;">{{ $showconnect['Message'] }}</button>
                                    </div>
                                    <div class="col-md-3 pr-0 pad-top-mob no-pad-left-mob no-pad-right-mob">
                                        <a href="#" class="btn btn-lg btn-block btn-kinderway-2 text-white" id="connectidbtn"  onclick="backlist();reportConnect({{ $jposts->id }}, 'Report Job');" style="border-radius: 50px;">REPORT</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#goToProfile").click(function () {
        // console.log('in');
        var url = $("#goToProfile").attr('data-url');
        // console.log(url);
        $(location).attr('href', './provider/service-profiles/'+url);
    });
    // console.log("test")
</script>
