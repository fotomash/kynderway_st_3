@extends('layouts.master_admin')

@section('title')
    Reported Profile Posts
@endsection

@section('reports')
    open
@endsection

@if($status == "Pending")
    @section('reports-profile-pending')
        active
    @endsection
@else
    @section('reports-profile-history')
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="report-profile-list-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>Duration</th>
                                <th>Amount</th>
                                <th>Frequency</th>
                                <th>Created</th>
                                <th>Assigned</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reportLists as $reportList)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reportList->profile['profilecat']['categoryname'] }} </td>
                                    <td>{{ $reportList->profile['userdetails']['name'] }}</td>
                                    <td>{{ $reportList->profile['userdetails']['email'] }}</td>
                                    <td>{{ $reportList->profile['userdetails']['country'] }}</td>
                                    <td>{{ $reportList->profile['job_duration'] }}</td>
                                    <td>{!! config('kinderway.currencySymbols.'.$reportList->profile['currency'])!!} {{ $reportList->profile['payamount'] }}</td>
                                    <td>{{ $reportList->profile['payfrequency'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reportList->profile['created_at'])->format('jS M Y')}}</td>
                                    @if($reportList->assigned_user_id)
                                        <td>{{ $reportList->assigned->name }}</td>
                                    @else
                                        <td>
                                            <a class="btn btn-sm btn-primary text-white" href="{{ url('/admin/assign-user-report/'. $reportList['id']) }}">Assign Myself</a>
                                        </td>
                                    @endif
                                    <td>
                                        <form action="" method="POST">
                                            <a href="javascript.void(0)" data-toggle="modal" id="mediumButton" data-target="#mediumModal" data-attr="{{ url('admin/profile-post-show', $reportList->profile['id']) }}">
                                                <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Profile Details"></i>
                                            </a>
                                            <input type="hidden" id="notes-{{ $reportList['id'] }}" value="{{ $reportList['user_notes'] }}" />
                                            <a href="javascript:void(0);" onclick="addNotes('{{ $reportList['id'] }}');" data-toggle="modal" data-target="#noteModal">
                                                <i class="fa fa-notes-medical fa-fw" data-toggle="tooltip" data-placement="bottom" title="Add Note"></i>
                                            </a>

                                            <a href="javascript.void(0)" data-toggle="modal" data-target="#user-reason-details" data-attr="{{ url('admin/report-user-reason-show', $reportList->id) }}">
                                                <i class="fa fa-users text-primary fa-fw" data-toggle="tooltip" data-placement="bottom" title="Reported Users"></i>
                                            </a>
                                            @if($reportList['status'])
                                                <a href="javascript:void(0);" onclick="changeProfileStatus( '{{ $reportList->profile['id'] }}','0');" data-toggle="modal" data-target="#statusModal">
                                                    <i class="fa fa-times text-warning fa-fw" data-toggle="tooltip" data-placement="bottom" title="Suspend Profile"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" onclick="changeProfileStatus( '{{ $reportList->profile['id'] }}','1');" data-toggle="modal" data-target="#statusModal">
                                                    <i class="fa fa-check text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Activate Profile"></i>
                                                </a>
                                            @endif

                                            <a href="javascript:void(0);" onclick="deleteProfile('{{ $reportList->profile['id'] }}');" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fa fa-trash text-black fa-fw" data-toggle="tooltip" data-placement="bottom" title="Delete Profile"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center"> No Profile Posted</td>
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
    {{-- <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
         aria-hidden="true">
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

    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Profile Details</h3>
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
                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Status Model Start -->
    <div class="modal show" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-verified-providers" action="/admin/update-profile-status" enctype="multipart/form-data">
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
                            <input type="hidden" name="statusProfileId" id="statusProfileId" value="" />
                            <input type="hidden" name="setStatus" id="setStatus" value="" />
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
                <form method="post" class="js-validation-verified-providers" action="/admin/admin-delete-profile" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Delete Profile</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="deleteProfileId" id="deleteProfileId" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        Are you sure you want to delete this profile?
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
            $('#report-profile-list-table').DataTable( {
                stateSave: true
            } );
        });

        // function addNotes(reportId, notes){
        //     $("#reportId").val(reportId);
        //     $("#comment").val(notes);
        // }

        function addNotes(reportId){
            $("#reportId").val(reportId);
            $("#comment").val($("#notes-"+reportId).val());
        }

        function changeProfileStatus(profileId,setStatus){
            var status = setStatus == 1 ? 'Activate' : 'Suspend';
            $(".status-title").html(status + ' Profile');
            $("#statusProfileId").val(profileId);
            $("#setStatus").val(setStatus);
        }

        function deleteProfile(profileId){
            $("#deleteProfileId").val(profileId);
        }

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
                    // console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                },
                timeout: 8000
            })
        })
    </script>
@endsection
