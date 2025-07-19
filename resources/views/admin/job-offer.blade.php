@extends('layouts.master_admin')

@section('title')
    Jobs Offers
@endsection

@section('job-offer')
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
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full m-0" id="job-offer-table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Country</th>
                                <th>Created</th>
                                <th>Expiry</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                                @forelse($job_offers as $jobOffer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ strlen($jobOffer->job_post->jobtitle) > 20 ? trim(substr($jobOffer->job_post->jobtitle,0,20)).'..' : $jobOffer->job_post->jobtitle }}</td>
                                        <td>{{ $jobOffer['job_post']['profilecategory']['categoryname'] }} </td>
                                        <td>{{ $jobOffer['job_post']['userdetails']['name'] }}</td>
                                        <td>{{ $jobOffer['job_post']['userdetails']['email'] }}</td>
                                        <td>{{ $jobOffer->job_post->usertype }}</td>
                                        <td>{{ $jobOffer->job_post->country }}</td>

                                        
                                        <td>{{ \Carbon\Carbon::parse($jobOffer->job_post->created_at)->format('jS M Y')}}</td>
                                        <td>{{ \Carbon\Carbon::parse($jobOffer->job_post->expirydt)->format('jS M Y')}}</td>
                                        <td>
                                            <form action="" method="POST">
                                                <a href="javascript.void(0)" data-toggle="modal" id="mediumButton" data-target="#mediumModal" data-attr="{{ url('admin/job-post-show', [$jobOffer->job_post->id, 'job-offer']) }}">
                                                    <i class="fa fa-info-circle text-success fa-fw" data-toggle="tooltip" data-placement="bottom" title="Job Details"></i>
                                                </a>
                                                <a href="javascript:void(0);" onclick="deleteJobOffer('{{ $jobOffer->id }}');" data-toggle="modal" data-target="#deleteModal">
                                                    <i class="fa fa-trash text-black fa-fw" data-toggle="tooltip" data-placement="bottom" title="Delete Job Offer"></i>
                                                </a>
                                                <a href="javascript:void(0);" onclick="linkToClipboard('{{ env('APP_URL').'jobs/'.$jobOffer->job_post->slug }}');">
                                                    <i class="fa fa-clipboard fa-fw" style="color: #87CEEB;" data-toggle="tooltip" data-placement="bottom" title="Copy/Share Link"></i>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center"> No Job Offers found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if(sizeof($job_offers) > 0)
            <div class="col-lg-12 text-center">
                {{-- <div class="block"> --}}
                    {{-- <div class="block-content block-content-full">
                        <div class="table-responsive text-center"> --}}
                            <a href="javascript.void(0)" data-toggle="modal" data-target="#sendJobOfferModal">
                                <button type="button" class="btn btn-sm btn-primary p-2 pl-5 pr-5" style="font-size: 20px;">Send Job Offers Email</button>
                            </a>
                            {{-- <form action="/send-job-offers" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary p-2 pl-5 pr-5" style="font-size: 20px;">Send Job Offers Email</button>
                            </form> --}}
                        {{-- </div>
                    </div> --}}
                {{-- </div> --}}
            </div>
        @endif  
    </div>

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

    {{-- Delete Model Start --}}
    <div class="modal show" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-modal="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" class="js-validation-verified-providers" action="/admin/admin-delete-job-offer" enctype="multipart/form-data">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Delete Job Offer</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <input type="hidden" name="deleteJobOfferId" id="deleteJobOfferId" value="" />
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        Are you sure you want to delete this job offer?
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

        {{-- Send Job Offer Model Start --}}
        <div class="modal show" id="sendJobOfferModal" tabindex="-1" role="dialog" aria-labelledby="sendJobOfferModal" aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="post" action="/admin/send-job-offers">
                        @csrf
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Send Job Offers</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content font-size-sm">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            Are you sure you want to send job offers?
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
    {{-- <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}

    <!-- Page JS Code -->
    {{-- <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            // $('#job-offer-table').DataTable( {
            //     stateSave: true
            // } );
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

        function linkToClipboard(slug) {
            var tempInput = $("<input>");
            $("body").append(tempInput);
            tempInput.val(slug).select();
            document.execCommand("copy");
            tempInput.remove();
            alert("Copied job link to clipboard: " + slug);
        }

        function deleteJobOffer(offerId){
            $("#deleteJobOfferId").val(offerId);
        }
    </script>

@endsection
