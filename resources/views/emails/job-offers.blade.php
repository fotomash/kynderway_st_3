@component('mail::message')

{{-- Test: {{ $content[0]['jobtitle'] }}

@foreach($content as $job)

  {{ $job['jobtitle'] }}

@endforeach --}}

<style>

    body {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        overflow-x: hidden;
        font-size: 1rem;
        font-weight: 300;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
    }

    .post-bar {
        float: left;
        width: 100%;
        background-color: #fff;
        margin-bottom: 20px;
        /* padding: 20px; */
        box-shadow: 0 2px #e4e4e4;
        /* border-radius: 15px; */
        border-radius: 20px;
    }

    .shadow {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }

    .row {
        margin: 0;
        display: flex;
        flex-wrap: wrap;
    }

    div {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;
    }

    /* @media (min-width: 768px) { */
        .col-md-3 {
            -ms-flex: 0 0 25%;
            flex: 0 0 25%;
            max-width: 25%;
        }
    /* } */

    .p-0 {
        padding: 0!important;
    }

    .usy-dt {
        /* float: left; */
        width: 156px;
        margin: auto;
    }

    .pt-4, .py-4 {
        padding-top: 1.5rem!important;
    }

    .pb-0, .py-0 {
        padding-bottom: 0!important;
    }

    .usy-dt img {
        margin-top: 2px;
        -webkit-border-radius: 30px;
        -moz-border-radius: 30px;
        -ms-border-radius: 30px;
        -o-border-radius: 30px;
        border-radius: 30px;
        /* border: 2px solid #bbb; */
        border: 1px solid #e5e5e5;
        height: 165px;
        object-fit: cover;
    }

    .mb-3, .my-3 {
        margin-bottom: 1rem!important;
    }

    img {
        max-width: 100%;
    }

    img {
        float: left;
    }

    .pt-4, .py-4 {
        padding-top: 1.5rem!important;
    }

    .p-2 {
        padding: 0.5rem!important;
    }
    p {
        font-size: 14px;
        line-height: 24px;
        /* color: #666; */
        color: #444;
    }

    .pad-right-mob {
        padding-right: 0px !important;
    }

    .pad-left-mob {
        padding-left: 0px !important;
    }

    .pb-4, .py-4 {
        padding-bottom: 1.5rem!important;
    }

    .pt-4, .py-4 {
        padding-top: 1.5rem!important;
    }

        .col-md-9 {
            -ms-flex: 0 0 75%;
            flex: 0 0 75%;
            max-width: 75%;
        }

    .pad-left-mob {
        padding-left: 0px !important;
    }

    .usy-name {
        width: 100%;
    }

    .ml-0, .mx-0 {
        margin-left: 0!important;
    }

    .usy-name h3 {
        font-weight: 600;
        margin-bottom: 5px;
        margin-top: 2px;
        color: #fff;
        font-size: 17px;
    }

    .job-tags {
        float: left;
        width: 100%;
        margin-bottom: 15px;
    }

    ul.job-tags {
        padding-left: 0 !important;
        margin-left: 0 !important;
    }

    .pr-4, .px-4 {
        padding-right: 1.5rem!important;
    }
    .pt-2, .py-2 {
        padding-top: 0.5rem!important;
    }
    ol, ul {
        list-style: none;
    }

    .job-tags.profile li {
        /* padding: 10px; */
        padding: 10px 5px;
    }

    .job-tags li {
        display: inline-block;
        margin-right: 6px;
        margin-bottom: 10px;
    }

    a:not([href]):not([tabindex]) {
        color: inherit;
        text-decoration: none;
    }
    .job-tags li a {
        display: inline-block;
        /* color: #b2b2b2; */
        /* color: #666; */
        font-size: 14px;
        background-color: #fff;
        -webkit-border-radius: 30px;
        -moz-border-radius: 30px;
        -ms-border-radius: 30px;
        -o-border-radius: 30px;
        border-radius: 30px;
        /* padding: 7px 15px; */
        font-weight: 500;
        border: 1px solid #fff;
        color: #444;
    }

    .usy-name span {
       /* color: #b2b2b2; */
        font-size: 14px;
        color: #fff;
    }

    a > span {
        padding-top: 0.7rem !important;
    }

    .pad-left-mob {
        padding-left: 0px !important;
    }

    .pad-top-mob {
        padding-top: 0px !important;
    }
    /* @media (min-width: 992px) { */
        .col-lg-12 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    /* } */

    .p-0 {
        padding: 0!important;
    }

    .col-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }

    .fa, .fas {
        font-weight: 900;
    }
    .fa, .far, .fas {
        font-family: "Font Awesome 5 Free";
    }
    .fa, .fab, .fad, .fal, .far, .fas {
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }
    .mr-2, .mx-2 {
        margin-right: 0.5rem!important;
    }

    .pad-left-mob {
        padding-left: 0px !important;
    }

    .p-0 {
        padding: 0!important;
    }
    .col-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }

    .mt-3, .my-3 {
        margin-top: 1rem!important;
    }
    
    .pad-right-desktop {
        padding-left: 0px;
        padding-right: 20px;
    }
 
    .mb-0, .my-0 {
        margin-bottom: 0!important;
    }

    .job-tags-search-provider li {
        display: inline-block;
        margin-right: 6px;
        margin-bottom: 10px;
    }

    ul.job-tags-search-provider {
        padding: 0 !important;
        margin: 0;
    }

    .limargin {
        margin-right: 0px !important;
    }

    a:not([href]):not([tabindex]) {
        color: inherit;
        text-decoration: none;
    }

    .job-tags-search-provider li a {
        display: inline-block;
        /* color: #b2b2b2; */
        /* color: #666; */
        font-size: 14px;
        background-color: #fff;
        -webkit-border-radius: 30px;
        -moz-border-radius: 30px;
        -ms-border-radius: 30px;
        -o-border-radius: 30px;
        border-radius: 30px;
        /* padding: 7px 15px; */
        font-weight: 500;
        border: 1px solid #fff;
        color: #444;
    }
 
    .shadow label {
        padding: 7px 15px;
        font-weight: 400;
        color: #444;
    }

    a.shadow {
        padding: 7px 0px;
    }

    .view_profile_see_more_btn {
        background-color: #8c50a0;
        border-radius: 20px;
        padding-left: 15px;
        color: #fff;
    }

    .btn {
        border-radius: 20px;
        padding: 0.375rem 0.5rem;
    }
    .btn {
        display: inline-block;
        font-weight: 400;
        color: #212529;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .fa, .fas {
        font-weight: 900;
    }
    .fa, .far, .fas {
        font-family: "Font Awesome 5 Free";
    }

    .fa, .fab, .fad, .fal, .far, .fas {
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }

    .fa-map-marker-alt:before {
        content: "\f3c5";
    }

    .col-md-12 {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }

    .inner-body {
        width: 818px !important;
    }
    
    .pad-left-mob {
        padding-left: 0px !important;
    }

