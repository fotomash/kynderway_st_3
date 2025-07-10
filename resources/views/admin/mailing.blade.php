@extends('layouts.master_admin')

@section('title')
    Mailing List
@endsection

@section('users')
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full" id="users-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>CreatedAt</th>
                                <th>Jobs</th>
                                <th>Emails</th>
                                <th>Progress</th>
                                <th>Finished</th>
                                <th>StartAt</th>
                                <th>FinishedAt</th>
                                <th>Error</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->createdAt }}</td>
                                    <td>{{ $item->jobs }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emails-modal-{{ $item->id }}">
                                            View
                                        </button>

                                        <div class="modal fade" id="emails-modal-{{ $item->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <pre>
                                                            {{ json_encode(json_decode($item->emails,true), JSON_PRETTY_PRINT); }}
                                                        </pre>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->progress }}/{{ $item->total }}</td>
                                    <td>{{ $item->finished ? 'Yes' : 'No' }}</td>
                                    <td>{{ $item->startAt }}</td>
                                    <td>{{ $item->finishedAt }}</td>
                                    <td>
                                        @if(!empty($item->error))
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#emails-error-{{ $item->id }}">
                                                View
                                            </button>

                                            <div class="modal fade" id="emails-error-{{ $item->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <pre>
                                                            {{ $item->error }}
                                                        </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Data</td>
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
            $('#users-table').DataTable( {
                stateSave: true
            } );
        });
    </script>

@endsection
