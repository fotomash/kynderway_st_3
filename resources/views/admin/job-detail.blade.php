<div>

    {{-- <div><h1>Job Details</h1></div> --}}

    <div class="row">
        <div class="col-md-6">
            <div class="mb-2">
                <strong>Job Title : </strong>{{  $jobPost->jobtitle }}
            </div>

            <div class="mb-2">
                <strong>Job Duration : </strong>{{  $jobPost->jobduration }}
            </div>

            <div class="mb-2">
                <strong>Hours Per Week : </strong>{{ str_replace(' Hours', '', $jobPost->hoursperweek) }}
            </div>

            <div class="mb-2">
                <strong>Payamount : </strong>{!! config('kinderway.currencySymbols.'.$jobPost->payamountcurrency)!!} {{ $jobPost->payamount_from }} > {!! config('kinderway.currencySymbols.'.$jobPost->payamountcurrency)!!} {{ $jobPost->payamount_to }}
                 {{ $jobPost->payfrequency }}
            </div>

            <div class="mb-2">
                <strong>Job Type :</strong> {{ $allJobTypes }}
            </div>

            <div class="mb-2">
                <strong>You will work with :</strong> {{ $allWorkwith }}
            </div>

            <div class="mb-2">
                <strong>Work skills required :</strong> {{ $allJobPositions }}
            </div>

            <div class="mb-2">
                <strong>Required Languages :</strong> {{ $requiredLanguages }}
            </div>

            <div class="mb-2">
                <strong>Additional Language :</strong> {{ $preferredLanguages }}
            </div>

            <div class="mb-2">
                <strong>About Job :</strong> {{  $jobPost->job_details }}
            </div>

            <div class="mb-2">
                <strong>Work Schedule :</strong> {{  $jobPost->workschedule }}
            </div>

            <div class="mb-2">
                <strong>Start Date :</strong> {{  ($jobPost->asap) ? 'ASAP' : date('d-m-Y', strtotime($jobPost->start_date)) }}
            </div>

            <div class="mb-2">
                <strong>Expiry Date :</strong> {{  \Carbon\Carbon::parse($jobPost->expirydt)->format('jS M Y') }}
            </div>

            <div class="mb-2">
                <strong>View Count :</strong> {{  $jobPost->view_count }}
            </div>

            <div class="mb-2">
                <strong>Status :</strong> {{  ($jobPost->adstatus == 1) ? "Active" : "Suspended By ".$jobPost->suspendBy}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-2">
                <strong>Job Category : </strong> {{  $jobPost['profilecategory']['categoryname'] }}
            </div>
            <div class="mb-2">
                <strong>Job Poster Name : </strong>{{  $jobPost['userdetails']['name'] }}
            </div>
            <div class="mb-2">
                <strong>User Type : </strong>{{  $jobPost->usertype }}
            </div>
            <div class="mb-2">
                <strong>Country : </strong>{{  $jobPost->country }}
            </div>

            <div class="mb-2">
                <strong>City : </strong>{{  $jobPost->city }}
            </div>

            @if($jobPost->postalcode != '')
                <div class="mb-2">
                    <strong>Postal Code : </strong> {{  $jobPost->postalcode }}
                </div>
            @endif

            <div class="mb-2">
                <strong>Area : </strong>{{  $jobPost->landmark }}
            </div>
            @if($type == 'job-list')
                <div class="mt-4 mb-2">
                    <a class="btn btn-sm btn-primary text-white" href="{{ url('/admin/add-to-job-offers/'. $jobPost->id) }}">Add to Job Offers</a>
                </div>
            @endif
        </div>
    </div>
























</div>
