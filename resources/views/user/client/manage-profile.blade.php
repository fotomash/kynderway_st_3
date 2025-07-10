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
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    @if (App::environment('production'))

        <!-- Event snippet for Registered Private/Business Offer conversion page -->
        <script> gtag('event', 'conversion', {'send_to': 'AW-499387801/gHEYCM7i-cICEJmbkO4B'}); </script>

    @endif

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
                        <h3 class="pb-2" style="font-weight:bold; font-size: 26px; color: #304384;">Manage Profile</h3>
                        <hr class="bold" />
                    </div> --}}
                </div>
                <div class="row">
                    @include('shared.sidebar', ['active' => 'manage-profile'])
                    <div class="col-lg-9 pad-right-mob">
                        <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Manage Profile</h3>
                        <hr class="bold" />
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="security-login" role="tabpanel"
                                 aria-labelledby="security">
                                <div class="acc-setting">
                                    {{-- <h3>Manage Profile</h3> --}}
                                    <form action="{{ url('/user/client/update_user_profile') }}" method="POST"
                                          id="update_user_profile_frm" class="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-warning mt-3">
                                                    Please note that only your Profile Picture and First Name are visible to other Users.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="cp-field col-md-12 col-lg-6 mt-0" style="">
                                                <h5>First Name</h5>
                                                <div class="cpp-fiel">
                                                    <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}"
                                                           placeholder="Enter First Name">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="cp-field col-md-12 col-lg-6 margin-top-mob" style="">
                                                <h5>Last Name</h5>
                                                <div class="cpp-fiel">
                                                    <input type="text" class="form-control" name="last_name"
                                                           value="{{Auth::user()->last_name}}"
                                                           placeholder="Enter Last Name">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="cp-field col-md-12 col-lg-6" style="">

                                                {{-- <div class="cp-field"> --}}
                                                <h5>Country Code</h5>
                                                {{-- <div class="cpp-fiel" style="width: 50%; padding-right: 20px;"> --}}
                                                <select class="js-example-basic-single select2-validation" name="phone_code"
                                                        placeholder="required languages" style="width: 100%">
                                                    {{-- <select name="phone_code" class="form-control" style="-webkit-appearance: menulist-button;"> --}}
                                                    <option value="">Select Country Code</option>
                                                    @foreach($countries AS $key => $value)
                                                        <option value="{{$value->phone_code}}" {{(Auth::user()->phone_code == $value->phone_code)? 'selected' : ''}}>{{$value->phone_code}}
                                                            ({{$value->name}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{-- </div>
                                                <div class="cpp-fiel" style="width: 50%;"> --}}
                                            </div>
                                            <div class="cp-field col-md-12 col-lg-6" style="">
                                                <h5>Phone Number</h5>

                                                <div class="cpp-fiel">
                                                    <input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}"
                                                           placeholder="Enter Phone Number">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                            </div>
                                            {{-- </div> --}}
                                            {{-- </div> --}}
                                        </div>

                                        <div class="notbar mt-3" style="border-bottom: none;">
                                            <h4>Notifications</h4>
                                            <p>Toggle to Enable or Disable activity alerts (notifications of job applications, job invitations and new messages)</p>
                                            <div class="toggle-btn">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="secondary_notifications" value="1"
                                                           class="custom-control-input"
                                                           id="customSwitch1" {{(Auth::user()->secondary_notifications == 1)? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customSwitch1"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cp-field">
                                            <h5>Your Location</h5>
                                            <div class="cpp-fiel error-ele">
                                                <select class="form-control js-example-basic-single-general select2-validation" name="job_position" id="job_position"
                                                        required style="-webkit-appearance: menulist-button;">
                                                    <option value="">Select Location</option>
                                                    <option value="UK" {{(Auth::user()->job_position == 'UK')? 'selected' : ''}} >
                                                        UK
                                                    </option>
                                                    {{--
                                                    <option value="Outside UK" {{(Auth::user()->job_position == 'Outside UK')? 'selected' : ''}}>
                                                        Outside UK (International)
                                                    </option>
                                                    --}}
                                                </select>
                                            </div>
                                        </div>


                                        <div class="cp-fiel">
                                            <div class="ro">
                                                <div class="cp-field col-md-12 col-lg-6" id="country_id" style="">
                                                    {{-- <div class="cpp-fiel" id="country_id" style="width: 50%; padding-right: 20px;"> --}}
                                                    <h5>Country</h5>
                                                    <select name="country" id="country"
                                                            class="js-example-basic-single-2 select2-validation" style="width: 100%;"
                                                            required>
                                                        <option value="">Select Country Name</option>
                                                        @foreach($countries AS $key => $value)
                                                            <option value="{{$value->name}}" {{(Auth::user()->country == $value->name)? 'selected' : ''}}
                                                                    {{('United Kingdom' == $value->name)? 'disabled' : ''}}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="cp-field col-md-12 col-lg-6" id="country_id_uk" style="">
                                                    {{-- <div class="cpp-fiel" id="country_id_uk" style="width: 50%; padding-right: 20px;"> --}}
                                                    <h5>Country</h5>
                                                    <select name="uk_country" id="uk_country"
                                                            class="js-example-basic-single-2 select2-validation" style="width: 100%;"
                                                            required>
                                                        @foreach($countries AS $key => $value)
                                                            <option value="{{$value->name}}"
                                                                    {{ ('United Kingdom' == $value->name)? 'selected' : 'disabled'}}
                                                            >{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="cp-field col-md-12 col-lg-6" id="city_id" style="">
                                                    {{-- <div class="cpp-fiel" style="width: 50%;" id="city_id"> --}}
                                                    <h5>City</h5>
                                                    <span class="citycls">
                                                <input type="text" class="form-control" name="city" id="city" value="{{Auth::user()->city}}"
                                                       placeholder="Enter City" required>
                                                </span>

                                                    <span class="ukcitycls">
                                                    <select name="ukcity" id="ukcity" class="form-control js-example-basic-single-city select2-validation"
                                                            style="-webkit-appearance: menulist-button; width: 100%; height: 2.5rem;"
                                                            required>
                                                    <option value="">Select City</option>
                                                    @foreach($londoncity AS $key => $value)
                                                            <option value="{{$value}}" {{(Auth::user()->city == $value)? 'selected' : ''}}>{{$value}}</option>
                                                        @endforeach
                                                </select></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cp-field postalcls" style="width: 100%; padding-right: 20px;">
                                            <h5>Postal Code</h5>
                                            <div class="cpp-fiel">
                                                <select name="postal_code" id="postal_code"
                                                        class="js-example-basic-single-3 select2-validation"
                                                        style="width: 100%;" required>
                                                    <option value="">Select Postal Code</option>
                                                    @foreach($londonpostal AS $key => $value)
                                                        <option value="{{$value}}" {{(Auth::user()->postal_code == $value)? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- <div class="row"> --}}
                                        <div class="cp-field col-md-12 col-lg-12" style="">
                                            {{-- <div class="cp-field" style="width: 50%; padding-right: 20px;"> --}}
                                            <h5>Area</h5>
                                            <div class="cpp-fiel">
                                                <input type="text" class="form-control" name="landmark" value="{{Auth::user()->landmark}}"
                                                       placeholder="e.g. Notting Hill/Manhattan" required>
                                                <i class="fas fa-landmark"></i>
                                            </div>
                                        </div>
                                        {{-- <div class="cp-field col-md-12 col-lg-6" style="">
                                            <div class="cp-field" style="width: 50%; padding-left: 0;">
                                            <h5>Address (Optional)</h5>
                                            <div class="cpp-fiel">
                                                <input type="text" name="address" value="{{Auth::user()->address}}"
                                                       placeholder="Enter Address">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </div>
                                        </div> --}}
                                        {{-- </div> --}}
                                        <div class="save-stngs pd2">
                                            <button type="submit" class="btn btn-kinderway" style="float: right;">Save Settings
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $('#country_id_uk').hide();
            $('#country_id').hide();
            $('#city_id').hide();

            $('.js-example-basic-single-general').select2({
                minimumResultsForSearch: -1
            });

            //-----------Country-City------------
            var profileval = {!! auth()->user()->toJson() !!};

            if ((profileval != '') && (profileval['job_position'] == 'UK')) {
                $('#country_id').hide();
                $('#country_id_uk').show();
                $('#city_id').show();
                $('.ukcitycls').show();
                $('.citycls').hide();
            } else {
                $('#country_id').show();
                $('#country_id_uk').hide();
                $('#city_id').show();
                $('.ukcitycls').hide();
                $('.citycls').show();
            }

            if ((profileval != '') && (profileval['city'] == 'London')) {
                $('.postalcls').show();
            } else {
                $('.postalcls').hide();
            }
            //--------------


            $('.js-example-basic-single-city').select2({
                placeholder: "Select City"
            });

            $('.js-example-basic-single').select2({
                placeholder: "Select Country Code"
            });
            $('.js-example-basic-single-2').select2({
                placeholder: "Select Country"
            });
            $('.js-example-basic-single-3').select2({
                placeholder: "Select Postal Code"
            });
            if ($("#update_user_profile_frm").length) {
                $("#update_user_profile_frm").validate({
                    rules: {
                        name: {
                            required: true,
                            maxlength: 12
                        },
                        last_name: {
                            required: true,
                            maxlength: 25
                        },
                        phone_code: {
                            required: true
                        },
                        phone: {
                            required: true,
                            maxlength: 15
                        },
                        job_position: {
                            required: true
                        },
                        country: {
                            required: true
                        },
                        city: {
                            required: true,
                            maxlength: 20
                        },
                        ukcity: {
                            required: true
                        },
                        postal_code: {
                            required: true
                        },
                        landmark: {
                            required: true,
                            maxlength: 40
                        },
                    },
                    messages: {
                        'name': {
                            required: "First Name field is required",
                            maxlength: "First Name max length is 12 characters"
                        },
                        'last_name': {
                            required: "Last Name field is required",
                            maxlength: "Last Name max length is 25 characters"
                        },
                        'phone_code': {
                            required: "Country Code field is required"
                        },
                        'phone': {
                            required: "Phone Number field is required",
                            maxlength: "Phone Number max length is 15 characters"
                        },
                        'job_position': {
                            required: "Your Location is required"
                        },
                        'country': {
                            required: "Country field is required"
                        },
                        'city': {
                            required: "City field is required",
                            maxlength: "City max length is 20 characters"
                        },
                        'ukcity': {
                            required: "City field is required"
                        },
                        'postal_code': {
                            required: "Postal Code field is required"
                        },
                        'landmark': {
                            required: "Area field is required",
                            maxlength: "Area max length is 40 characters"
                        },
                    },
                    errorPlacement: function (error, element) {
                        if(element.hasClass('select2-validation')){
                            error.insertAfter(element.next("span"));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            }
        });

        $('.select2-validation').on('change', function () {
            if($(this).val() != ''){
                $(this).next("span").next("label").hide();
            }
        });

        $("#job_position").change(function () {
            var job_position = $('#job_position').val();
            if (job_position != '') {

                if (job_position == 'UK') {
                    var checkuk = 'United Kingdom';
                    $('#country_id').hide();
                    $('#country_id_uk').show();
                    $('#city_id').show();
                    $('.citycls').hide();
                    $('.ukcitycls').show();
                } else {
                    $('#country_id_uk').hide();
                    $('#country_id').show();
                    $('#city_id').show();
                    $('.ukcitycls').hide();
                    $('.citycls').show();
                    $('.postalcls').hide();
                }
            }
        });


        $("#country").change(function () {
            var countryval = $('option:selected', this).text();
            //alert(countryval);

            if (countryval == 'United Kingdom') {
                $('.ukcitycls').show();
                $('#ukcity').find('option:first').attr('selected', 'selected');
                $('.citycls').hide();
            } else {
                $("#ukcity").val($("#ukcity option[selected]").val());
                $('.ukcitycls').hide();

                $("#postal_code").val($("#postal_code option[selected]").val());
                $('.postalcls').hide();

                $('.citycls').show();
                $('#city').val('');
            }
        });

        $(".ukcitycls").change(function () {
            var ukcityval = $('option:selected', this).text();

            if (ukcityval == 'London') {
                $('.postalcls').show();
                $('#postal_code').find('option:first').attr('selected', 'selected');
            } else {
                $(".postalcls option:first").attr('selected', 'selected');
                $('.postalcls').hide();
            }
        });
    </script>
@endsection
