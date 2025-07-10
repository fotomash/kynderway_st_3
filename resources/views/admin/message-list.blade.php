@extends('layouts.master_admin')

@section('title')
    Messages
@endsection

@section('messages')
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="message-list-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Job Poster</th>
                                <th>Job Poster Email</th>
                                <th>Job User Type</th>
                                <th>Provider</th>
                                <th>Provider Email</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($messageLists as  $key => $messageList)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ ($messageList[0]?->connection['job']) ? (strlen($messageList[0]->connection['job']['jobtitle']) > 12 ? trim(substr($messageList[0]->connection['job']['jobtitle'],0,12)).'..' : $messageList[0]->connection['job']['jobtitle']) : '' }}</td>
                                    <td>{{ $messageList[0]->connection['jobPoster']['name']??'' }} {{ $messageList[0]->connection['jobPoster']['last_name']??''  }}</td>
                                    <td>{{ $messageList[0]->connection['jobPoster']['email']??''  }}</td>
                                    <td>{{ $messageList[0]->connection['job']['usertype']??''  }}</td>
                                    <td>{{ $messageList[0]->connection['jobProvider']['name']??''  }} {{ $messageList[0]->connection['jobProvider']['last_name']??''  }}</td>
                                    <td>{{ $messageList[0]->connection['jobProvider']['email']??''  }}</td>
                                    <td>{{ \Carbon\Carbon::parse($messageList[0]->created_at)->format('jS M Y')}}</td>
                                    <td>
                                        <form action="" method="POST">
                                            <a href="{{ url('admin/messages-detail', $key) }}">
                                                <i class="fa fa-comments text-primary fa-fw" data-toggle="tooltip"
                                                   data-placement="bottom" title="View Chats"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center"> No messages of any connections</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
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
            $('#message-list-table').DataTable( {
                stateSave: true
            } );
        });

    </script>
@endsection
