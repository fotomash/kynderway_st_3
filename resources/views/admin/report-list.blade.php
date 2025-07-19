@extends('layouts.master_admin')

@section('title')
    Reported Jobs Posts
@endsection

@section('reports')
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="report-list-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Expiry</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($jobPostLists as $jobPostList)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jobPostList->jobtitle }} </td>
                                    <td>{{ $jobPostList['profilecategory']['categoryname'] }} </td>
                                    <td>{{ $jobPostList['userdetails']['name'] }}</td>
                                    <td>{{ $jobPostList->usertype }}</td>
                                    <td>{{ $jobPostList->country }}</td>
                                    <td>{{ ($jobPostList->adstatus ==1) ? "Active" : 'Suspended By '.$jobPostList->suspendBy }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jobPostList->expirydt)->format('jS M Y')}}</td>
                                    <td>
                                        <form action="" method="POST">
                                            <a href="javascript.void(0)" data-toggle="modal" id="mediumButton" data-target="#mediumModal" data-attr="{{ url('admin/report-show', $jobPostList->id) }}">
                                                <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Job Details"></i>
                                            </a>
                                            <a href="javascript.void(0)" data-toggle="modal" data-target="#user-reason-details" data-attr="{{ url('admin/report-user-reason-show', $jobPostList->id) }}">
                                                <i class="fa fa-users text-primary fa-fw" data-toggle="tooltip" data-placement="bottom" title="Reported Users"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center"> No Reported Job Post</td>
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

    {{-- Reason Deerails --}}
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
                            </thead>
                            <tbody id="repored-user-data">
                            <tr>
                                <td colspan="4" align="center">
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
            $('#report-list-table').DataTable( {
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
