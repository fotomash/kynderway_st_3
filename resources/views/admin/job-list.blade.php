@extends('layouts.master_admin')

@section('jobs-statistics')
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 box box-staticts box-border-gray">
                    <div class="row p-2">
                        <div class="col-4">
                            <p>Total Jobs</p>
                            <span>{{ $jobPostListsCount }}</span>
                        </div>
                        <div class="col-4">
                            <p>Active Jobs</p>
                            <span class="txt-blue">{{ $jobPostActiveListsCount }}</span>
                        </div>
                        <div class="col-4">
                            <p>Expired Jobs</p>
                            <span class="txt-gray">{{ $jobPostExpiredListsCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="ml-auto col-md-4 p-2 box-staticts box-border-gray">
                    <p class="text-left">Marketing Emails</p>
                    <a href="#"><span class="txt-blue text-left">View on Send Grid ></span></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
    Jobs Posts
    @yield('jobs-statistics')
@endsection


@section('job-post')
    active
@endsection

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div id="box-jobs-action" class="box-jobs-action d-none">
                                    <label class="--selected">0 Selected</label>
                                    <button id="btn-send-jobs" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendJobsModal">Send Jobs to Candidates</button>
                                    <a class="--reset-selected" href="#">Reset</a>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8 box-filter">
                              <form id="filter-form" action="" method="GET">
                                <label class="d-inline-flex">
                                    Category:
                                    <select name="filter-category[]" class="form-control form-control-sm select2" multiple="multiple">
                                        @foreach($categoriesList as $category)
                                            <option @if(in_array($category->id,request()->get('filter-category')??[])) selected @endIf value="{{$category->id}}">{{$category->categoryname}}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label  class="d-inline-flex">
                                    type:
                                    <select name="filter-type[]" class="form-control form-control-sm select2" multiple="multiple">
                                        @foreach([
                                            "Private" => "Private",
                                            "Business" => "Business",
                                        ] as $key => $value)
                                            <option @if(in_array($key,request()->get('filter-type')??[])) selected @endIf value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </label>
                                @php
                                    $_cities = [];
                                @endphp
                                <label  class="d-inline-flex">
                                    Country:
                                    <select name="filter-country[]" class="form-control form-control-sm select2" multiple="multiple">
                                        @foreach($countries as $country => $cities)
                                            <option @if(in_array($country,request()->get('filter-country')??[])) selected @endIf value="{{$country}}"
                                                data-cities="{{$cities && is_array($cities) ? implode(",",$cities??[]) : ''}}">{{$country}}</option>
                                            @if(in_array($country,request()->get('filter-country')??[]))
                                                @php
                                                    if($cities && is_array($cities)){
                                                        $_cities = array_merge($_cities,$cities);
                                                    }
                                                @endphp
                                            @endIf
                                        @endforeach
                                    </select>
                                </label>
                                <label  class="d-inline-flex">
                                    City:
                                    <select name="filter-city[]" class="form-control form-control-sm select2" multiple="multiple" @if(count($_cities) == 0) disabled="true" @endIf>
                                        @foreach($_cities as $city)
                                            <option @if(in_array(trim($city),request()->get('filter-city')??[])) selected @endIf value="{{trim($city)}}">{{trim($city)}}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label  class="d-inline-flex">
                                    Status:
                                    <select name="filter-status[]" class="form-control form-control-sm select2 select2" multiple="multiple">
                                        @foreach([
                                            "1" => "Available",
                                            "0" => "Expired",
                                        ] as $key => $value)
                                            <option @if(in_array($key,request()->get('filter-status')??[])) selected @endIf value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </label>
                              </form>
                            </div>
                        </div>
                        <div id="jobs-table-container">
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="job-list-table">
                                <thead class="thead-light">
                                <tr>
                                    <th>
                                        <input type="checkbox" class="job-checkbox --all" name="selectedJobs[]" value="0">
                                    </th>
                                    <th>#</th>
                                    <th>Job Title</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>Applicants</th>
                                    <th>Assigned</th>
                                    <th>Supended</th>
                                    <th>Job Sent Count</th>
                                    <th>Marketing</th>
                                    <th>Created</th>
                                    <th>Expiry</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($jobPostLists as $jobPostList)
                                    <tr>
                                        
                                        <td><input type="checkbox" class="job-checkbox" name="selectedJobs[]" value="{{$jobPostList->id}}"></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ strlen($jobPostList->jobtitle) > 12 ? trim(substr($jobPostList->jobtitle,0,12)).'..' : $jobPostList->jobtitle }}</td>
                                        <td class="--job-category">{{ $jobPostList['profilecategory']['categoryname'] }} </td>
                                        <td>{{ $jobPostList['userdetails']['name'] }}</td>
                                        <td>{{ $jobPostList['userdetails']['email'] }}</td>
                                        <td>{{ $jobPostList->usertype }}</td>
                                        <td>{{ $jobPostList->country }}</td>
                                        <td>{{ count( $jobPostList->userconnection) }}</td>
                                        @if($jobPostList->assigned_user_id)
                                            <td>{{ $jobPostList->assigned->name }}</td>
                                        @else
                                            <td>
                                                <a class="btn btn-sm btn-primary text-white" href="{{ url('/admin/assign-user-jobpost/'. $jobPostList->id) }}">Assign Myself</a>
                                            </td>
                                        @endif
    
                                        <td>{{ ($jobPostList->adstatus ==1) ? "No" : 'Suspended By '.$jobPostList->suspendBy }}</td>
                                        <td>{{ $jobPostList->total_sent }}</td>
                                        <td>{{ ($jobPostList->marketing) ? "Yes" : 'No' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($jobPostList->created_at)->format('jS M Y')}}</td>
                                        <td>{{ \Carbon\Carbon::parse($jobPostList->expirydt)->format('jS M Y')}}</td>
                                        <td>
                                            <form action="" method="POST">
                                                <a href="javascript.void(0)" data-toggle="modal" id="mediumButton" data-target="#mediumModal" data-attr="{{ url('admin/job-post-show', [$jobPostList->id, 'job-list']) }}">
                                                    <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Job Details"></i>
                                                </a>
    
                                                <input type="hidden" id="notes-{{ $jobPostList->id }}" value="{{ $jobPostList->user_notes }}" />
                                                <a href="javascript:void(0);" onclick="addNotes('{{ $jobPostList->id }}');" data-toggle="modal" data-target="#noteModal">
                                                    <i class="fa fa-notes-medical fa-fw" data-toggle="tooltip" data-placement="bottom" title="Add Note"></i>
                                                </a>
                                                @if(!$jobPostList->activeReports->count())
                                                    @if($jobPostList->adstatus)
                                                        <a href="javascript:void(0);" onclick="changeJobStatus('{{ $jobPostList->id }}','0');" data-toggle="modal" data-target="#statusModal">
                                                            <i class="fa fa-times text-warning fa-fw" data-toggle="tooltip" data-placement="bottom" title="Suspend Job Post"></i>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0);" onclick="changeJobStatus('{{ $jobPostList->id }}','1');" data-toggle="modal" data-target="#statusModal">
                                                            <i class="fa fa-check text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Activate Job Post"></i>
                                                        </a>
                                                    @endif
                                                    <a href="javascript:void(0);" onclick="deleteJob('{{ $jobPostList->id }}');" data-toggle="modal" data-target="#deleteModal">
                                                        <i class="fa fa-trash text-black fa-fw" data-toggle="tooltip" data-placement="bottom" title="Delete Job"></i>
                                                    </a>
                                                @endif
                                                @if($jobPostList->selected)
                                                    <a href="javascript:void(0);" onclick="changeJobSelect('{{ $jobPostList->id }}','0');" data-toggle="modal" data-target="#selectModal">
                                                        <i class="fa fa-eye-slash text-warning fa-fw" data-toggle="tooltip" data-placement="bottom" title="De-Select Job"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" onclick="changeJobSelect('{{ $jobPostList->id }}','1');" data-toggle="modal" data-target="#selectModal">
                                                        <i class="fa fa-eye text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Select Job"></i>
                                                    </a>
                                                @endif
                                                <a href="javascript:void(0);" onclick="linkToClipboard('{{ env('APP_URL').'jobs/'.$jobPostList->slug }}');">
                                                    <i class="fa fa-clipboard fa-fw" style="color: #87CEEB;" data-toggle="tooltip" data-placement="bottom" title="Copy/Share Link"></i>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center"> No Jobs Posted</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- medium modal -->
    {{-- <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- medium modal -->
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Job Details</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content font-size-sm" id="mediumBody">
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Status Model Start -->
    <div class="modal show" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-verified-providers" action="/admin/update-job-status" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title status-title">Change Status</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="statusJobId" id="statusJobId" value="" />
                            <input type="hidden" name="setStatus" id="setStatus" value="" />
                            <input type="hidden" name="reportCheck" id="reportCheck" value="0" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        Are you sure you want to perform this action?
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Status Model Start -->
    <div class="modal show" id="selectModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-verified-providers" action="/admin/update-job-select" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title select-title">Change Status</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="jobId" id="selectJobId" value="" />
                            <input type="hidden" name="select" id="setSelect" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        Are you sure you want to perform this action?
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Model Start --}}
    <div class="modal show" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-verified-providers" action="/admin/admin-delete-job" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Delete Job</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="deleteJobId" id="deleteJobId" value="" />
                            <input type="hidden" name="reportCheck" id="reportCheck" value="0" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        Are you sure you want to delete this job?
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal show" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="commonModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-add-notes" action="/admin/add-job-notes" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Add Notes</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="jobId" id="jobId" value="" />
                            <input type="hidden" name="notes" id="notes" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="comment">Notes</label>
                                        <textarea rows="5" columns="6" name="comment" id="comment" class="form-control" style="min-width: 100%"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal show" id="sendJobsModal" tabindex="-1" role="dialog" aria-labelledby="sendJobsModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content --step --step-1 d-none">
                <form method="post" class="js-validation-add-notes" action="/admin/send-mails" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Send Jobs to Candidates</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="jobIds" id="jobIds" value="" />
                            <div class="row">
                                <div class="col-12">
                                    <p class="bg-blue-light txt-blue h3 font-weight-light py-2 px-3">You are about to send <span class="font-weight-bold --jobs-number">0</span> jobs...</p>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-light">Please select which categories you would like to apply</label>
                                    </div>
                                    <div class="categories-container form-group">
                                        @foreach($categories as $category)
                                            <label class="category-checkbox-label">
                                                <input type="checkbox" class="category-checkbox" name="categories" value="{{$category->profile_category_id}}">{{$category->categoryname}}<span>({{$category->users}})</span>
                                            </label>
                                        @endforeach
                                        <label class="category-checkbox-label">
                                            <input type="checkbox" class="category-checkbox" name="categories" value="0">Providers without work profiles<span>({{$providerWithouWorkProfileCount}})</span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-light" for="jobs-custom-email">Custom email :</label>
                                        <textarea name="custom-email" id="jobs-custom-email" rows="5" cols="50" placeholder="email1@exmple.com|User1 Name
