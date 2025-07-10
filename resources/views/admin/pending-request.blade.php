@extends('layouts.master_admin')

@section('title')
    Provider Verification Request
@endsection

@section('pre-checked-providers')
    open
@endsection

@section('pre-checked-providers-pending')
    active
@endsection

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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="pending-request-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Provider Name</th>
                                    <th>Provider Email</th>
                                    <th>Identification Type</th>
                                    <th>Assigned To</th>
                                    <th>Proof Doc</th>
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingRequests as $pendingRequest)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $pendingRequest['user']['name'] }}
                                        <td>{{ $pendingRequest['user']['email'] }}
                                            {{-- {{ $pendingRequest['user']['last_name'] }} --}}
                                        </td>
                                        <td>{{ $pendingRequest->identification_type }}</td>
                                        @if($pendingRequest->assigned_user_id)
                                            <td>{{ $pendingRequest->assigned->name }}</td>
                                        @else
                                            <td>
                                                <a class="btn btn-sm btn-primary text-white" href="{{ url('/admin/assign-user-pending-verification/'. $pendingRequest->id) }}">Assign Myself</a>
                                            </td>
                                        @endif
                                        <td><a href="{{ url('/storage/' . $pendingRequest->identification_doc) }}" target="_blank">
                                        View</a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($pendingRequest->created_at)->format('jS M Y')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" onclick="changeVerificationStatus({{ $pendingRequest->id }}, '1');" data-toggle="tooltip" data-placement="bottom" title="Approve"><i class="fa fa-check fa-fw text-success"></i></a>
                                            <a href="   javascript:void(0);" onclick="changeVerificationStatus({{ $pendingRequest->id }}, '2');" data-toggle="tooltip" data-placement="bottom" title="Reject"><i class="fa fa-close fa-fw text-danger"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input type="hidden" id="notes-{{ $pendingRequest->id }}" value="{{ $pendingRequest->user_notes }}" />
                                            <a href="javascript:void(0);" onclick="addNotes('{{ $pendingRequest->id }}');" data-toggle="modal" data-target="#noteModal">
                                                <i class="fa fa-notes-medical fa-fw" data-toggle="tooltip" data-placement="bottom" title="Add Note"></i>
                                            </a>
                                            <a href="javascript.void(0)" id="mediumButton" data-target="#mediumModal{{ $pendingRequest->user->id }}" data-toggle="modal">
                                                <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="User Details"></i>
                                            </a>

                                            <!-- medium modal -->
                                            <div class="modal fade" id="mediumModal{{ $pendingRequest->user->id }}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <form method="post" class="js-validation-add-notes" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="userIds" id="userIds" value="" />
                                                            {{--<input type="hidden" name="userDetails" id="userDetails" value="" />--}}
                                                            <div class="block block-themed block-transparent mb-0">
                                                                <div class="block-header bg-primary-dark">
                                                                    <h3 class="block-title">User Details</h3>
                                                                    <div class="block-options">
                                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                                            <i class="fa fa-fw fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="block-content font-size-sm" id="mediumBody">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-2">
                                                                                <strong>First Name :</strong> {{  $pendingRequest->user->name }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Last Name :</strong> {{  $pendingRequest->user->last_name }}
                                                                            </div>

                                                                            <div class="mb-2">
                                                                                <strong>Email :</strong> {{  $pendingRequest->user->email }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>User Type :</strong> {{  ($pendingRequest->user->client_type != '') ? $pendingRequest->user->client_type : "Provider"  }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Phone Code :</strong> {{  $pendingRequest->user->phone_code }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Phone :</strong> {{  $pendingRequest->user->phone }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Country :</strong> {{  $pendingRequest->user->country }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Nationality :</strong> {{  $pendingRequest->user->nationality }}
                                                                            </div>
                                                                            {{--<div class="mb-2">
                                                                                <strong>State :</strong> {{  $pendingRequest->user->state }}
                                                                            </div>--}}
                                                                            <div class="mb-2">
                                                                                <strong>City :</strong> {{  $pendingRequest->user->city }}
                                                                            </div>

                                                                            @if($pendingRequest->user->postal_code != '')
                                                                                <div class="mb-2">
                                                                                    <strong>Postal Code :</strong> {{  $pendingRequest->user->postal_code }}
                                                                                </div>
                                                                            @endif

                                                                            <div class="mb-2">
                                                                                <strong>Area :</strong> {{  $pendingRequest->user->landmark }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Native Language:</strong> {{  $pendingRequest->user->native_language }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Birth Date:</strong> @if($pendingRequest->user->birth_date) {{ \Carbon\Carbon::parse($pendingRequest->user->birth_date.' 00:00:00')->format('jS M Y') }} @else - @endif
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="mb-2">
                                                                                <img src="{{ Helper::getProfileImage($pendingRequest->user->profile_picture) }}" alt="Profile Picture" width="100" height="100">
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Secondary Notification :</strong> {{ ($pendingRequest->user->secondary_notifications == 1) ? "On" : "Off" }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Profile Privacy :</strong> {{ ($pendingRequest->user->privacy == 1) ? "On" : "Off" }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Email Verification :</strong> {{ ($pendingRequest->user->email_verified_at != '') ? "Yes" : "No" }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Account Status :</strong> {{ ($pendingRequest->user->is_block == 1) ? "Suspended" : "Active" }}
                                                                            </div>

                                                                            @if(count($pendingRequest->user['userlanguages']) > 0)
                                                                                <div class="mb-2">
                                                                                    <strong>Other Lanugages :</strong>

                                                                                    @foreach($pendingRequest->user['userlanguages'] as $key=>$val)

                                                                                        <div class="row">
                                                                                            <div class="col-md-12 pr-4">
                                                                                                {{ $val['language_name'] }} :  {{ $val['language_level'] }}
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="block-content block-content-full text-right border-top">
                                                                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center"> No Provider Pending Requests</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal show" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" id="processRequest" class="js-validation-verified-providers" action="/admin/update-verified-status" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title verification-title"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="verifiedId" id="verifiedId" value="" />
                            <input type="hidden" name="setStatus" id="setStatus" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
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

    <div class="modal show" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="commonModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-add-notes" action="/admin/add-verify-notes" enctype="multipart/form-data">
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
                            <input type="hidden" name="verifyId" id="verifyId" value="" />
                            <input type="hidden" name="notes" id="notes" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="commentvalue">Notes</label>
                                        <textarea rows="5" columns="6" name="commentvalue" id="commentvalue" class="form-control" style="min-width: 100%"></textarea>
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
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page JS Code -->
    {{-- <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script> --}}

    <script>

    $(document).ready(function() {
            $('#pending-request-table').DataTable( {
                stateSave: true
            } );
        });

        // function addNotes(verifyId, notes){
        //     $("#verifyId").val(verifyId);
        //     $("#commentvalue").val(notes);
        // }

        function addNotes(verifyId){
            $("#verifyId").val(verifyId);
            $("#commentvalue").val($("#notes-"+verifyId).val());
        }

        function changeVerificationStatus(verifiedId, setStatus){
            var status = setStatus == 1 ? 'Approve' : 'Reject';
            $(".verification-title").html(status + ' Verification');
            // $("#verificationModal").modal('show');
            $("#verifiedId").val(verifiedId);
            $("#setStatus").val(setStatus);
            $('#processRequest').submit();
        }
    </script>

    <script src="{{ asset('assets/js/pages/be_forms_verified_providers.min.js') }}"></script>
@endsection