</style>

@foreach($content as $job)
<a href="{{ url(env('APP_URL').'job/'.$job->slug) }}" target="_blank" style="text-decoration: none;">
    <div class="post-bar shadow">
        <div class="row" style="width:100%;" data-toggle="modal" data-target="#modal_aside_right">
            <div class="col-md-3 p-0" style="margin:0 16px;">
                <div class="usy-dt pb-0 pt-4" style="">
                    @if($job['userdetails']['profile_picture'] == '' || $job['userdetails']['profile_picture'] == null)
                        <img src="{{ url(env('APP_URL').'website/images/resources/default-dp.jpg') }}" class="mb-3" width="100%" alt="">
                    @else
                        <img src="{{ url(env('APP_URL').'storage/'.$job['userdetails']['profile_picture']) }}" class="mb-3" width="100%" alt="">                
                    @endif
                    <p class="p-2 pt-4" style="font-size: 17px; width:100%; text-align:center; color:#444;">
                        {{ $job['userdetails']['name'] }}
                    </p>
                </div>
            </div>
            <div class="col-md-9 pt-4 pb-4 pad-left-mob pad-right-mob">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <a href="{{ url(env('APP_URL').'job/'.$job->slug) }}" target="_blank" style="text-decoration: none; cursor: pointer;">
                            <div class="usy-name ml-0 pad-left-mob" style="padding: 0 20px;">
                                <h3 style="font-size: 19px; color: #304384; font-weight: 400; line-height: 1.5rem;">{{ $job['jobtitle'] }}</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="usy-name ml-0">
                            <ul class="job-tags profile pt-2 pr-4">
                                <li style="border: 1px solid #e5e5e5;border-radius: 20px;">
                                    <a style="font-size: 17px; color: #444; font-weight: 300;" title=""><span style="color:#304384; font-size: 17px;">{{ $job['usertype'] }} </span></a>
                                </li>
                                <li style="border: 1px solid #e5e5e5;border-radius: 20px;">
                                    <a style="font-size: 17px; color: #444; font-weight: 300;" title="">Posted  <span style="color:#304384; font-size: 17px;">{{ Carbon\Carbon::parse($job['created_at'])->diffForHumans() }} </span></a>
                                </li>
                                <li style="border: 1px solid #e5e5e5;border-radius: 20px;">
                                    <a style="font-size: 17px; color: #444; font-weight: 300;" title="">Starting
                                    <span style="color:#304384; font-size: 17px;">{{ ($job['asap']) ? 'ASAP' : $job['start_date'] }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 pad-top-mob pad-left-mob">
                            <div class="row">
                                <div class="col-1 p-0" style="padding-top: 4px !important;">
                                    <img alt="" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iIzhjNTBhMCIgY2xhc3M9ImJpIGJpLWdlby1hbHQtZmlsbCIgdmlld0JveD0iMCAwIDE2IDE2Ij4KICA8cGF0aCBkPSJNOCAxNnM2LTUuNjg2IDYtMTBBNiA2IDAgMCAwIDIgNmMwIDQuMzE0IDYgMTAgNiAxMHptMC03YTMgMyAwIDEgMSAwLTYgMyAzIDAgMCAxIDAgNnoiLz4KPC9zdmc+" />
                                </div>
                                <div class="col-11 p-0 pad-left-mob" style="left: -12px;">
                                    Location: {{ strlen($job['country']) > 0 ? $job['country'] : ''  }}{{ strlen($job['city']) > 0 ? ', ' . $job['city'] : ''  }}{{ strlen($job['landmark']) > 0 ? ', ' . $job['landmark'] : ''  }}{{ strlen($job['postalcode']) > 0 ? ', ' . $job['postalcode'] : ''  }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 pad-left-mob mt-3">
                            <div class="row">
                                <div class="col-1 p-0" style="padding-top: 4px !important;">
                                    <img alt="" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iIzhjNTBhMCIgY2xhc3M9ImJpIGJpLWNhbGVuZGFyLWV2ZW50LWZpbGwiIHZpZXdCb3g9IjAgMCAxNiAxNiI+CiAgPHBhdGggZD0iTTQgLjVhLjUuNSAwIDAgMC0xIDBWMUgyYTIgMiAwIDAgMC0yIDJ2MWgxNlYzYTIgMiAwIDAgMC0yLTJoLTFWLjVhLjUuNSAwIDAgMC0xIDBWMUg0Vi41ek0xNiAxNFY1SDB2OWEyIDIgMCAwIDAgMiAyaDEyYTIgMiAwIDAgMCAyLTJ6bS0zLjUtN2gxYS41LjUgMCAwIDEgLjUuNXYxYS41LjUgMCAwIDEtLjUuNWgtMWEuNS41IDAgMCAxLS41LS41di0xYS41LjUgMCAwIDEgLjUtLjV6Ii8+Cjwvc3ZnPg==" />
                                </div>
                                <div class="col-11 p-0 pad-left-mob" style="left: -12px;">
                                    Schedule: {{ str_replace(' Hours', '', $job['hoursperweek']) }} hours per week
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 pad-left-mob mt-3">
                            <div class="row">
                                <div class="col-1 p-0" style="padding-top: 4px !important;">
                                    <img alt="" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iIzhjNTBhMCIgY2xhc3M9ImJpIGJpLWNsb2NrLWhpc3RvcnkiIHZpZXdCb3g9IjAgMCAxNiAxNiI+CiAgPHBhdGggZD0iTTguNTE1IDEuMDE5QTcgNyAwIDAgMCA4IDFWMGE4IDggMCAwIDEgLjU4OS4wMjJsLS4wNzQuOTk3em0yLjAwNC40NWE3LjAwMyA3LjAwMyAwIDAgMC0uOTg1LS4yOTlsLjIxOS0uOTc2Yy4zODMuMDg2Ljc2LjIgMS4xMjYuMzQybC0uMzYuOTMzem0xLjM3LjcxYTcuMDEgNy4wMSAwIDAgMC0uNDM5LS4yN2wuNDkzLS44N2E4LjAyNSA4LjAyNSAwIDAgMSAuOTc5LjY1NGwtLjYxNS43ODlhNi45OTYgNi45OTYgMCAwIDAtLjQxOC0uMzAyem0xLjgzNCAxLjc5YTYuOTkgNi45OSAwIDAgMC0uNjUzLS43OTZsLjcyNC0uNjljLjI3LjI4NS41Mi41OS43NDcuOTFsLS44MTguNTc2em0uNzQ0IDEuMzUyYTcuMDggNy4wOCAwIDAgMC0uMjE0LS40NjhsLjg5My0uNDVhNy45NzYgNy45NzYgMCAwIDEgLjQ1IDEuMDg4bC0uOTUuMzEzYTcuMDIzIDcuMDIzIDAgMCAwLS4xNzktLjQ4M3ptLjUzIDIuNTA3YTYuOTkxIDYuOTkxIDAgMCAwLS4xLTEuMDI1bC45ODUtLjE3Yy4wNjcuMzg2LjEwNi43NzguMTE2IDEuMTdsLTEgLjAyNXptLS4xMzEgMS41MzhjLjAzMy0uMTcuMDYtLjMzOS4wODEtLjUxbC45OTMuMTIzYTcuOTU3IDcuOTU3IDAgMCAxLS4yMyAxLjE1NWwtLjk2NC0uMjY3Yy4wNDYtLjE2NS4wODYtLjMzMi4xMi0uNTAxem0tLjk1MiAyLjM3OWMuMTg0LS4yOS4zNDYtLjU5NC40ODYtLjkwOGwuOTE0LjQwNWMtLjE2LjM2LS4zNDUuNzA2LS41NTUgMS4wMzhsLS44NDUtLjUzNXptLS45NjQgMS4yMDVjLjEyMi0uMTIyLjIzOS0uMjQ4LjM1LS4zNzhsLjc1OC42NTNhOC4wNzMgOC4wNzMgMCAwIDEtLjQwMS40MzJsLS43MDctLjcwN3oiLz4KICA8cGF0aCBkPSJNOCAxYTcgNyAwIDEgMCA0Ljk1IDExLjk1bC43MDcuNzA3QTguMDAxIDguMDAxIDAgMSAxIDggMHYxeiIvPgogIDxwYXRoIGQ9Ik03LjUgM2EuNS41IDAgMCAxIC41LjV2NS4yMWwzLjI0OCAxLjg1NmEuNS41IDAgMCAxLS40OTYuODY4bC0zLjUtMkEuNS41IDAgMCAxIDcgOVYzLjVhLjUuNSAwIDAgMSAuNS0uNXoiLz4KPC9zdmc+" />
                                </div>
                                <div class="col-11 p-0 pad-left-mob" style="left: -12px;">
                                    Duration: {{ $job['jobduration'] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 pad-left-mob mt-3">
                            <div class="row">
                                <div class="col-1 p-0" style="padding-top: 4px !important;">
                                    <img alt="" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iIzhjNTBhMCIgY2xhc3M9ImJpIGJpLWNvaW4iIHZpZXdCb3g9IjAgMCAxNiAxNiI+CiAgPHBhdGggZD0iTTUuNSA5LjUxMWMuMDc2Ljk1NC44MyAxLjY5NyAyLjE4MiAxLjc4NVYxMmguNnYtLjcwOWMxLjQtLjA5OCAyLjIxOC0uODQ2IDIuMjE4LTEuOTMyIDAtLjk4Ny0uNjI2LTEuNDk2LTEuNzQ1LTEuNzZsLS40NzMtLjExMlY1LjU3Yy42LjA2OC45ODIuMzk2IDEuMDc0Ljg1aDEuMDUyYy0uMDc2LS45MTktLjg2NC0xLjYzOC0yLjEyNi0xLjcxNlY0aC0uNnYuNzE5Yy0xLjE5NS4xMTctMi4wMS44MzYtMi4wMSAxLjg1MyAwIC45LjYwNiAxLjQ3MiAxLjYxMyAxLjcwN2wuMzk3LjA5OHYyLjAzNGMtLjYxNS0uMDkzLTEuMDIyLS40My0xLjExNC0uOUg1LjV6bTIuMTc3LTIuMTY2Yy0uNTktLjEzNy0uOTEtLjQxNi0uOTEtLjgzNiAwLS40Ny4zNDUtLjgyMi45MTUtLjkyNXYxLjc2aC0uMDA1em0uNjkyIDEuMTkzYy43MTcuMTY2IDEuMDQ4LjQzNSAxLjA0OC45MSAwIC41NDItLjQxMi45MTQtMS4xMzUuOTgyVjguNTE4bC4wODcuMDJ6Ii8+CiAgPHBhdGggZD0iTTggMTVBNyA3IDAgMSAxIDggMWE3IDcgMCAwIDEgMCAxNHptMCAxQTggOCAwIDEgMCA4IDBhOCA4IDAgMCAwIDAgMTZ6Ii8+CiAgPHBhdGggZD0iTTggMTMuNWE1LjUgNS41IDAgMSAxIDAtMTEgNS41IDUuNSAwIDAgMSAwIDExem0wIC41QTYgNiAwIDEgMCA4IDJhNiA2IDAgMCAwIDAgMTJ6Ii8+Cjwvc3ZnPg==" />
                                </div>
                                <div class="col-11 p-0 pad-left-mob" style="left: -12px;">
                                    Pay:
                                    @if($job['paymentOption'] == 'fix')
                                        {!! config('kinderway.currencySymbols.'.$job['payamountcurrency'])!!}{{ $job['payamount_from'] }} - {!! config('kinderway.currencySymbols.'.$job['payamountcurrency'])!!}{{ $job['payamount_to'] }} {{ $job['payfrequency'] }}
                                    @else
                                        {{ Str::of($job['paymentOption'])->ucfirst() }}
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
                    $alljobtypes = explode(",", $job->jobtypes);

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
                    <div class="col-md-9 pad-top-mob">
                        <ul class="job-tags-search-provider mb-0">
                            @foreach($final_job_types as $key => $type)
                                @if($key <= 3)
                                    <li class="limargin">
                                        <a class="shadow">
                                            <label for="checkbox1_jtype">{{ $type }}</label>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-3 pad-top-mob pad-right-desktop">
                        <a href="{{ url(env('APP_URL').'job/'.$job->slug) }}" target="_blank" style="text-decoration: none;">
                            <div class="btn view_profile_see_more_btn" style="float:right; background-color: #8c50a0; border-radius: 20px; padding-left: 15px; color: #fff; cursor: pointer;" data-popup="2" id="profilebutton">See More 
                                <img alt="" style="padding-top: 4px; float: right;" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIxLjIiIGhlaWdodD0iMTYiIGZpbGw9IiNmZmZmZmYiIGNsYXNzPSJiaSBiaS1jaGV2cm9uLXJpZ2h0IiB2aWV3Qm94PSIwIDAgMTYgMTYiPgogIDxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTTQuNjQ2IDEuNjQ2YS41LjUgMCAwIDEgLjcwOCAwbDYgNmEuNS41IDAgMCAxIDAgLjcwOGwtNiA2YS41LjUgMCAwIDEtLjcwOC0uNzA4TDEwLjI5MyA4IDQuNjQ2IDIuMzU0YS41LjUgMCAwIDEgMC0uNzA4eiIvPgo8L3N2Zz4=" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
@endforeach

@endcomponent