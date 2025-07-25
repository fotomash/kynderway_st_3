@extends('layouts.master_user')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')

    <section class="profile-account-setting">
        <div class="container">
            <div class="account-tabs-setting">
                @include('shared.response_msg')
                <div class="row mb-4">
                </div>
                <div class="row">
                    @include('shared.sidebar', ['active' => 'service-profiles'])
                    <div class="col-lg-9 pad-right-mob">
                        <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Your Profiles</h3>
                        <hr class="bold" />
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="nav-password" role="tabpanel"
                                 aria-labelledby="nav-password-tab">
                                <div class="acc-setting">
                                    {{-- <div class="cp-field">
                                        <small>Showcase your services to potential clients</small>
                                        <div class="form-row four-cols mt-4">
                                            @include('shared.categories', ['arrows' => false, 'active' => 'Pet Carer', 'tag' => 'a', 'class1' => '', 'class2' => '', 'class3' => 'btn-kinderway-cat'])
                                        </div>
                                    </div> --}}

                                    <form action="{{ url('/provider/service-profiles/addallprofiles') }}" method="POST"
                                          id="frmpercarer" class="">
                                        @csrf
                                        <input type="hidden" name="hid_profileval" value="4">
                                        <div class="cp-field">
                                            <h5>Job Duration</h5>
                                            <div class="cpp-fiel error-ele">
                                                <ul class="job-tags">
                                                    <li class="limargin">
                                                        <input type="checkbox" class="setchkbox chkbxsector"
                                                               name="duration[]" id="duration1" autocomplete="off"
                                                               value="Permanent"
                                                        @if(isset($currprofile
                                                         ['job_duration']) && (
                                                            in_array('Permanent', $currprofile['job_duration'])))
                                                            {{ 'checked' }}
                                                                @endif
                                                        >
                                                        <a class="shadow
                                            @if(isset($currprofile['job_duration']) && (
                                            in_array('Permanent', $currprofile['job_duration']))) active
                                            @endif
                                                                ">
                                                            <label class="" for="duration1">
                                                                Permanent</label></a>
                                                    </li>

                                                    <li class="limargin">
                                                        <input type="checkbox" class="setchkbox chkbxsector"
                                                               name="duration[]" id="duration2" autocomplete="off"
                                                               value="Temporary"
                                                        @if(isset($currprofile
                                                         ['job_duration']) && (
                                                            in_array('Temporary', $currprofile['job_duration'])))
                                                            {{ 'checked' }}
                                                                @endif
                                                        >
                                                        <a class="shadow
                                             @if(isset($currprofile['job_duration']) && (
                                            in_array('Temporary', $currprofile['job_duration']))) active
                                            @endif
                                                                ">
                                                            <label class="" for="duration2">
                                                                Temporary</label></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="cp-field form-row">
                                            <div class="col-lg-4 col-xs-12 pb-4">
                                                <h5>Currency</h5>
                                                <div class="cpp-fiel error-ele">
                                                    <select class="form-control js-example-basic-single-general" name="currency" id="currency"
                                                            style="-webkit-appearance: menulist-button;">
                                                        <option value="">Select Currency</option>
                                                        <option value="GBP"
                                                                {{ (isset($currprofile['curr_profile']['currency'])&& $currprofile['curr_profile']['currency']=='GBP') ? 'selected'
                                                                : ''}}>GBP
                                                        </option>
                                                        <option value="EUR" {{ (isset($currprofile['curr_profile']['currency'])&& $currprofile['curr_profile']['currency']=='EUR') ? 'selected'
                                                    : ''}}>EUR
                                                        </option>
                                                        <option value="USD" {{ (isset($currprofile['curr_profile']['currency'])&& $currprofile['curr_profile']['currency']=='USD') ? 'selected'
                                                    : ''}}>USD
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xs-12 pb-4">
                                                <h5>Pay from</h5>
                                                <div class="cpp-fiel error-ele">
                                                    <input type="text" name="payamount" id="payamount"
                                                           class="form-control allownumericwithdecimal" required
                                                           placeholder="0.00" value="{{
                                                isset( $currprofile['curr_profile']['payamount']) ?  $currprofile['curr_profile']['payamount'] : ''
                                                }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-xs-12 pb-4">
                                                <h5>Pay Frequency</h5>
                                                <div class="cpp-fiel error-ele">
                                                    <select class="form-control js-example-basic-single-general" name="frequency" id="frequency"
                                                            style="-webkit-appearance: menulist-button;">
                                                        <option value="">Select Frequency</option>
                                                        <option value="Per Hour" {{ (isset($currprofile['curr_profile']['payfrequency'])&& $currprofile['curr_profile']['payfrequency']==
                                                    'Per Hour') ? 'selected'
                                                    : ''}}>Per Hour
                                                        </option>

                                                        <option value="Per Day" {{ (isset($currprofile['curr_profile']['payfrequency'])&& $currprofile['curr_profile']['payfrequency']==
                                                    'Per Day') ? 'selected'
                                                    : ''}}>Per Day
                                                        </option>

                                                        <option value="Per Night"
                                                                {{ (isset($currprofile['curr_profile']['payfrequency'])&& $currprofile['curr_profile']['payfrequency']==
                                                                'Per Night') ?
                                                                'selected' : ''}}
                                                        >Per Night
                                                        </option>
                                                        <option value="Per Week"
                                                                {{ (isset($currprofile['curr_profile']['payfrequency'])&& $currprofile['curr_profile']['payfrequency']==
                                                                'Per Week') ?
                                                                'selected' : ''}}>Per Week
                                                        </option>
                                                        <option value="Per Month"
                                                                {{ (isset($currprofile['curr_profile']['payfrequency'])&& $currprofile['curr_profile']['payfrequency']==
                                                                'Per Month') ?
                                                                'selected' : ''}}>Per Month
                                                        </option>
                                                        <option value="Per Year"
                                                                {{ (isset($currprofile['curr_profile']['payfrequency'])&& $currprofile['curr_profile']['payfrequency']==
                                                                'Per Year') ?
                                                                'selected' : ''}}>Per Year
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cp-field">
                                            <h5 class="mb-0">Job Types</h5>
                                            {{-- <p class="">Please select your preferred positions</p> --}}
                                            <div class="cpp-fiel mt-3 error-ele">
                                                <ul class="job-tags">
                                                    @foreach($jtypes AS $key => $value)
                                                        <li class="limargin">
                                                            <input type="checkbox" class="setchkbox jchkbox
                                                             " name="options_jobtype[]" id="checkbox{{$loop->iteration}}_jtype" autocomplete="off"
                                                                   value="{{$value->id}}"
                                                            @if(isset($currprofile
                                                            ['job_type']) && (
                                                               in_array($value->id, $currprofile['job_type'])))
                                                                {{ 'checked' }}
                                                                    @endif >
                                                            <a class="shadow
                                                            @if(isset($currprofile['job_type']) && (
                                                            in_array($value->id, $currprofile['job_type']))) active
                                                            @endif ">
                                                            <label class="" for="checkbox{{$loop->iteration}}_jtype">
                                                                    {{ $value->jobtype }}</label></a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cp-field">
                                            <h5 class="mb-0">I Work With</h5>
                                            {{-- <p class="">Tick what you're comfortable with</p> --}}
                                            <div class="cpp-fiel mt-3 error-ele">
                                                <ul class="job-tags">
                                                    @foreach($specialities AS $key => $value)
                                                        <li class="limargin">
                                                            <input type="checkbox" class="setchkbox workchkbox"
                                                                   name="options_outlined[]"
                                                                   id="checkbox{{$loop->iteration}}-outlined" autocomplete="off"
                                                                   value="{{$value->id}}"
                                                            @if(isset($currprofile['work_with']) && (
                                                               in_array($value->id, $currprofile['work_with'])))
                                                                {{ 'checked' }}
                                                                    @endif >
                                                            <a class="shadow
                                                            @if(isset($currprofile['work_with']) && (
                                                            in_array($value->id, $currprofile['work_with']))) active
                                                            @endif ">
                                                            <label class="" for="checkbox{{$loop->iteration}}-outlined">
                                                                    {{ $value->name }}</label></a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="cp-field">
                                            <h5 class="mb-0">Additional Questions</h5>
                                            <div class="cpp-fiel mt-3">
                                                <div class="form-check">
                                                    <div class="row">
                                                        <div class="col-lg-12 pl-0 pr-0">
                                                            <div class="checkbox mb-4 error-ele">
                                                                <p>Are you comfortable with pets?</p>
                                                                <div class="form-check form-check-inline">
                                                                    <div class="custom-control custom-radio pr-3">
                                                                        <input type="radio" id="customRadio1"
                                                                               name="carRadio"
                                                                               class="custom-control-input" value="1"
                                                                                {{ (isset($currprofile['curr_profile']['carvalue'])&& $currprofile['curr_profile']['carvalue']==
                                                                                                        '1') ?
                                                                                                        'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio1">Yes</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio2"
                                                                               name="carRadio"
                                                                               class="custom-control-input" value="0" {{ (isset($currprofile['curr_profile']['carvalue'])&& $currprofile['curr_profile']['carvalue']=='0') ?
                                                'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio2">No</label>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="checkbox mb-4 error-ele">
                                                                <p>Do you have a driving license?</p>
                                                                <div class="form-check form-check-inline">
                                                                    <div class="custom-control custom-radio pr-3">
                                                                        <input type="radio" id="customRadio3"
                                                                               name="licenseRadio"
                                                                               class="custom-control-input"
                                                                               value="1" {{ (isset($currprofile['curr_profile']['licensevalue'])&& $currprofile['curr_profile']['licensevalue']=='1') ? 'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio3">Yes</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio4"
                                                                               name="licenseRadio"
                                                                               class="custom-control-input" value="0" {{ (isset($currprofile['curr_profile']['licensevalue'])&& $currprofile['curr_profile']['licensevalue']=='0') ?
                                                'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio4">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox mb-4 error-ele">
                                                                <p>Do you have a certified qualifications for this category?</p>
                                                                <div class="form-check form-check-inline">
                                                                    <div class="custom-control custom-radio pr-3">
                                                                        <input type="radio" id="customRadio5"
                                                                               name="qualiRadio"
                                                                               class="custom-control-input" value="1" {{ (isset($currprofile['curr_profile']['qualificationsvalue'])&& $currprofile['curr_profile']['qualificationsvalue']==
                                '1') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio5">Yes</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio6"
                                                                               name="qualiRadio"
                                                                               class="custom-control-input" value="0" {{ (isset($currprofile['curr_profile']['qualificationsvalue'])&& $currprofile['curr_profile']['qualificationsvalue']==
                                '0') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio6">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox mb-4 error-ele">
                                                                <p>Do you have a criminal record check?</p>
                                                                <div class="form-check form-check-inline">
                                                                    <div class="custom-control custom-radio pr-3">
                                                                        <input type="radio" id="customRadio7"
                                                                               name="recordRadio"
                                                                               class="custom-control-input" value="1" {{ (isset($currprofile['curr_profile']['recordvalue'])&& $currprofile['curr_profile']['recordvalue']==
                                '1') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio7">Yes</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio8"
                                                                               name="recordRadio"
                                                                               class="custom-control-input" value="0"
                                                                                {{ (isset($currprofile['curr_profile']['recordvalue'])&& $currprofile['curr_profile']['recordvalue']==
                                                                                            '0') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio8">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox mb-4">
                                                                <p>Do you have a First Aid certificate?</p>
                                                                <div class="form-check form-check-inline error-ele">
                                                                    <div class="custom-control custom-radio pr-3">
                                                                        <input type="radio" id="customRadio9"
                                                                               name="aidRadio"
                                                                               class="custom-control-input" value="1" {{ (isset($currprofile['curr_profile']['aidvalue'])&& $currprofile['curr_profile']['aidvalue']==
                                '1') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio9">Yes</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio10"
                                                                               name="aidRadio"
                                                                               class="custom-control-input" value="0" {{ (isset($currprofile['curr_profile']['aidvalue'])&& $currprofile['curr_profile']['aidvalue']==
                                '0') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio10">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="checkbox">
                                                                <p>Do you have references?</p>
                                                                <div class="form-check form-check-inline error-ele">
                                                                    <div class="custom-control custom-radio pr-3">
                                                                        <input type="radio" id="customRadio11"
                                                                               name="refRadio"
                                                                               class="custom-control-input" value="1" {{ (isset($currprofile['curr_profile']['refvalue'])&& $currprofile['curr_profile']['refvalue']==
                                '1') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio11">Yes</label>
                                                                    </div>
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="customRadio12"
                                                                               name="refRadio"
                                                                               class="custom-control-input" value="0" {{ (isset($currprofile['curr_profile']['refvalue'])&& $currprofile['curr_profile']['refvalue']==
                                '0') ?  'checked' : ''}}>
                                                                        <label class="custom-control-label"
                                                                               for="customRadio12">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cp-field">
                                            <h5>Years of Experience</h5>
                                            <div class="cpp-fiel error-ele">
                                                <select class="form-control js-example-basic-single-general" name="experience2" id="experience2"
                                                        style="-webkit-appearance: menulist-button;">
                                                    <option value="">Select Experience</option>

                                                    <option value="0 - 1 Year"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '0 - 1 Year') ?
                                                        'selected' : ''}}>0 - 1 Year
                                                    </option>

                                                    <option value="1-2 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '1-2 Years') ?
                                                        'selected' : ''}}>1-2 Years
                                                    </option>

                                                    <option value="2-3 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '2-3 Years') ?
                                                        'selected' : ''}}>2-3 Years
                                                    </option>

                                                    <option value="3-5 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '3-5 Years') ?
                                                        'selected' : ''}}>3-5 Years
                                                    </option>

                                                    <option value="5-10 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '5-10 Years') ?
                                                        'selected' : ''}}>5-10 Years
                                                    </option>

                                                    <option value="10-20 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '10-20 Years') ?
                                                        'selected' : ''}}>10-20 Years
                                                    </option>

                                                    <option value="20-30 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '20-30 Years') ?
                                                        'selected' : ''}}>20-30 Years
                                                    </option>

                                                    <option value="30-40 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '30-40 Years') ?
                                                        'selected' : ''}}>30-40 Years
                                                    </option>

                                                    {{-- <option value="40-50 Years"
                                                            {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                        '40-50 Years') ?
                                                        'selected' : ''}}>40-50 Years
                                                    </option> --}}

                                                    <option value="40+ Years" {{ (isset($currprofile['curr_profile']['experience2'])&& $currprofile['curr_profile']['experience2']==
                                                '40+ Years') ?
                                                'selected' : ''}}>40+ Years
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cp-field">
                                            <h5>Education and Work Experience</h5>
                                            {{-- <p class="">Tell us more about yourself and your skills</p> --}}
                                            <div class="cpp-fiel error-ele">
                                            <textarea row="5" name="edu_details" placeholder="Tell us more about yourself and your skills" id="edu_details" style="white-space: pre-wrap;">{{
                                            isset( $currprofile['curr_profile']['edu_description']) ?  $currprofile['curr_profile']['edu_description'] : ''
                                            }}</textarea>
                                                <i class="fa fa-pencil"></i>
                                            </div>
                                        </div>
                                        <div class="save-stngs pd2">
                                            <button type="submit" class="btn btn-kinderway" style="float: right;"> Save Profile
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

            $('.js-example-basic-single-general').select2({
                minimumResultsForSearch: -1
            });

            if ($("#frmpercarer").length) {
                $("#frmpercarer").validate({
                    errorPlacement: function ($error, $element) {
                        $error.appendTo($element.closest("div.error-ele"));
                    },
                    rules: {
                        "duration[]": {
                            required: true,
                            minlength: 1
                        },
                        currency: {
                            required: true
                        },
                        payamount: {
                            required: true
                        },
                        frequency: {
                            required: true
                        },
                        experience2: {
                            required: true
                        },
                        edu_details: {
                            required: true
                        },
                        "options_outlined[]": {
                            required: true,
                            minlength: 1
                        },
                        /* "options_exp[]" : {
                             required: true,
                             minlength: 1
                         },  */
                        "options_jobtype[]": {
                            required: true,
                            minlength: 1
                        },
                        "options_sector[]": {
                            required: true,
                            minlength: 1
                        },
                        carRadio: {
                            required: true
                        },
                        licenseRadio: {
                            required: true
                        },
                        qualiRadio: {
                            required: true
                        },
                        recordRadio: {
                            required: true
                        },
                        aidRadio: {
                            required: true
                        },
                        refRadio: {
                            required: true
                        }

                    },
                    messages: {
                        'duration[]': {
                            required: "Please select at least one duration"
                        },
                        'currency': {
                            required: "Currency field is required"
                        },
                        'payamount': {
                            required: "Pay from field is required"
                        },
                        'frequency': {
                            required: "Pay frequency field is required"
                        },
                        'experience2': {
                            required: "Experience field is required"
                        },
                        'edu_details': {
                            required: "Education and Work Experience field is required"
                        },
                        'options_outlined[]': {
                            required: "Please select at least one work with"
                        },
                        /* 'options_exp[]': {
                             required: "Please select at least one experience"
                         },*/
                        'options_jobtype[]': {
                            required: "Please select at least one job type"
                        },
                        // 'options_sector[]': {
                        //     required: "Please select at least one work sector"
                        // },
                        'carRadio': {
                            required: "Select one option please"
                        },
                        'licenseRadio': {
                            required: "Select one option please"
                        },
                        'qualiRadio': {
                            required: "Select one option please"
                        },
                        'recordRadio': {
                            required: "Select one option please"
                        },
                        'aidRadio': {
                            required: "Select one option please"
                        },
                        'refRadio': {
                            required: "Select one option please"
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            }


            $('.workchkbox').click(function (e) {
                if ($(this).prop("checked") == true) {
                    //console.log("Checkbox is checked.");
                    // alert($(this).attr('id'));
                    $(this).next().addClass('active');
                } else if ($(this).prop("checked") == false) {
                    //console.log("Checkbox is unchecked.");
                    $(this).next().removeClass('active');
                }
            });

            $('.jchkbox').click(function (e) {
                if ($(this).prop("checked") == true) {
                    //console.log("Checkbox is checked.");
                    // alert($(this).attr('id'));
                    $(this).next().addClass('active');
                } else if ($(this).prop("checked") == false) {
                    //console.log("Checkbox is unchecked.");
                    $(this).next().removeClass('active');
                }
            });

            $('.expchkbox').click(function (e) {
                if ($(this).prop("checked") == true) {
                    //console.log("Checkbox is checked.");
                    // alert($(this).attr('id'));
                    $(this).next().addClass('active');
                } else if ($(this).prop("checked") == false) {
                    //console.log("Checkbox is unchecked.");
                    $(this).next().removeClass('active');
                }
            });

            $('.chkbxsector').click(function (e) {
                if ($(this).prop("checked") == true) {
                    $(this).next().addClass('active');
                } else if ($(this).prop("checked") == false) {
                    $(this).next().removeClass('active');
                }
            });

            $(".allownumericwithdecimal").on("keypress keyup blur", function (event) {

                if ($(this).val() == 0) {
                    $(this).val(null);
                }
                //this.value = this.value.replace(/[^0-9\.]/g,'');
                $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
