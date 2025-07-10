@extends('layouts.master_user')

@section('css')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.0/dist/css/bootstrap-select.min.css"> --}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    {{-- <link rel="stylesheet" href="/website/css/jsuites.css" type="text/css" /> --}}

    <style>
        .error {
            color: red;
            padding-top: 10px;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px !important;
            color: #444;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        .file-upload-wrapper {
            position: relative;
            width: 100%;
            height: 40px;
            border: 1px solid #e5e5e5;
            border-radius: 30px;
            z-index: 0;
        }


        .file-upload-wrapper:after {
            content: attr(data-text);
            font-size: 16px;
            position: absolute;
            top: 0;
            left: 0;
            background: transparent;
            padding: 10px 15px;
            display: block;
            width: calc(100% - 80px)
            pointer-events: none;
            z-index: 20;
            height: 38px;
            overflow:hidden;
            line-height: 23px;
            color: #999;
            border-radius: 5px 10px 10px 5px;
            font-weight: 300;
        }

        .file-upload-wrapper:before {
            content: "Browse";
            position: absolute;
            top: 0;
            right: 0;
            display: inline-block;
            height: 38px;
            background: #8c50a0;
            color: #fff;
            font-weight: 700;
            z-index: 25;
            font-size: 16px;
            line-height: 40px;
            padding: 0 15px;
            /* text-transform: uppercase; */
            pointer-events: none;
            border-radius: 0 30px 30px 0;
        }

        /* .file-upload-wrapper:hover:before {
            background: #3d8c63;
        } */

        .file-upload-wrapper input {
            opacity: 0;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 99;
            height: 40px;
            margin: 0;
            padding: 0;
            display: block;
            cursor: pointer;
            width: 100%;
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
                    @include('shared.sidebar', ['active' => 'manage-documents'])
                    <div class="col-lg-9 pad-right-mob">
                        <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Manage Documents</h3>
                        <hr class="bold" />
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="security-login" role="tabpanel" aria-labelledby="security">
                                <div class="acc-setting">
                                    <div class="cp-field">
                                        Your documents Library <a type="button" class="bid_now" data-toggle="modal" id="documents_library" data-target="#documents_library_modal" onclick="openDocumentLibrary();"> See how it works here </a>
                                        @forelse ($documents as $document)
                                        <div class="row">
                                            <div class="col-md-12 p-0">
                                                <div class="row my-2">
                                                    <div class="col-md-8 p-0" style="display: flex; align-items: center; font-size: 20px;">
                                                        {{ $document->document_name }}
                                                    </div>
                                                    <div class="col-md-2">

                                                        @php
                                                        $temp_url=preg_split("#/#", $document->document_url)
                                                        @endphp

                                                        <a href="/view-pdf?url={{ $temp_url[1] }}" target="_blank">
                                                            <button type="button" class="btn btn-block btn-success" style="float: right;">
                                                                View
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <form method="post" action="{{ url('/provider/'.$document->id.'/delete-document') }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-block btn-danger" style="float: right;">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            <div class="" style="text-align:center; padding: 40px 20px 0px 20px; color: #884d9b; font-weight:bold; border-radius: 20px; width:100%;">
                                                No document(s) found
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="set-addmore pb-4">
                                        <a class="btn btn-kinderway add_button" onclick="openDocumentUploadModal();" href="#"><span>Add New Document</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Start Upload Documents Modal -->
    <div id="documentModal" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-header d-block" style="padding-bottom: 20px;">
                    <div class="swal-icon swal-icon--warning">
                        <span class="swal-icon--warning__body">
                            <span class="swal-icon--warning__dot"></span>
                        </span>
                    </div>
                    <h3 class="modal-title swal-title aligncenter modal-text" id="noteTitle"> Upload Document </h3>
                </div>
                <form method="post" id="upload_document" enctype="multipart/form-data" class="js-validate form-horizontal" action="{{ url($user_type.'/add-document') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="modal-body aligncenter">
                        <div class="form-group cp-field">
                            <div class="mb-1">
                                <label class="form-label">
                                    <span class="mintxt-modal">Document Name</span>
                                </label>
                            </div>
                            <div class="cpp-fiel error-ele">
                                <input type="text" name="document_name" id="documentName" required placeholder="Enter file name" />
                            </div>
                        </div>
                        <div class="form-group cp-field" style="margin-top:0;">
                            <div class="mb-1">
                                <label class="form-label">
                                    <span class="mintxt-modal">Select File (max 5MB)</span>
                                </label>
                            </div>
                            <div class="cpp-fiel error-ele">
                                <input type="file" name="document" style="padding-top:8px;" id="document" required />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="swal-button swal-button--cancel mt-2" data-dismiss="modal" style="border-radius: 20px; background-color: #8c50a0; color: #fff;">Cancel</button>
                        <button type="submit" id="upload_btn" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #404786; color: #fff;">Save Document</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- End Modal -->

    <!--Start Upload Documents library -->
    <div class="modal fade" id="documents_library_modal" tabindex="-1" role="dialog" aria-labelledby="documents_library_modal_label">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-white" id="documents_library_modal_label">Your documents Library</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <p id="modal-message">
                    <p  class="alert alert-dismissible ">
                        Please add any documents that you’d might want to share with the potential employers. These can be your CV, Certifications, References etc. <br><br>
                        Your documents cannot be viewed by others unless you grant access to individual users from the specific job application. You can remove the access at any time.<br><br>
                        Please note that once you upload the documents , the file names are visible to users you are chatting to, so please avoid using any confidential data in the title.<br>
                    </p>
                </p>
            </div>
            <div class="modal-footer">
              <button type="button" id="jobapplybtnok" onclick="backlist()" data-url="nanny" data-dismiss="modal" class="btn btn-lg btn-block btn-kinderway" style="background-image: linear-gradient(to right, #8c50a0 , #304384); border-radius: 50px; cursor: pointer;">ok !</button>
            </div>
          </div>
        </div>
      </div>
    <!-- End Modal -->

@endsection

@section('js')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>

        function openDocumentUploadModal() {
            $("#documentModal").modal('show');
        }

        function openDocumentLibrary() {
            $("#documents_library_modal").modal('show');
        }

        $(document).ready(function () {

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0} mb');

            if ($("#upload_document").length) {
                $("#upload_document").validate({
                    errorPlacement: function ($error, $element) {
                        $error.appendTo($element.closest("div.error-ele"));
                    },
                    rules: {
                        document_name: {
                            required: true,
                        },
                        document: {
                            required: true,
                            extension: "pdf",
                            filesize: 5120000
                        },
                    },
                    messages: {
                        'document_name': {
                            required: "Enter document name",
                        },
                        'document': {
                            required: "Select file (document)",
                            extension: "Only pdf file is allowed",
                            filesize: "Max 5MB file size allowed",
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                        $('#upload_btn').prop( "disabled", true ).css('cursor', 'not-allowed').css('opacity', '0.6');
                    }
                });
            }
        });

    </script>
@endsection
