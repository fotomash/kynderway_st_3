@extends('layouts.master_admin')

@section('title')
    {{ $status }} Reported Job Posts
@endsection

@section('reports')
    open
@endsection

@if($status == "Pending")
    @section('reports-job-pending')
        active
    @endsection
@else
    @section('reports-job-history')
        active
    @endsection
@endif

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="report-job-list-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Country</th>
                                <th>Assigned</th>
                                <th>Status</th>
                                <th>Marketing</th>
                                <th>Created</th>
                                <th>Expiry</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reportLists as $reportList)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strlen($reportList->job['jobtitle']) > 12 ? trim(substr($reportList->job['jobtitle'],0,12)).'..' : $reportList->job['jobtitle'] }}</td>
                                    <td>{{ $reportList->job['profilecategory']['categoryname'] }} </td>
                                    <td>{{ $reportList->job['userdetails']['name'] }}</td>
                                    <td>{{ $reportList->job['userdetails']['email'] }}</td>
                                    <td>{{ $reportList->job['usertype'] }}</td>
                                    <td>{{ $reportList->job['country'] }}</td>
                                    <td>
                                    @if($reportList->assigned_user_id)
                                        {{ $reportList->assigned->name }}
                                    @else
                                        @if(!$reportList->status)
                                            None
                                        @else
                                            <a class="btn btn-sm btn-primary text-white" href="{{ url('/admin/assign-user-report/'. $reportList['id']) }}">Assigned Myself</a>
                                        @endif
                                    @endif
                                    </td>
                                    <td>{{ ($reportList->job['adstatus'] ==1) ? "Active" : 'Suspended By '.$reportList->suspendBy }}</td>
                                    <td>{{ ($reportList->job['marketing']) ? "Yes" : 'No' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reportList->job['created_at'])->format('jS M Y')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($reportList->job['expirydt'])->format('jS M Y')}}</td>
                                    <td>
                                        <form action="" method="POST">
                                            <a href="javascript.void(0)" data-toggle="modal" id="mediumButton" data-target="#mediumModal" data-attr="{{ url('admin/job-post-show', $reportList->job['id']) }}">
                                                <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Job Details"></i>
                                            </a>
                                            <input type="hidden" id="notes-{{ $reportList['id'] }}" value="{{ $reportList['user_notes'] }}" />
                                            <a href="javascript:void(0);" onclick="addNotes('{{ $reportList['id'] }}');" data-toggle="modal" data-target="#noteModal">
                                                <i class="fa fa-notes-medical fa-fw" data-toggle="tooltip" data-placement="bottom" title="Add Note"></i>
                                            </a>
                                            <a href="javascript.void(0)" data-toggle="modal" data-target="#user-reason-details" data-attr="{{ url('admin/report-user-reason-show', $reportList->id) }}">
                                                <i class="fa fa-users text-primary fa-fw" data-toggle="tooltip" data-placement="bottom" title="Reported Users"></i>
                                            </a>
                                            @if($reportList->status)
                                                @if($reportList->job['adstatus'])
                                                    <a href="javascript:void(0);" onclick="changeJobStatus( '{{ $reportList->job['id'] }}','0');" data-toggle="modal" data-target="#statusModal">
                                                        <i class="fa fa-times text-warning fa-fw" data-toggle="tooltip" data-placement="bottom" title="Suspend Job Post"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" onclick="changeJobStatus( '{{ $reportList->job['id'] }}','1');" data-toggle="modal" data-target="#statusModal">
                                                        <i class="fa fa-check text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Activate Job Post"></i>
                                                    </a>
                                                @endif

                                                <a href="javascript:void(0);" onclick="deleteJob('{{ $reportList->job['id'] }}');" data-toggle="modal" data-target="#deleteModal">
                                                    <i class="fa fa-trash text-black fa-fw" data-toggle="tooltip" data-placement="bottom" title="Delete Job"></i>
                                                </a>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center"> No Jobs Posted</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
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
                            <h3 class="block-title status-title">Change status</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="statusJobId" id="statusJobId" value="" />
                            <input type="hidden" name="setStatus" id="setStatus" value="" />
                            <input type="hidden" name="reportCheck" id="reportCheck" value="1" />
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
                            <input type="hidden" name="reportCheck" id="reportCheck" value="1" />
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
                <form method="post" class="js-validation-add-notes" action="/admin/add-report-notes" enctype="multipart/form-data">
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
                            <input type="hidden" name="reportId" id="reportId" value="" />
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
                            <button type="button" class="b  tn btn-sm btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reason Details --}}
    <div class="modal fade" id="user-reason-details" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Reported Users</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content font-size-sm">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead class="thead-light">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Reason</th>
                            <th>Date</th>
                            </thead>
                            <tbody id="repored-user-data">
                            <tr>
                                <td colspan="5" align="center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page JS Code -->
    {{-- <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script> --}}

    <script>

        $(document).ready(function() {
            $('#report-job-list-table').DataTable( {
                stateSave: true
            } );
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
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    //$('#loader').hide();
                },
                timeout: 8000
            })
        });

        // function addNotes(reportId, notes){
        //     $("#reportId").val(reportId);
        //     $("#comment").val(notes);
        // }

        function addNotes(reportId){
            $("#reportId").val(reportId);
            $("#comment").val($("#notes-"+reportId).val());
        }

        function changeJobStatus(jobId,setStatus){
            var status = setStatus == 1 ? 'Activate' : 'Suspend';
            $(".status-title").html(status + ' Job');
            $("#statusJobId").val(jobId);
            $("#setStatus").val(setStatus);
        }

        function deleteJob(jobId){
            $("#deleteJobId").val(jobId);
        }

        $('#user-reason-details').on('shown.bs.modal', function (e) {
            let href = $(e.relatedTarget).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#page-header-loader').show();
                },
                // return the result
                success: function(result) {
                    let table_data = '';
                    if(result.length > 0){
                        $.each(result, function(index, data){
                            table_data += '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + data.name + '</td>' +
                                '<td>' + data.email + '</td>' +
                                '<td>' + data.reason + '</td>' +
                                '<td>' + data.date + '</td>' +
                                '</tr>';
                        });
                    } else {
                        table_data = '<tr><td colspan="4" align="center">No Users Found</td></tr>';
                    }
                    $('#repored-user-data').html(table_data);
                },
                complete: function() {
                    //$('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                },
                timeout: 8000
            })
        })
    </script>

@endsection
