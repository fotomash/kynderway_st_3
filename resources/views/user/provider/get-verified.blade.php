@extends('layouts.master_user')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .modal .modal-dialog-aside {
            width: 800px;
            max-width: 100%;
            height: 100%;
            margin: 0;
            transform: translate(0);
            transition: transform .2s;
        }

        .modal .modal-dialog-aside .modal-content {
            height: inherit;
            border: 0;
            border-radius: 0;
        }

        .modal .modal-dialog-aside .modal-content .modal-body {
            overflow-y: auto
        }

        .modal.fixed-left .modal-dialog-aside {
            margin-left: auto;
            transform: translateX(100%);
        }

        .modal.fixed-right .modal-dialog-aside {
            margin-right: auto;
            transform: translateX(-100%);
        }

        .modal.show .modal-dialog-aside {
            transform: translateX(0);
        }
    </style>
@endsection

@section('content')

    <section class="profile-account-setting">
        <div class="container">
            <div class="account-tabs-setting">
                @include('shared.response_msg')

                <div class="row mb-4">
                </div>
                <div class="row">
                    @include('shared.sidebar', ['active' => 'get-verified'])
                    <div class="col-lg-9 pad-right-mob">
                        <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Get Verified</h3>
                        <hr class="bold" />
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="nav-password" role="tabpanel"
                                 aria-labelledby="nav-password-tab">
                                <div class="acc-setting">
                                    {{-- <h3>Manage Account</h3> --}}

                                    @if(!isset($currentVerified->status) || $currentVerified->status != '1')
                                        <div class="alert alert-warning mt-3 ml-3 mr-3">
                                            To apply for an Account Verification, make sure you have a neutral and professional profile photo. Then select and upload one of the documents used to confirm your identity.<br/><br/>
                                            We keep your documents for the length of the time you have an Account with us as a minimum. To learn more, please see our <a target="_blank" style="color:#007bff;" href="https://kynderway.com/privacy-policy">Privacy Policy</a>
                                        </div>
                                    @endif


                                    @if($totalVerified == 0)

                                    @else
                                        @if($currentVerified->status == '0')
                                            <div class="alert alert-warning mt-3 ml-3 mr-3">
                                                Your verification is Pending.
                                            </div>
                                        @endif
                                        @if($currentVerified->status == '1')
                                            <div class="alert alert-success mt-3 ml-3 mr-3">
                                                Your verification is Approved.
                                            </div>
                                        @endif
                                    @endif

                                    {{-- @if( ($totalVerified == 1) && ($currentVerified->status == '0' || $currentVerified->status == '1'))

                                        <div class="job_descp">
                                            <h3>Verification Details</h3>
                                            <div class="row">
                                                @if($currentVerified->status == 0)
                                                    <p>Your verification is Pending.</p>
                                                @elseif($currentVerified->status == 1)
                                                    <p>Your verification is Approved.</p>
                                                @endif
                                                <div class="col-lg-12 p-0">
                                                    <div class="post-topbar mt-1 mb-1"
                                                         style="border-top: 1px solid #e5e5e5; background-color: #f7f7f7">
                                                        <div class="row">
                                                            <div class="col-md-9 p-0">
                                                                <h3 class="mb-0"
                                                                    style="display: block;padding-left: 20px;margin-left: 30px;padding-bottom: 18px;padding-top:18px;background-color: #fff;border-radius: 30px;">
                                                                    <strong>Identification Type
                                                                        : </strong> {{ $currentVerified->identification_type }}
                                                                </h3>

                                                                <h3 class="mb-0"
                                                                    style="display: block;padding-left: 20px;margin-left: 30px;padding-bottom: 18px;padding-top:18px;background-color: #fff;border-radius: 30px;">
                                                                    <strong>Proof Doc : </strong>
                                                                    <a target="_blank"
                                                                       href="{{ url('/storage/' . $currentVerified->identification_doc) }}"
                                                                       class="bid_now"
                                                                       style="color: #fff; padding: 0 20px;">View</a>
                                                                </h3>

                                                                <h3 class="mb-0"
                                                                    style="display: block;padding-left: 20px;margin-left: 30px;padding-bottom: 18px;padding-top:18px;background-color: #fff;border-radius: 30px;">
                                                                    <strong>Advanced Check : </strong>
                                                                    @if($currentVerified->adv_check == 1)
                                                                        <span>Yes</span>
                                                                    @else
                                                                        <span>No</span>
                                                                    @endif   </h3>

                                                                @if($currentVerified->adv_check == 1)
                                                                    <h3 class="mb-0"
                                                                        style="display: block;padding-left: 20px;margin-left: 30px;padding-bottom: 18px;padding-top:18px;background-color: #fff;border-radius: 30px;">
                                                                        <strong>Reference Doc : </strong>
                                                                        <a target="_blank"
                                                                           href="{{ url('/storage/' . $currentVerified->reference_doc) }}"
                                                                           class="bid_now"
                                                                           style="color: #fff; padding: 0 20px;">View</a>
                                                                    </h3>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif --}}

                                    {{-- @if( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') ) --}}
                                        <form method="POST" id="getverified_frm"
                                              action="{{ url('/provider/add-getverified') }}" class=""
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="cp-field">
                                                <div class="cpp-fiel error-ele" style="">
                                                    <h5>Identification Type</h5>
                                                    <select name="identification_type" id="identification_type" class="form-control js-example-basic-single-general"
                                                            style="-webkit-appearance: menulist-button;" @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') ) @else disabled @endif required>
                                                        <option value="">Select Identification Type</option>
                                                        <option value="National ID Card">National ID Card</option>
                                                        <option value="Driving License">Driving License</option>
                                                        <option value="Passport">Passport</option>
                                                    </select>
                                                    @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') )
                                                    @else
                                                        <p class="pt-2"><strong>Submitted ID Type :</strong> {{ $currentVerified->identification_type }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="cp-field">
                                                <h5>Upload Identification Document</h5>
                                                <div class="cpp-fiel error-ele">
                                                    <input type="file" id="proof" name="proof" style="padding-top:8px;" @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') ) @else disabled @endif value="" placeholder="Upload Proof">
                                                    <i class="fas fa-id-card"></i>
                                                    @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') )
                                                    @else
                                                        <p class="pt-2"><strong>Submitted Document :</strong> <a target="_blank" href="{{ url('/storage/' . $currentVerified->identification_doc) }}" style="color: #8c50a0;"><u>View</u></a></p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="notbar mt-3 d-none" style="border-bottom: none;">
                                                <h4>Advanced Check</h4>
                                                <p style="width: 80%;">Apply for an Advanced Check (includes Standard Check and Interview with Kynderway Consultants)</p>
                                                <div class="toggle-btn">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" name="advchk" value="1"   @if ( $totalVerified == 1) @if($currentVerified->adv_check == 1) checked @endif @endif
                                                               class="custom-control-input" id="advchk" @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') ) @else disabled @endif>
                                                        <label class="custom-control-label" for="advchk"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cp-field error-ele d-none" id="reference-doc-div">
                                                <h5>Upload Reference Document</h5>
                                                <div class="cpp-fiel">
                                                    <input type="file" id="reference" name="reference" style="padding-top:8px;" value="" placeholder="Upload Reference" @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') ) @else disabled @endif>
                                                    <i class="fas fa-id-card"></i>

                                                    @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') )
                                                    @else
                                                        @if($currentVerified->adv_check == 1)
                                                            <p class="pt-2"><strong>Submitted Document :</strong> <a target="_blank" href="{{ url('/storage/' . $currentVerified->reference_doc) }}" style="color: #8c50a0;"><u>View</u></a></p>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="cp-field error-ele d-none" id="reference-text-div">
                                                <h5>References (Optional)</h5>
                                                <div class="cpp-fiel">
                                                    <textarea row="5" name="reference_text" id="reference_text" style="white-space: pre-wrap;" @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') ) @else disabled @endif> {{ $currentVerified->reference_text ?? '' }} </textarea>
                                                    <i class="fas fa-pencil"></i>
                                                </div>
                                            </div>

                                            <div class="save-stngs pd2">
                                                <button type="submit" class="btn btn-kinderway" style="float: right;" @if ( ($totalVerified == 0) || ($totalVerified == 1 && $currentVerified->status == '2') ) @else disabled @endif>
                                                    Get Verified
                                                </button>

                                            </div>
                                        </form>

                                    {{-- @endif --}}

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--Start Delete Confirm Modal -->
        <div id="deleteConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-center">
                <div class="modal-content">
                    <div class="modal-header d-block">
                        <div class="swal-icon swal-icon--warning">
                        <span class="swal-icon--warning__body">
                          <span class="swal-icon--warning__dot"></span>
                        </span>
                        </div>
                        <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                            Delete Confirmation
                        </h3>
                    </div>
                    <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body aligncenter">
                            <div class="form-group">
                                <div class="mt-3">
                                    <label class="form-label modal_margin">
                                        <span class="mintxt-modal">Are you sure you want to delete account?</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <input type="hidden" name="step" id="step" value="6"> -->
                        <div class="modal-footer">
                            <button type="button" class="swal-button swal-button--cancel modal_margin" id="delete_no"
                                    data-dismiss="modal">Cancel
                            </button>
                            <button type="button" class="swal-button swal-button--confirm" id="delete_yes">Delete
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- End Model -->
    </section>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('.js-example-basic-single-general').select2({
                minimumResultsForSearch: -1
            });

            if ($("#getverified_frm").length) {
                $("#getverified_frm").validate({
                    errorPlacement: function ($error, $element) {
                        $error.appendTo($element.closest("div.error-ele"));
                    },
                    rules: {
                        identification_type: {
                            required: true
                        },
                        proof: {
                            required: true,
                            extension: "jpg|gif|png|jpeg|pdf"
                        },
                        reference: {
                            required: true,
                            extension: "jpg|gif|png|jpeg|pdf"
                        }
                    },
                    messages: {
                        'identification_type': {
                            required: "Please select identification type"
                        },
                        'proof': {
                            required: "Proof document is required",
                            extension: "Only jpg,jpeg,gif,png,pdf file type is allowed"
                        },
                        'reference': {
                            required: "Reference document is required",
                            extension: "Only jpg,jpeg,gif,png,pdf file type is allowed"
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            }

            $('#reference-doc-div').hide();
            $('#reference-text-div').hide();
            $('#advchk').change(function (e) {
                if (e.target.checked) {
                    $('#reference-doc-div').show();
                    $('#reference-text-div').show();
                } else {
                    $('#reference-doc-div').hide();
                    $('#reference-text-div').hide();
                }
            });

            if($("#advchk").prop('checked') == true){
                $('#reference-doc-div').show();
                $('#reference-text-div').show();
            }
        });

    </script>
@endsection
