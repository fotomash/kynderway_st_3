@extends('layouts.master_user')

@section('css')
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
                {{-- <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12" style="padding-left:0; padding-right: 0;">
                                <div class="post-st">
                                    <ul>
                                        <li><a class="active" href="search-results.html" title="">SEARCH PROVIDERS</a></li>
                                        <li><a class="active" href="post-vacancy.html" title="">POST VACANCY</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row mb-4">
                    {{-- <div class="col-lg-3">
                    </div>
                    <div class="col-lg-9">
                        <h3 class="pb-2" style="font-weight:bold; font-size: 26px; color: #304384;">Manage Account</h3>
                        <hr class="bold" />
                    </div> --}}
                </div>
                <div class="row">
                    @include('shared.sidebar', ['active' => 'manage-account'])
                    <div class="col-lg-9 pad-right-mob">
                        <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Manage Account</h3>
                        <hr class="bold" />
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="nav-password" role="tabpanel"
                                 aria-labelledby="nav-password-tab">
                                <div class="acc-setting">
                                    {{-- <h3>Manage Account</h3> --}}
                                    <form action="{{ url('/user/client/change_password') }}" method="POST"
                                          id="change_password_frm" class="">
                                        @csrf
                                        <div class="cp-field">
                                            <h5>Current Password</h5>
                                            <div class="cpp-fiel">
                                                <input type="password" class="form-control" name="old_password"
                                                       placeholder="Enter Current Password">
                                                <i class="fa fa-lock"></i>
                                            </div>
                                        </div>
                                        <div class="cp-field">
                                            <h5>New Password</h5>
                                            <div class="cpp-fiel">
                                                <input type="password" class="form-control" name="new_password" id="new_password"
                                                       placeholder="Enter New Password">
                                                {{-- <i class="fa fa-lock"></i> --}}
                                                <i class="la la-eye inputicon_cls" id="hide-password" onclick="togglePasswordView()"></i>
                                                <i class="la la-eye-slash inputicon_cls" id="show-password" style="display: none;" onclick="togglePasswordView()"></i>
                                            </div>
                                        </div>
                                        <div class="cp-field">
                                            <h5>Confirm New Password</h5>
                                            <div class="cpp-fiel">
                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                                       placeholder="Enter New Password">
                                                {{-- <i class="fa fa-lock"></i> --}}
                                                <i class="la la-eye inputicon_cls" id="hide-password" onclick="togglePasswordView1()"></i>
                                                <i class="la la-eye-slash inputicon_cls" id="show-password" style="display: none;" onclick="togglePasswordView1()"></i>
                                            </div>
                                        </div>
                                        <div class="save-stngs pd2">
                                            <button type="submit" class="btn btn-kinderway" style="float: right;">Change Password
                                            </button>
                                        </div>
                                    </form>

                                    <div class="cp-field">
                                        <h5><a href="#" title="">Delete Account</a></h5>
                                        <p>You can delete your account and all information by clicking below. This can't
                                            be undone </p>
                                    </div>
                                    <div class="save-stngs pd2">
                                        <button type="submit" class="btn btn-danger show_confirm" style="border-radius: 20px; background-color: #fb9300; border-color: #fb9300;">Delete Account
                                        </button>
                                    </div>

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
                                        <span class="mintxt-modal">Deleting your Kynderway account will permanently remove all your details from the platform. If you decide to return to Kynderway in the future you will need to go through the registration process again.</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <input type="hidden" name="step" id="step" value="6"> -->
                        <div class="modal-footer">

                            <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #fb9300; border: 1px solid #fb9300; color: #fff;" id="delete_yes">Delete
                            </button>
                            <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" id="delete_no"
                                    data-dismiss="modal">Cancel
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
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            if ($("#change_password_frm").length) {
                $.validator.addMethod("passwordComplexity", function(value, element) {
                    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(value);
                }, "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.");
                $("#change_password_frm").validate({
                    rules: {
                        old_password: {
                            required: true
                        },
                        new_password: {
                            required: true,
                            minlength: 8,
                            passwordComplexity: true
                        },
                        confirm_password: {
                            required: true
                        }
                    },
                    new_password: {
                       'password': {
                            required: "Password field is required",
                            passwordComplexity: "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character."
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            }

            $("#delete_yes").click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{url('/user/client/soft_delete')}}",
                    method: "POST",
                    data: {"_token": "{{ csrf_token() }}"},
                    success: function (response) {
                        if (response.success == 1) {
                            window.location.href = "/login";
                        }else{
                            window.location.href = '/user/client/dashboard';
                        }
                    },
                    error: function (jqXHR, testStatus, error) {
                        console.log(error);
                        alert('something went wrong, contact support');
                    }
                });
            });

            $("#delete_no").click(function (e) {
                e.preventDefault();
                $("#deleteConfirmModal").modal('hide');
                return false;
            });

            $('.show_confirm').click(function (e) {
                $("#deleteConfirmModal").modal('show');
            });
        });

        function togglePasswordView() {
            var x = document.getElementById("new_password");
            if (x.type === "password") {
                x.type = "text";
                $('#hide-password').hide();
                $('#show-password').show();
            } else {
                x.type = "password";
                $('#hide-password').show();
                $('#show-password').hide();
            }
        }

        function togglePasswordView1() {
            var x = document.getElementById("confirm_password");
            if (x.type === "password") {
                x.type = "text";
                $('#hide-password').hide();
                $('#show-password').show();
            } else {
                x.type = "password";
                $('#hide-password').show();
                $('#show-password').hide();
            }
        }
    </script>
@endsection
