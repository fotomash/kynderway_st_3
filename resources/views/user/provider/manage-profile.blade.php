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
        .image{
            height: 60px;
            width: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg clip-path='url(%23clip0_518_3565)'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M30 0C13.4531 0 0 13.4531 0 30C0 46.5469 13.4531 60 30 60C46.5469 60 60 46.5469 60 30C60 13.4531 46.5469 0 30 0Z' fill='%2364B47F'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M44.5078 19.8867C45.2344 20.6133 45.2344 21.8086 44.5078 22.5352L26.9297 40.1133C26.5664 40.4766 26.0859 40.6641 25.6055 40.6641C25.125 40.6641 24.6445 40.4766 24.2812 40.1133L15.4922 31.3242C14.7656 30.5977 14.7656 29.4023 15.4922 28.6758C16.2187 27.9492 17.4141 27.9492 18.1406 28.6758L25.6055 36.1406L41.8594 19.8867C42.5859 19.1484 43.7812 19.1484 44.5078 19.8867Z' fill='white'/%3E%3C/g%3E%3Cdefs%3E%3CclipPath id='clip0_518_3565'%3E%3Crect width='60' height='60' fill='white'/%3E%3C/clipPath%3E%3C/defs%3E%3C/svg%3E%0A");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin-bottom: 20px;
        }
        .introjs-bullets ul{
            display: none;
        }
        .introjs-skipbutton{
            display: none;
        }
    </style>

    @if (App::environment('production'))

        <!-- Event snippet for Registered Provider conversion page -->
        <script> gtag('event', 'conversion', {'send_to': 'AW-499387801/cOEGCOr4-cICEJmbkO4B'}); </script>

    @endif

@endsection

