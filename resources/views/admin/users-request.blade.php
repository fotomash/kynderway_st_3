@extends('layouts.master_admin')

@section('title')
    Delete User Request
@endsection

@section('user-request')
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="users-request-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Service Type</th>
                                    <th>Assigned To</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->client_type != '' ? $user->client_type : 'Provider' }}</td>
                                        @if($user->assign_user_id)
                                            <td>{{ $user->assigned->name }}</td>
                                        @else
                                            <td>
                                                <a class="btn btn-sm btn-primary text-white" href="{{ url('/admin/assign-user/'. $user->id) }}">Assign Myself</a>
                                            </td>
                                        @endif
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('jS M Y')}}</td>
                                        <td>
                                            <a href="javascript.void(0)" id="mediumButton" data-target="#mediumModal{{ $user->id }}" data-toggle="modal">
                                                <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="User Details"></i>
                                            </a>

                                            <!-- medium modal -->
                                            <div class="modal fade" id="mediumModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
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
                                                                                <strong>First Name :</strong> {{  $user->name }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Last Name :</strong> {{  $user->last_name }}
                                                                            </div>

                                                                            @if($user->client_type == 'Business')
                                                                                <div class="mb-2">
                                                                                    <strong>Company Name :</strong> {{  $user->company_name }}
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <strong>Company Website :</strong> {{  $user->company_website }}
                                                                                </div>
                                                                            @endif

                                                                            <div class="mb-2">
                                                                                <strong>Email :</strong> {{  $user->email }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>User Type :</strong> {{  ($user->client_type != '') ? $user->client_type : "Provider"  }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Phone Code :</strong> {{  $user->phone_code }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Phone :</strong> {{  $user->phone }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Country :</strong> {{  $user->country }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Nationality :</strong> {{  $user->nationality }}
                                                                            </div>
                                                                            {{--<div class="mb-2">
                                                                                <strong>State :</strong> {{  $user->state }}
                                                                            </div>--}}
                                                                            <div class="mb-2">
                                                                                <strong>City :</strong> {{  $user->city }}
                                                                            </div>

                                                                            @if($user->postal_code != '')
                                                                            <div class="mb-2">
                                                                                <strong>Postal Code :</strong> {{  $user->postal_code }}
                                                                            </div>
                                                                            @endif

                                                                            <div class="mb-2">
                                                                                <strong>Area :</strong> {{  $user->landmark }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Native Language:</strong> {{  $user->native_language }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Birth Date:</strong> @if($user->birth_date) {{ \Carbon\Carbon::parse($user->birth_date.' 00:00:00')->format('jS M Y') }} @else - @endif
                                                                            </div>
                                                                            {{-- <div class="mb-2">
                                                                                <strong>Job Position:</strong> {{  ($user->job_position != '') ? $user->job_position : "-"  }}
                                                                            </div> --}}
                                                                            <div class="mb-2">
                                                                                <strong>Assigned Admin:</strong> {{  ($user->assign_user_id) ? $user->assigned->name : "-"  }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="mb-2">
                                                                                <img src="{{ UserHelper::getProfileImage($user->profile_picture) }}" alt="Profile Picture" width="100" height="100">
                                                                            </div>
                                                                            {{-- <div class="mb-2">
                                                                                <strong>Type :</strong> {{ $user->type }}
                                                                            </div> --}}
                                                                            <div class="mb-2">
                                                                                <strong>Secondary Notification :</strong> {{ ($user->secondary_notifications == 1) ? "On" : "Off" }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Profile Privacy :</strong> {{ ($user->privacy == 1) ? "On" : "Off" }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Email Verification :</strong> {{ ($user->email_verified_at != '') ? "Yes" : "No" }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Account Status :</strong> {{ ($user->is_block == 1) ? "Suspended" : "Active" }}
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <strong>Admin Notes :</strong> {{ $user->admin_notes }}
                                                                            </div>

                                                                            @if(count($user['userlanguages']) > 0)
                                                                            <div class="mb-2">
                                                                                <strong>Other Lanugages :</strong>

                                                                                @foreach($user['userlanguages'] as $key=>$val)

                                                                                    <div class="row">
                                                                                        <div class="col-md-12 pr-4">
                                                                                            {{ $val['language_name'] }} :  {{ $val['language_level'] }}
                                                                                        </div>
                                                                                        {{-- <div class="col-md-6">
                                                                                            {{ $val['language_level'] }}
                                                                                        </div> --}}
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


                                            @if(count($user['videosets']) > 0)
                                                <a href="javascript.void(0)" id="videoButton" data-target="#videoModal{{ $user->id }}" data-toggle="modal">
                                                    <i class="fa fa-video text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="View Video"></i>
                                                </a>
                                                <!-- medium modal -->
                                                <div class="modal fade" id="videoModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="block block-themed block-transparent mb-0">
                                                                <div class="block-header bg-primary-dark">
                                                                    <h3 class="block-title">Video</h3>
                                                                    <div class="block-options">
                                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                                            <i class="fa fa-fw fa-times"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="block-content font-size-sm" id="videoBody">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-2">
                                                                                <video class="mb-70px" width="100%" controls>
                                                                                    <source src="{{ url('storage/'. $user['videosets'][0]->videofile) }}" type="video/mp4">
                                                                                    Your browser does not support HTML video.
                                                                                </video>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="block-content block-content-full text-right border-top">
                                                                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <input type="hidden" id="notes-{{ $user->id }}" value="{{ $user->admin_notes }}" />
                                            <a href="javascript:void(0);" onclick="addNotes('{{ $user->id }}');" data-toggle="modal" data-target="#noteModal">
                                                <i class="fa fa-notes-medical fa-fw" data-toggle="tooltip" data-placement="bottom" title="Add Note"></i>
                                            </a>
                                            <a href="javascript:void(0);" onclick="deleteUser('{{ $user->id }}','Hard');" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fa fa-trash text-black fa-fw" data-toggle="tooltip" data-placement="bottom" title="Blacklist User"></i>
                                            </a>
                                            <a href="javascript:void(0);" onclick="deleteUser('{{ $user->id }}','Soft');" data-toggle="modal" data-target="#deleteModal">
                                                <i class="fa fa-trash text-danger fa-fw" data-toggle="tooltip" data-placement="bottom" title="Permanently Delete User"></i>
                                            </a>
                                            <a href="javascript:void(0);" onclick="reportList('{{ url('admin/user-report-list', $user->id) }}');" data-toggle="modal" data-target="#user-report-list">
                                                <i class="fa fa-flag text-info fa-fw" data-toggle="tooltip" data-placement="bottom" title="Pending Report"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center"> No Users</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal show" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="commonModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-add-notes" action="/admin/add-notes" enctype="multipart/form-data">
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
                            <input type="hidden" name="userId" id="userId" value="" />
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

    <div class="modal show" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-verified-providers" action="/admin/update-block-status" enctype="multipart/form-data">
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
                            <input type="hidden" name="statusUserId" id="statusUserId" value="" />
                            <input type="hidden" name="setStatus" id="setStatus" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        Are you sure you want to perform this action ?
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


    <div class="modal show" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-verified-providers" action="/admin/delete-user" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title"><span class="delete-type"></span> Delete Account</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="deleteUserId" id="deleteUserId" value="" />
                            <input type="hidden" name="deleteType" id="deleteType" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        Are you sure you want to <span class="delete-type"></span> delete user account?
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

    {{-- Reason Details --}}
    <div class="modal fade" id="user-report-list" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
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
                    <div class="block-content font-size-sm" id="response-user-report-list">
                        <span class="sr-only">Loading...</span>
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
            $('#users-request-table').DataTable( {
                stateSave: true
            } );
        });

        // function addNotes(userId, notes){
        //     $("#userId").val(userId);
        //     $("#comment").val(notes);
        // }

        function addNotes(userId){
            $("#userId").val(userId);
            $("#comment").val($("#notes-"+userId).val());
        }

        function changeBlockStatus(userId, setStatus){
            var status = setStatus == 1 ? 'Suspend' : 'Activate';
            $(".status-title").html(status + ' Account');
            $("#statusUserId").val(userId);
            $("#setStatus").val(setStatus);
        }

        function deleteUser(userId, type){
            $("#deleteUserId").val(userId);
            $("#deleteType").val(type);
            $(".delete-type").html(type);
        }

        function reportList(url){
            $.ajax({
                url: url,
                beforeSend: function() {
                    $('#page-header-loader').show();
                },
                // return the result
                success: function(result) {
                    $('#response-user-report-list').html(result);
                },
                complete: function() {
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(url);
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                },
                timeout: 8000
            })
        }
    </script>

    <script src="{{ asset('assets/js/pages/be_forms_users.min.js') }}"></script>
@endsection
