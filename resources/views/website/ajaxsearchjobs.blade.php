<style>
    .introjs-tooltipbuttons{
        display: none;
    }
    .introjs-bullets{
        display: none;
    }
    .introjs-helperLayer {
        box-shadow: none !important;
        background: none !important;


    }


</style>
<div class="posts-section">
    @if($totalJobPost > 0)
        @foreach($jobPosts as $key => $jobPost)
            <div class="post-bar shadow">
                <input type="hidden" name="popid" id="popid" value="{{ $jobPost->id }}">
                <div class="row" style=" width:100%; cursor: pointer;" data-toggle="modal"
                     data-target="#modal_aside_right">
                    <div class="col-md-3 p-0">
                        <div class="usy-dt pb-0 pt-4">
                            <img src="{{ Helper::getProfileImage($jobPost['userdetails']['profile_picture']) }}" class="mb-3"
                                 width="100%"
                                 alt="">
                            <p class="p-2 pt-4" style="font-size: 17px; width:100%; text-align:center; color:#444;">
                                {{ $jobPost['userdetails']['name'] }}
                            </p>
                            @if(Auth::check() && $jobPost->applied->count())
                            <div style="width: 100%; text-align:center;">
                                <i class="fas fa-check-circle pt-4" title="Applied" style="font-size: 17px; color:#444;"></i>
                                <p style="font-size: 17px; color:#444; display: inline-block;">Applied</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9 pt-4 pb-4 pad-left-mob pad-right-mob">
                        <div class="row">
                            <div class="col-md-12 p-0">
                                <div class="usy-name ml-0 pad-left-mob" style="padding: 0 20px;">
                                    <h3 style="font-size: 19px; color: #304384; line-height: 1.5rem;">
                                        {{ $jobPost->jobtitle }}
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="usy-name ml-0">
                                    <ul class="job-tags profile pt-2 pr-4">
                                        <li style="border: 1px solid #e5e5e5;border-radius: 20px;">
                                            <a style="font-size: 17px; color: #444;" title=""><span style="color:#304384; font-size: 17px;">{{ $jobPost->usertype }} </span></a>
                                        </li>
                                        <li style="border: 1px solid #e5e5e5;border-radius: 20px;">
                                            <a style="font-size: 17px; color: #444;" title="">Posted  <span style="color:#304384; font-size: 17px;">{{ Carbon\Carbon::parse($jobPost->created_at)->diffForHumans() }} </span></a>
                                        </li>
                                        <li style="border: 1px solid #e5e5e5;border-radius: 20px;">
                                            <a style="font-size: 17px; color: #444;" title="">Starting
                                                <span style="color:#304384; font-size: 17px;">{{ ($jobPost->asap) ? 'ASAP' : $jobPost->start_date }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 pad-top-mob pad-left-mob">
                                    <div class="row">
                                        <div class="col-1 p-0">
                                            <i class="fas fa-map-marker-alt mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>
                                        </div>
                                        <div class="col-11 p-0 pad-left-mob">
                                            Location: {{ strlen($jobPost->country) > 0 ? $jobPost->country : ''  }}{{ strlen($jobPost->city) > 0 ? ', ' . $jobPost->city : ''  }}{{ strlen($jobPost->landmark) > 0 ? ', ' . $jobPost->landmark : ''  }}{{ strlen($jobPost->postalcode) > 0 ? ', ' . $jobPost->postalcode : ''  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 pad-left-mob mt-3">
                                    <div class="row">
                                        <div class="col-1 p-0">
                                            <i class="fas fa-calendar mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>
                                        </div>
                                        <div class="col-11 p-0 pad-left-mob">
                                            Schedule: {{ str_replace(' Hours', '', $jobPost->hoursperweek) }} hours per week
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 pad-left-mob mt-3">
                                    <div class="row">
                                        <div class="col-1 p-0">
                                            <i class="fas fa-history mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>
                                        </div>
                                        <div class="col-11 p-0 pad-left-mob">
                                            Duration: {{ $jobPost->jobduration }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 pad-left-mob mt-3">
                                    <div class="row">
                                        <div class="col-1 p-0">
                                            <i class="fas fa-coins mr-2" style="font-size: 17px; color: #8c50a0; width:30px; text-align:center;"></i>
                                        </div>
                                        <div class="col-11 p-0 pad-left-mob">
                                            Pay:
                                            @if($jobPost->paymentOption == 'fix')
                                                {!! config('kinderway.currencySymbols.'.$jobPost->payamountcurrency)!!}{{ $jobPost->payamount_from }} - {!! config('kinderway.currencySymbols.'.$jobPost->payamountcurrency)!!}{{ $jobPost->payamount_to }} {{ $jobPost->payfrequency }}
                                            @else
                                                {{ Str::of($jobPost->paymentOption)->ucfirst() }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $cntjt = 0;
                            $thisjobtype = '';
                            $alljobtypes = array();
                            $alljobtypes = explode(",", $jobPost->jobtypes);

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

                        <div class="row mt-3">
                            <div class="col-md-9 pad-top-mob pad-right-desktop">
                                <ul class="job-tags-search-provider mb-0">
                                    @foreach($final_job_types as $key => $type)
                                        @if($key <= 3)
                                            <li class="limargin">
                                                <a class="shadow">
                                                    <label class="" for="checkbox1_jtype">{{ $type }}</label>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-3 pad-top-mob pad-right-desktop">
                                <div class="btn view_profile_see_more_btn" style="float:right;" data-popup="2" id="profilebutton">See More <i class="fas fa-chevron-right" style="background-color: transparent;"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="post-bar shadow --empty" style="padding: 10px 20px 10px 20px; color: #884d9b; font-weight:bold;">No Jobs Found</div>
        <a href="/search-jobs" class="btn btn-kinderway btn-block mt-5 w-50 mx-auto"  title="See other jobs">
                See other jobs
        </a>
    @endif
</div>

@if(Auth::check())
    <div class="job_pagin_links">
        {{ $jobPosts->links('vendor.pagination.custom') }}
    </div>
@else

    @if(sizeof($jobPosts) >= 1)
        <button id="load_more_job_results" type="button" class="btn btn-kinderway btn-block" style="float: right;">See More Results</button>
    @endif

@endif
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@7.0.1/minified/introjs.min.css">
<script src="
https://cdn.jsdelivr.net/npm/intro.js@7.0.1/intro.min.js
"></script>
<script>

    document.addEventListener('DOMContentLoaded', (event) => {
        fetch('/user/check-new')
            .then(response => response.json())
            .then(data => {
                if (data.is_new === 1) {
                    var intro = introJs().setOptions({
                        steps: [{
                            title: null,
                            element: document.querySelector('.six-cols'),
                            intro: '<div style="line-height: 1.5em"> Your job search starts here, good luck! To apply for the job click the button in the job card at the bottom. Check your dashboard as families and agencies might send you job offers.</div>'
                        }]
                    }).onexit(function() {
                        let token = document.querySelector('meta[name="csrf-token"]');
                        if (token) {
                            fetch('/user/exit-intro', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': token.getAttribute('content'),
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(response => response.json())
                                .then(data => console.log(data))
                                .catch(error => console.log(error));
                        }
                    });

                    intro.start();
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });

</script>
