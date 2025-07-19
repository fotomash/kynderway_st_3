@extends('layouts.master_admin')

@section('title')
  Deleted Job Posts
@endsection

@section('deleted-jobs')
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="deleted-jobs-table">
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
                                {{-- <th>Status</th> --}}
                                <th>Marketing</th>
                                <th>Created</th>
                                <th>Expiry</th>
                                <th>Deleted_By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($jobPostLists as $jobPostList)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strlen($jobPostList->jobtitle) > 12 ? trim(substr($jobPostList->jobtitle,0,12)).'..' : $jobPostList->jobtitle }}</td>
                                    <td>{{ $jobPostList['profilecategory']['categoryname'] }} </td>
                                    <td>{{ $jobPostList['userdetails']['name'] }}</td>
                                    <td>{{ $jobPostList['userdetails']['email'] }}</td>
                                    <td>{{ $jobPostList->usertype }}</td>
                                    <td>{{ $jobPostList->country }}</td>

                                    @if($jobPostList->assigned != null)
                                        <td>{{ $jobPostList->assigned->name }}</td>
                                    @else
                                        <td>
                                            -
                                        </td>
                                    @endif

                                    {{-- <td>{{ ($jobPostList->adstatus ==1) ? "Active" : 'Suspended By '.$jobPostList->suspendBy }}</td> --}}
                                    <td>{{ ($jobPostList->marketing) ? "Yes" : 'No' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jobPostList->created_at)->format('jS M Y')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($jobPostList->expirydt)->format('jS M Y')}}</td>
                                    <td>{{ $jobPostList->deleted_by }}</td>
                                    <td>
                                        <form action="" method="POST">
                                            <a href="javascript.void(0)" data-toggle="modal" id="mediumButton" data-target="#mediumModal" data-attr="{{ url('admin/job-post-show', $jobPostList->id) }}">
                                                <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Job Details"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center"> No Deleted Jobs</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page JS Code -->
    {{-- <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            $('#deleted-jobs-table').DataTable( {
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
                    // console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    //$('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>

@endsection