email2@exmple.com|User2 Name
..." style="display: block;">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <a id="send-jobs-preview" href="" class="btn btn-sm btn-outline-primary" target="_blank">Preview</a>
                            <button id="send-jobs" type="submit" class="btn btn-sm btn-primary" disabled="true">Send Email to Candidates</button>
                            <p class="font-weight-light h6 m-0">Once sent, the action cannot be canceled.</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-content --step --step-2 p-3 d-none">
                <p class="txt-blue h3 font-weight-light mb-3 text-center">Sending <span class="font-weight-bold --jobs-number">0</span> jobs to candidates...</p>
                <p class="text-center">Please do not close the window.</p>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:#fff;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" r="0" fill="none" stroke="#253169" stroke-width="2">
                      <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="0s"></animate>
                      <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="0s"></animate>
                    </circle><circle cx="50" cy="50" r="0" fill="none" stroke="#eaebf0" stroke-width="2">
                      <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.5s"></animate>
                      <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.5s"></animate>
                    </circle>
                </svg>
            </div>
            <div class="modal-content --step --step-3 p-3 d-none">
                <svg style="margin:auto;background:#fff;display:block;" width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M30 0C13.4531 0 0 13.4531 0 30C0 46.5469 13.4531 60 30 60C46.5469 60 60 46.5469 60 30C60 13.4531 46.5469 0 30 0Z" fill="#64B47F"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M44.5078 19.8867C45.2344 20.6133 45.2344 21.8086 44.5078 22.5352L26.9297 40.1133C26.5664 40.4766 26.0859 40.6641 25.6055 40.6641C25.125 40.6641 24.6445 40.4766 24.2812 40.1133L15.4922 31.3242C14.7656 30.5977 14.7656 29.4023 15.4922 28.6758C16.2187 27.9492 17.4141 27.9492 18.1406 28.6758L25.6055 36.1406L41.8594 19.8867C42.5859 19.1484 43.7812 19.1484 44.5078 19.8867Z" fill="white"/>
                </svg>
                <p class="text-center">Complete!</p>
                <p class="text-center" id="newsletter-error"></p>
                <p class="text-center" id="newsletter-users"></p>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Page JS Code -->
    {{-- <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            $('select.select2').select2();
            $('#job-list-table').DataTable();
        });

        $(document).on('click', '#job-list-table input.job-checkbox', function(event) {
            if($(this).hasClass("--all")){
                $('#job-list-table input.job-checkbox').prop('checked',$(this).prop('checked'));
            }
        });

        $(document).on('change', '#job-list-table input.job-checkbox', function(event) {
            let len = $('#job-list-table input.job-checkbox:not(.--all):checked').length;
            if(len > 0){
                $('#box-jobs-action .--selected').html(len + ' Selected');
                $('#box-jobs-action').removeClass('d-none');
            }else{
                $('#box-jobs-action').addClass('d-none');
            }
        });

        $(document).on('click', '#box-jobs-action a.--reset-selected', function(event) {
            event.preventDefault();
            $('#job-list-table input.job-checkbox').prop('checked', false);
            $('#job-list-table input.job-checkbox').trigger('change');
        });


        $(document).on('click', '#btn-send-jobs', function(event) {
            $('#sendJobsModal .modal-content.--step').addClass('d-none');
            $('#sendJobsModal .modal-content.--step.--step-1').removeClass('d-none');

            let selected = [];
            $('#job-list-table input.job-checkbox:not(.--all):checked').each(function(){
                selected.push($(this).val());
            });
            $('#sendJobsModal #jobIds').val(selected.join(','));
            $('#sendJobsModal .--jobs-number').html(selected.length);
            $('#sendJobsModal input.category-checkbox').prop('checked', false);
            $('#sendJobsModal #jobs-custom-email').val('')
            let url = "{{ url(env('APP_URL').'admin/preview-mail') }}";

            $('#sendJobsModal #send-jobs-preview').attr('href',url + '?jobs=' + selected.join(','))
 
        });

        $(document).on('submit', '#sendJobsModal form', function(event) {
            event.preventDefault();
            let data = {
                'jobs' :  $('#sendJobsModal #jobIds').val().split(','),
                'jobs_custom_email' : $('#sendJobsModal #jobs-custom-email').val(),
                'categories' : [],
                '_token' : ''
            }
            if(data.jobs.length + data.jobs_custom_email.length === 0){
                return;
            }

            $(this).find('input.category-checkbox:checked').each(function(){
                data.categories.push($(this).val());
            });

            data._token =  $(this).find('input[name="_token"]').val();
            $('#sendJobsModal .modal-content.--step.--step-1').addClass('d-none');
            $('#sendJobsModal .modal-content.--step.--step-2').removeClass('d-none');

            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data,
                headers: {
                    "X-CSRF-TOKEN": data._token
                },
                dataType: 'json',
                complete: function(request) {
                    var obj = JSON.parse(request.responseText);

                    $('#newsletter-error').html('');
                    if(obj.errorMessage.length > 0){
                        $('#newsletter-error').html('<strong> ERROR !!! ' + obj.errorMessage + '</strong>');
                    }
                  
                    $('#newsletter-users').html('The email was sent to <strong>' + obj.usersCount + '</strong> users');

                        setTimeout(() => {
                            $('#sendJobsModal .modal-content.--step.--step-2').addClass('d-none');
                            $('#sendJobsModal .modal-content.--step.--step-3').removeClass('d-none');
                        }, 1000);
                    }
            });
        });

        $(document).on('change', '#filter-form select', function(event) {
            $('#filter-form').submit();
          
        });

        $(document).on('submit', '#filter-form', function(event) {
            event.preventDefault();
            $( "#jobs-table-container" ).load( document.location.origin + document.location.pathname  + '?' +$(this).serialize() + " #job-list-table",
            function() {
                $('#job-list-table').DataTable({});
            });
        });

        $(document).on('change', '#sendJobsModal .categories-container input.category-checkbox,#jobs-custom-email', function(event) {
            let len = $('#sendJobsModal .categories-container input.category-checkbox:checked').length + $('#jobs-custom-email').val().length;
            if(len > 0){
                $('#send-jobs').prop( "disabled", false );
            }else{
                $('#send-jobs').prop( "disabled", true );
            }
        });

        $(document).on('change', 'select[name="filter-country[]"]', function(event) {
            let cities = [];
            $('select[name="filter-country[]"]').val().forEach(city => {
                cities = [...cities,...$('select[name="filter-country[]"]').find('option[value="' + city + '"]').data('cities').split(',')]
            });
            if(cities.length === 0){
                return;
            }
            $('select[name="filter-city[]"]').html(cities.map(i=>'<option value="' + i.trim() + '">' + i.trim() + '</option>'));
            $('select[name="filter-city[]"]').select2('destroy');
            $('select[name="filter-city[]"]').select2();
            if(cities.length > 0 ){
                $('select[name="filter-city[]"]').removeAttr('disabled');
            }else{
                $('select[name="filter-city[]"]').attr('disabled','true');
            }
        });


        
        $(document).on('click', '#mediumButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                  //  $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#mediumModal').modal("show");
                    $('#mediumBody').html(result.html);
                },
                complete: function() {
                    //$('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    // console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    //$('#loader').hide();
                },
                timeout: 8000
            })
        });


        function addNotes(jobId){
            $("#jobId").val(jobId);
            $("#comment").val($("#notes-"+jobId).val());
        }

        function changeJobStatus(jobId,setStatus){
            var status = setStatus == 1 ? 'Activate' : 'Suspend';
            $(".status-title").html(status + ' Job');
            $("#statusJobId").val(jobId);
            $("#setStatus").val(setStatus);
        }

        function changeJobSelect(jobId,setSelect){
            var Select = setSelect == 1 ? 'Select' : 'De-Select';
            $(".select-title").html(Select + ' Job');
            $("#selectJobId").val(jobId);
            $("#setSelect").val(setSelect);
        }

        function linkToClipboard(slug) {
            var tempInput = $("<input>");
            $("body").append(tempInput);
            tempInput.val(slug).select();
            document.execCommand("copy");
            tempInput.remove();
            alert("Copied job link to clipboard: " + slug);
        }

        function deleteJob(jobId){
            $("#deleteJobId").val(jobId);
        }
    </script>

@endsection