@section('content')

    <section class="profile-account-setting">
        <div class="container">
            <div class="account-tabs-setting">
                @include('shared.response_msg')
                <div class="row mb-4">
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
                                    <form action="{{ url('/provider/update_user_profile') }}" method="POST"
                                          id="update_user_profile_frm" class="">
                                        @csrf
                                        <input type="hidden" name="lang_nm" id="lang_nm"
                                               value="{{ $compactDataLang }}"/>

                                        <input type="hidden" name="lang_level" id="lang_level"
                                               value="{{ $compactDataLevel }}"/>

                                        <input type="hidden" name="lang_ids" id="lang_ids"
                                               value="{{ $compactDataIds }}"/>

                                        <input type="hidden" name="fields_limit" id="fields_limit" value="">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-warning mt-3">
                                                    Your Last Name and Phone Number are not visible to other Users. We show your age on the profile, not the actual date of birth.
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
                                        <div class="notbar mt-3" style="border-bottom: none;">
                                            <h4>Marketing</h4>
                                            <p>Toggle to enable or disable emails with job opportunities and updates about product and services.</p>
                                            <div class="toggle-btn">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="marketing" value="1"
                                                           class="custom-control-input"
                                                           id="customSwitch2" {{(Auth::user()->marketing == 1)? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customSwitch2"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="notbar mt-3" style="border-bottom: none;">
                                            <h4>Hide my Profile</h4>
                                            <p>Toggle to show or hide your profile from search results</p>
                                            <div class="toggle-btn">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="privacy" value="1"
                                                           class="custom-control-input"
                                                           id="customSwitch3" {{(Auth::user()->privacy == 1)? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="customSwitch3"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cp-field">
                                            <div class="cpp-fiel" style="">
                                                <h5>Nationality</h5>
                                                <select name="nationality" class="js-example-basic-single select2-validation"
                                                        style="width:100%;" required>
                                                    <option value="">Select Nationality</option>
                                                    @foreach($countries AS $key => $value)
                                                        <option value="{{$value->name}}" {{(Auth::user()->nationality == $value->name)? 'selected' : ''}}>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cp-field">
                                            <div class="cpp-fiel" style="">
                                                <h5>Native Language</h5>
                                                <select name="native_language" id="native_language" class="js-example-basic-single-2 nlanguage select2-validation" style="width:100%;" required>
                                                    <option value="">Select Native Language</option>
                                                    @foreach($language_supported AS $key => $value)
                                                        <option value="{{$value}}" {{(Auth::user()->native_language == $value)? 'selected' : ''}} >{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="set-addmore pd2">
                                            <a class="btn btn-kinderway add_more_button" id="addmorebtn" href="#"><span>Add Other Languages</span></a>
                                        </div>

                                        <div class="language_fields" id="all_languagefields">
                                        </div>

                                        <div class="cp-field col-md-12 col-lg-4" style="">
                                            <h5>Birth Date (Day)</h5>
                                            <select name="dobday" id="dobday" class="form-control"
                                            style="-webkit-appearance: menulist-button;"
                                            required></select>
                                        </div>
                                        <div class="cp-field col-md-12 col-lg-4" style="">
                                            <h5>Birth Date (Month)</h5>
                                            <select name="dobmonth" id="dobmonth" class="form-control"
                                            style="-webkit-appearance: menulist-button;"
                                            required></select>
                                        </div>
                                        <div class="cp-field col-md-12 col-lg-4" style="">
                                            <h5>Birth Date (Year)</h5>
                                            <select name="dobyear" id="dobyear" class="form-control"
                                            style="-webkit-appearance: menulist-button;"
                                            required></select>
                                        </div>

                                        {{-- <div class="cp-field">
                                            <h5>Birth Date</h5>
                                            <div class="cpp-fiel">
                                                <div id="calendar" name="birth_date" value="{{Auth::user()->birth_date}}" placeholder="Select Date of Birth"></div>
                                                <div class="row">
                                                    <div class="col-md-4 pl-0 pb-3 pr-4 no-pad-right-mob">
                                                        <select name="dobday" id="dobday" class="form-control js-example-basic-single-general"
                                                                style="-webkit-appearance: menulist-button;"
                                                                required></select>
                                                    </div>
                                                    <div class="col-md-4 pl-0 pb-3 no-pad-right-mob">
                                                        <select name="dobmonth" id="dobmonth" class="form-control js-example-basic-single-general"
                                                                style="-webkit-appearance: menulist-button;"
                                                                required></select>
                                                    </div>
                                                    <div class="col-md-4 pl-0 pb-3 no-pad-right-mob">
                                                        <select name="dobyear" id="dobyear" class="form-control js-example-basic-single-general"
                                                                style="-webkit-appearance: menulist-button;"></select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div> --}}
                                        {{-- <div class="cp-field"> --}}
                                        <div class="cp-field col-md-12 col-lg-6" style="">
                                            <h5>Country Code</h5>
                                            <select class="js-example-basic-single-3 select2-validation" name="phone_code"
                                                    placeholder="required languages" style="width: 100%">
                                                <option value="">Select Country Code</option>
                                                @foreach($countries AS $key => $value)
                                                    <option value="{{$value->phone_code}}" {{(Auth::user()->phone_code == $value->phone_code)? 'selected' : ''}}>{{$value->phone_code}}
                                                        ({{$value->name}})
                                                    </option>
                                                @endforeach
                                            </select>
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

                                        <div class="cp-field">
                                            <h5>Your Location</h5>
                                            <div class="cpp-fiel error-ele">
                                                <select class="form-control js-example-basic-single-general select2-validation" name="job_position" id="job_position"
                                                        required style="-webkit-appearance: menulist-button;">
                                                    <option value="">Select Position based in</option>
                                                    <option value="UK" {{(Auth::user()->country == 'United Kingdom')? 'selected' : ''}} >
                                                        UK
                                                    </option>
                                                    {{-- 
                                                    <option value="Outside UK" {{(Auth::user()->country != 'United Kingdom')? 'selected' : ''}}>
                                                        Outside UK (International)
                                                    </option>
                                                     --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cp-fiel">
                                            <div class="cp-field col-md-12 col-lg-6" id="country_id_uk" style="">
                                                {{-- <div class="cpp-fiel" style="width: 50%; padding-right: 20px;"> --}}
                                                <h5>Country</h5>
                                                <select name="country" id="country" class="form-control js-example-basic-single-country select2-validation"
                                                        style="-webkit-appearance: menulist-button;" required>
                                                    <option value="">Select Country Name</option>
                                                    @foreach($countries AS $key => $value)
                                                        <option value="{{$value->name}}" {{(Auth::user()->country == $value->name)? 'selected' : ''}}>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="cp-field col-md-12 col-lg-6" id="city_id" style="">
                                                <h5>City</h5>
                                                <span class="citycls">
                                            <input type="text" class="form-control" name="city" id="city" value="{{Auth::user()->city}}"
                                                   placeholder="Enter City" required>
                                            </span>

                                                <span class="ukcitycls">
                                                <select name="ukcity" id="ukcity" class="form-control js-example-basic-single-city select2-validation"
                                                        style="-webkit-appearance: menulist-button; width: 100%;"
                                                        required>
                                                <option value="">Select City</option>
                                                @foreach($londoncity AS $key => $value)
                                                        <option value="{{$value}}" {{(Auth::user()->city == $value)? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                             </span>
                                            </div>
                                        </div>

                                        <div class="cp-field postalcls" style="width: 100%; padding-right: 20px;">
                                            <h5>Postal Code</h5>
                                            <div class="cpp-fiel">
                                                <select name="postal_code" id="postal_code"
                                                        class="js-example-basic-single-4 select2-validation"
                                                        style="width: 100%;" required>
                                                    <option value="">Select Postal Code</option>
                                                    @foreach($londonpostal AS $key => $value)
                                                        <option value="{{$value}}" {{(Auth::user()->postal_code == $value)? 'selected' : ''}}>{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="cp-field col-md-12 col-lg-12" style="">
                                            <h5>Area</h5>
                                            <div class="cpp-fiel">
                                                <input type="text" class="form-control" name="landmark" value="{{Auth::user()->landmark}}"
                                                       placeholder="e.g. Notting Hill/Manhattan" required>
                                                <i class="fas fa-landmark"></i>
                                            </div>
                                        </div>
                                        {{-- <div class="cp-field col-md-12 col-lg-6" style="">
                                            <h5>Address (Optional)</h5>
                                            <div class="cpp-fiel">
                                                <input type="text" name="address" value="{{Auth::user()->address}}"
                                                       placeholder="Enter Address">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </div>
                                        </div> --}}
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

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script src="/website/js/jsuites.js"></script> --}}
    <script src="/website/js/dobpicker.js"></script>






            <script>

            // if (!localStorage.getItem('completedIntro')) {
            var showIntroJS = {{ $showIntroJS ? 'true' : 'false' }};
            var hasWorkProfile = @json(Helper::hasWorkProfile());
if(showIntroJS) {


    $.ajax({
        url: '/user/check-new',
        type: 'GET',
        success: function (response) {
            if (response.is_new === 1) {
                var intro = introJs().setOptions({
                    steps: [{
                        title: null,
                        element: document.querySelector('.card__image'),
                        intro: '<div class="intro-container"><div class="image"></div><h2 >Personal Profile Completed!</h2> </br> <p s>You’re almost there! Its time to create your work profile. Start now! </p> </br> <a id="continue-button" href="/provider/service-profiles"  style="border: 0;padding: 17px 20px;border-radius: 7px;text-align: center;display: block;background-color: #253159; margin: auto;margin-top: 39px;color: white; width: fit-content;" >Continue</a></div>'
                    },

                    ]
                });

                intro.start();

                localStorage.setItem('completedIntro', 'true');

            }
        },
        error: function (error) {
            console.log(error);
        }
    });

}

            </script>


    <script>

        $(document).ready(function () {

            $('[data-toggle="tooltip"]').tooltip();

            //-----------Country-City------------
            var profileval = {!! auth()->user()->toJson() !!};

            if ((profileval != '') && (profileval['country'] == 'United Kingdom')) {
                $('.ukcitycls').show();
                $('.citycls').hide();
            } else {
                $('.ukcitycls').hide();
                $('.citycls').show();
            }

            if ((profileval != '') && (profileval['city'] == 'London')) {
                $('.postalcls').show();
            } else {
                $('.postalcls').hide();
            }
            //--------------

            $.dobPicker({
                daySelector: '#dobday', /* Required */
                monthSelector: '#dobmonth', /* Required */
                yearSelector: '#dobyear', /* Required */
                dayDefault: 'Select Day', /* Optional */
                monthDefault: 'Select Month', /* Optional */
                yearDefault: 'Select Year', /* Optional */
            });

            $("#dobday").change(function () {
                $('#dobmonth').prop('selectedIndex', 0);
                $('#dobyear').prop('selectedIndex', 0);
            });

            $("#dobmonth").change(function () {
                $('#dobyear').prop('selectedIndex', 0);
            });

            var user_bdt = {!! auth()->user()->toJson() !!};

            if (user_bdt != '' && user_bdt['birth_date'] != null && user_bdt['birth_date'] != "") {

                //if(user_bdt['birth_date'] != null){
                var fulldate = user_bdt['birth_date'];
                var arrdt = fulldate.split('-');
                var bdt = arrdt[2];
                var bmon = arrdt[1];
                var byear = arrdt[0];
                $("#dobday option[value=" + bdt + "]").prop('selected', true).attr('selected', 'selected');
                $("#dobmonth option[value=" + bmon + "]").prop('selected', true).attr('selected', 'selected');
                $("#dobyear option[value=" + byear + "]").prop('selected', true).attr('selected', 'selected');
            }

            $('.js-example-basic-single-general').select2({
                minimumResultsForSearch: -1
            });

            $('.js-example-basic-single').select2({
                placeholder: "Select Nationality"
            });

            $('.js-example-basic-single-2').select2({
                placeholder: "Select Native Language"
            });

            $('.js-example-basic-single-3').select2({
                placeholder: "Select Phone Number"
            });

            $('.js-example-basic-single-4').select2({
                placeholder: "Select Postal Code"
            });

            $('.js-example-basic-single-country').select2({
                placeholder: "Select Country"
            });

            $('.js-example-basic-single-city').select2({
                placeholder: "Select City"
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "Select Other Languages"
            });

            var nativeselect = $('#native_language').val();
            if (nativeselect == '') {
                $('.add_more_button').hide();
            } else {
                $('.add_more_button').show();
            }

            $(function () {
                var prevSelect = '';
                var thisSelect = $('#native_language').val();
                $('#native_language').change(function () {
                    prevSelect = thisSelect;
                    thisSelect = $(this).val();
                    //alert(thisSelect);

                    $('.add_more_button').show();
                    $(".otherlanguage option[value='" + prevSelect + "']").attr('disabled', false).removeClass('disablemask');
                    $(".otherlanguage option[value='" + thisSelect + "']").attr('disabled', true).addClass('disablemask');
                    // alert(prevSelect + ' - ' + thisSelect);
                });
            });

            $(document).on("focus", '.otherlanguage', function () {
                previous = this.value; // Old vaue
            }).on('change', '.otherlanguage', function () {
                dropdownval = $(this).val();

                if (previous != '') {
                    $(".otherlanguage").find("option[value='" + previous + "']").attr('disabled', false).removeClass('disablemask');
                    $("#native_language option[value='" + previous + "']").attr('disabled', false);
                }

                $(".otherlanguage").not(this).find("option[value='" + dropdownval + "']").attr('disabled', true).addClass('disablemask');
                $("#native_language option[value='" + dropdownval + "']").attr('disabled', true).addClass('disablemask');
            });

            var restfield = ''
            var lang_nm_db = $('#lang_nm').val();
            var fields_limit = $('#fields_limit').val();

            var temp_db = new Array();
            var temp_db = lang_nm_db.split(',');

            if (lang_nm_db != 0) {
                var loadedfield = temp_db.length;
                var total_languages = "<?php echo $language_count; ?>";
                restfield = total_languages - loadedfield;
            }

            var max_fields_limit = "<?php echo $language_count; ?>"; //set limit for maximum input fields
            if (restfield != '') {
                max_fields_limit = restfield;
            }
            //alert(max_fields_limit+"limit");

            var x = 1; //initialize counter for text box

            $('#addmorebtn').click(function (e) {
                e.preventDefault();

                var langtype = $('#native_language').val();
                var val1 = [];

                if (langtype != '') {
                    val1.push(langtype);
                }

                if (($(".language_fields").length)) {
                    $('select[name="other_language[]"] option:selected').each(function () {
                        val1.push($(this).val());
                    });
                }

                //Get remaining options of language:
                var finalarr = [];
                var outputText = '';
                var temp_arr = '<?php echo json_encode($pass_languages) ?>';
                var arr = JSON.parse(temp_arr);
                console.log(arr.length);
                for (var i = 0; i < arr.length; i++) {
                    var idx = $.inArray(arr[i], val1);

                    if ($.inArray(arr[i], val1) < 0) {
                        // finalarr.push(arr[i]);
                        var divHtml = '<option value="' + arr[i] + '">' + arr[i] + '</option>';
                    } else {
                        var divHtml = '<option class="disablemask" value="' + arr[i] + '" disabled>' + arr[i] + '</option>';
                    }
                    outputText += divHtml;
                }

                if (x < max_fields_limit) {
                    x++; //counter increment
                    $('.language_fields').append('<div id="fulldiv"> <div class="cp-field col-md-12 col-lg-4" style=""> <h5>Other Language</h5> <select name="other_language[]" class="form-control js-example-basic-single-general otherlanguage" style="-webkit-appearance: menulist-button;" required> <option value="">Select Language</option> ' + outputText + ' </select> </div><div class="cp-field col-md-12 col-lg-4" style=""> <h5>Level</h5> <select class="form-control js-example-basic-single-general alllevels" id="langlevel" name="langlevel[]" style="-webkit-appearance: menulist-button;"> <option value="">Select Level</option> <option value="beginner">beginner</option> <option value="intermediate">intermediate</option> <option value="advanced">advanced</option> </select> </div><div class="cp-field col-md-12 col-lg-4 no-pad-top-mob"> <a href="javascript:void(0)" class="btn btn-danger remove_field" style="background-color: #fb9300; border-color: #fb9300;">Remove</a></div>');
                }
            });

            //************Country-city********/
            $("#country").change(function () {
                var countryval = $('option:selected', this).text();

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
            /*-------------------*/

            $(document).on('click', 'a.remove_field', function () {
                var currselectedval = $(this).closest('#fulldiv').find(".otherlanguage :selected").val();

                if (currselectedval != '') {
                    //$('.otherlanguage').find('option[value="' + currselectedval + '"]').attr('disabled', false).removeClass('disablemask')
                    $(".otherlanguage").find("option[value='" + currselectedval + "']").attr('disabled', false).removeClass('disablemask')
                    $("#native_language option[value='" + currselectedval + "']").attr('disabled', false);
                }

                $(this).closest('#fulldiv').remove();
                x--;
            });


            $(document).on('click', 'a.remove_field', function () {
                //Call ajax and remove from db:
                x--;
                var deleteid = $(this).attr("data-ids");
                if (deleteid) {
                    $(this).parent().prev().prev('div').remove();
                    $(this).parent().prev('div').remove();
                    $(this).parent('div').remove();
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('/provider/deletelanguage') }}",
                    type: "POST",
                    data: {
                        deleteid: deleteid,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {

                        if (response.success == '1') {
                            var pushlang = response.pushlanguage;
                            var remainingTot = response.remainingTot;

                            if (pushlang != '') {
                                $(".otherlanguage").find("option[value='" + pushlang + "']").attr('disabled', false).removeClass('disablemask')
                                $("#native_language option[value='" + pushlang + "']").attr('disabled', false);
                            }
                        }else {
                            alert('something went wrong, contact support');
                        }
                    },
                    error: function (jqXHR, testStatus, error) {
                        console.log(error);
                        alert('something went wrong, contact support');
                    }
                });
            });

            function setlanguageonload() {
                var val1 = [];

                var langtype = $('#native_language').val();

                if (langtype != '') {
                    val1.push(langtype);
                }

                var lang_nm_db = $('#lang_nm').val();

                if (lang_nm_db != '') {
                    var temp_db = new Array();
                    var temp_db = lang_nm_db.split(',');

                    if (lang_nm_db != 0) {
                        for (var i = 0; i < temp_db.length; i++) {
                            val1.push(temp_db[i]);
                            $("#native_language option[value='" + temp_db[i] + "']").attr('disabled', true).addClass('disablemask');
                        }
                    }

                    var val_level = [];
                    var lang_level_db = $('#lang_level').val();
                    var temp_db_level = new Array();
                    var temp_db_level = lang_level_db.split(',');

                    if (lang_level_db != 0) {
                        for (var i = 0; i < temp_db_level.length; i++) {
                            val_level.push(temp_db_level[i]);
                        }
                    }

                    var val_ids = [];
                    var lang_ids_db = $('#lang_ids').val();
                    var temp_db_ids = new Array();
                    var temp_db_ids = lang_ids_db.split(',');

                    if (lang_ids_db != 0) {
                        for (var i = 0; i < temp_db_ids.length; i++) {
                            val_ids.push(temp_db_ids[i]);
                        }
                    }

                    var outputText_db = '';
                    var temp_arr = '<?php echo json_encode($pass_languages) ?>';
                    var arr = JSON.parse(temp_arr);
                    if (lang_nm_db != 0) {
                        for (var i = 0; i < temp_db.length; i++) {
                            var setbeginner = setinter = setexpert = '';
                            if (temp_db_level[i] == 'beginner') {
                                setbeginner = 'selected="true"';
                            } else if (temp_db_level[i] == 'intermediate') {
                                setinter = 'selected="true"';
                            } else if (temp_db_level[i] == 'advanced') {
                                setexpert = 'selected="true"';
                            }

                            outputText_db = '';
                            for (var lan = 0; lan < arr.length; lan++) {
                                var idx = $.inArray(arr[lan], val1);

                                if ($.inArray(arr[lan], val1) < 0) {
                                    var divHtml_db = '<option value="' + arr[lan] + '">' + arr[lan] + '</option>';
                                } else {

                                    if (temp_db[i] == arr[lan]) {
                                        var divHtml_db = '<option value="' + arr[lan] + '" selected>' + arr[lan] + '</option>';
                                    } else {
                                        var divHtml_db = '<option class="disablemask" value="' + arr[lan] + '" disabled>' + arr[lan] + '</option>';
                                    }
                                }
                                outputText_db += divHtml_db;
                            }
                            $('.language_fields').append('<div id="fulldiv"><div class="cp-field col-md-12 col-lg-4"><h5>Other Language</h5><select name="other_language[]" class="form-control js-example-basic-single-general otherlanguage" style="-webkit-appearance: menulist-button;" required><option value="">Select Language</option>' + outputText_db + '</select></div><div class="cp-field col-md-12 col-lg-4"><h5>Level</h5><select class="form-control js-example-basic-single-general alllevels" id="langlevel" name="langlevel[]" style="-webkit-appearance: menulist-button;"><option value="">Select Level</option><option value="beginner" ' + setbeginner + '>beginner</option><option value="intermediate" ' + setinter + '>intermediate</option><option value="advanced" ' + setexpert + '>advanced</option></select></div><div class="cp-field col-md-12 col-lg-4 no-pad-top-mob"><a data-ids="' + temp_db_ids[i] + '" href="javascript:void(0)" class="btn btn-danger remove_field" style="background-color: #fb9300; border-color: #fb9300;">Remove</a></div></div>');
                        }
                    }
                }
            }

            setlanguageonload();

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
                        nationality: {
                            required: true
                        },
                        native_language: {
                            required: true
                        },
                        dobday: {
                            required: true
                        },
                        dobmonth: {
                            required: true
                        },
                        dobyear: {
                            required: true
                        },
                        /* birth_date: {
                             required: true
                         },*/
                        phone_code: {
                            required: true
                        },
                        phone: {
                            required: true,
                            maxlength: 15
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
                        'nationality': {
                            required: "Nationality field is required"
                        },
                        'native_language': {
                            required: "Native Language field is required"
                        },
                        'dobday': {
                            required: "Please select birth day"
                        },
                        'dobmonth': {
                            required: "Please select birth month"
                        },
                        'dobyear': {
                            required: "Please select birth year"
                        },
                        /*  'birth_date': {
                              required: "Date Of Birth field is required"
                          },*/
                        'phone_code': {
                            required: "Country Code field is required"
                        },
                        'phone': {
                            required: "Phone Number field is required",
                            maxlength: "Phone Number max length is 15 characters"
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

        function get_details_from_postal_code() {
            var postal_code = $('#postal_code').val();
            if (postal_code) {
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + postal_code + "&key={{ config('services.google_maps.key') }}",
                    data: {postal_code: postal_code, _token: '{{csrf_token()}}'},
                    success: function (response) {
                        if (response.status == 'OK') {
                            var addresses = response.results[0].address_components;
                            var country = response.results[0].address_components[addresses.length - 1].long_name;
                            var city = response.results[0].address_components[2].long_name;
                            $('form[id="update_user_profile_frm"] select[name="country"]').val(country);
                            $('form[id="update_user_profile_frm"] input[name="city"]').val(city);
                        }
                    },
                    error: function (jqXHR, testStatus, error) {
                        console.log(error);
                        alert('something went wrong, contact support');
                    }
                });
            }
        }

        $(function () {
            $("#datepicker").datepicker();
        });

        $("#job_position").change(function () {
            var job_position = $(this).val();
            setCountry(job_position);
        });

        function setCountry(job_position, country = '') {

            if (job_position != '') {
                if (job_position == 'UK') {
                    $("#country").val('United Kingdom');
                    $("#country option[value!='United Kingdom']").attr('disabled', 'disabled');
                    $("#country option[value='United Kingdom']").removeAttr("disabled").attr('selected', 'selected');
                } else {
                    $("#country").val(country);
                    $("#country option[value!='United Kingdom']").removeAttr("disabled");
                    $("#country option[value='United Kingdom']").attr('disabled', 'disabled').removeAttr("selected");
                }
            } else {
                $("#country").val('');
                $("#country option[value='United Kingdom']").removeAttr("disabled").removeAttr("selected");
                $("#country option[value!='United Kingdom']").removeAttr("disabled").removeAttr("selected");
            }
            $("#country").trigger('change');

        }

        setCountry('{{ (Auth::user()->country == 'United Kingdom')? 'UK' : 'Outside UK' }}', '{{ Auth::user()->country}}');
    </script>
@endsection
