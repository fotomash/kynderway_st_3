@extends('layouts.master_user')

@section('css')
    <link rel="stylesheet" href="/website/form-wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="/website/form-wizard/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/website/css/jsuites.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/post-vacancy.css') }}">

    <style>
        .wizard>.steps {
            top: 130px;
        }

        @media (max-width: 767px) {
            .wizard>.steps {
                top: 180px;
            }

            .btn-kinderway-cat-2.active {
                width: 110px;
                height: 110px;
            }

            .btn-kinderway-cat-2 {
                width: 110px;
                height: 110px;
            }

            #payamountto-error {
                float: none !important;
            }
        }

        #payamountto-error {
            float: right;
        }

        textarea {
            white-space: pre-wrap;
        }
    </style>
@endsection

@section('post-vacancy')
    active
@endsection

@section('content')
    <section class="profile-account-setting">
        <div class="container">
            <div class="account-tabs-setting">
                <div class="row">
                    <div class="col-lg-12 pad-left-mob pad-right-mob">
                        <form action="" id="wizard" class="mt-4 pt-2" method="post">
                            @csrf
                            <input type="hidden" name="calendar1" id="calendar1" value="">
                            <input type="hidden" name="btnpressed" id="btnpressed" value="">
                            <input type="hidden" name="marketing" value="">

                            @include('user.client.partials.post-vacancy.form-section1')
                            @include('user.client.partials.post-vacancy.form-section2')
                            @include('user.client.partials.post-vacancy.form-section3')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('user.client.partials.post-vacancy.modal-edit')
    @include('user.client.partials.post-vacancy.modal-marketing')
    @include('user.client.partials.post-vacancy.modal-privacy')
@endsection

@section('js')
    <script src="/website/form-wizard/js/jquery.steps.js"></script>
    <script src="/website/form-wizard/js/main.js"></script>

    <script src="/website/js/jsuites.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script>
        var isEdit = window.location.pathname.match(/user\/client\/post-vacancy\/\d+/);
        $(document).ready(function() {
            $('.price-group').hide();
            $(document).on('change', 'input.money-selector[type="radio"]', function(e) {
                if ($(this).val() === 'fix') {
                    $('.price-group').show();
                    return;
                }
                $('.price-group').hide();
            });

            $('.--calendar').hide();
            $(document).on('change', 'input.date-selector[type="radio"]', function(e) {
                if ($(this).val() === 'calendar') {
                    var dateval = $('.jcalendar-selected').text();
                    var yearval = $('.jcalendar-year').text();
                    var month = $('.jcalendar-month').text();
                    var fulldate = month + ' ' + dateval + ',' + yearval;

                $('#input-calendar').val(fulldate);
                    $('.--calendar').show();
                    return;
                }
                $('.--calendar').hide();
            });


            //-------------city-country-----
            $('#country_id_uk').hide();
            $('#country_id').hide();
            $('#city_id').hide();
            $('.postalcls').hide();

            $('.js-example-basic-single-general').select2({
                minimumResultsForSearch: -1
            });

            $('.js-example-basic-single-postal').select2({
                placeholder: "Select Postal Code"
            });

            $('.js-example-basic-single-country').select2({
                placeholder: "Select Country"
            });

            $('.js-example-basic-single-city').select2({
                placeholder: "Select City"
            });

            $(document).on('change', '#country1', function(e) {

                var countryval = $('option:selected', this).text();
                if (countryval == 'United Kingdom') {
                    $('.citycls').hide();
                    $('.ukcitycls').show();
                    $("#ukcity").val($("#ukcity option[selected]").val());
                } else {
                    $("#ukcity").val($("#ukcity option[selected]").val());
                    $('.ukcitycls').hide();

                    $("#postal_code").val($("#postal_code option[selected]").val());
                    $('.postalcls').hide();

                    $('.citycls').show();
                    $('.citycls').val('');
                }
            });

            $("#job_position").change(function() {
                jobPositionChange();
            });

            function jobPositionChange() {
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
            }

            $(document).on('change', '.ukcitycls', function(e) {
                var ukcityval = $('option:selected', this).text();

                if (ukcityval == 'London') {
                    $('.postalcls').show();
                } else {
                    $("#postal_code").val($("#postal_code option[selected]").val());
                    $('.postalcls').hide();
                }
            });
            //---------------------------

            $("input[name='options']").change(function(e) {
                e.preventDefault();
                loadCategories();
            });

            $("#option2").trigger("change");

            $('[data-toggle="tooltip"]').tooltip();
            jSuites.calendar(document.getElementById('calendar'), {
                format: 'YYYY-MM-DD',
                onupdate: function(a, b) {
                    // document.getElementById('calendar-value').innerText = b;
                }
            });

            $('.js-example-basic-multiple').select2({
                placeholder: "Select Languages"
            });

            $('#calendar').click(function(e) {
                var dateval = $('.jcalendar-selected').text();
                var yearval = $('.jcalendar-year').text();
                var month = $('.jcalendar-month').text();
                var fulldate = month + ' ' + dateval + ',' + yearval;

                $('#input-calendar').val(fulldate);
                $('#calendar1').val(fulldate);
            })


            $('.first_nxtbutton, .second_nxtbutton, .third_savebtn').click(function(e) {

                var form = $("#wizard");
                form.validate({
                    errorPlacement: function($error, $element) {
                        $error.appendTo($element.closest("div.error-ele"));
                    },
                    rules: {
                        "options_jobtype[]": {
                            required: true,
                            minlength: 1
                        },
                        jobtitle: {
                            required: true,
                            maxlength: 125
                        },
                        job_position: {
                            required: true
                        },
                        postal_code: {
                            required: true
                        },
                        country1: {
                            required: true
                        },
                        city: {
                            required: true,
                            maxlength: 20
                        },
                        ukcity: {
                            required: true
                        },
                        landmark: {
                            required: true,
                            maxlength: 40
                        },
                        duration: {
                            required: true
                        },
                        "options_exp[]": {
                            required: true,
                            minlength: 1
                        },
                        "options_outlined[]": {
                            required: true,
                            minlength: 1
                        },
                        "req_language[]": {
                            required: true
                        },
                        // "preffered_lang[]": {
                        //     required: true
                        // },
                        "paycurrency": {
                            required: true
                        },
                        "payamountto": {
                            required: true,
                            maxlength: 10
                        },
                        "payamountfrom": {
                            required: true,
                            maxlength: 10
                        },
                        "frequency": {
                            required: true
                        },
                        "hrsperweek": {
                            required: true
                        },
                        "workschedule": {
                            required: true,
                            maxlength: 500
                        },
                        "job_details": {
                            required: true,
                            maxlength: 10050
                        },
                        "terms1": {
                            required: true
                        },
                        "terms2": {
                            required: true
                        },

                    },
                    messages: {
                        'options_jobtype[]': {
                            required: "Please select at least one job type"
                        },
                        'jobtitle': {
                            required: "Job title field is required",
                            maxlength: "Job title max length is 125 characters"
                        },
                        'postal_code': {
                            required: "Postal code field is required"
                        },
                        'job_position': {
                            required: "Your Location is required"
                        },
                        'country1': {
                            required: "Country field is required"
                        },
                        'city': {
                            required: "City field is required"
                        },
                        'ukcity': {
                            required: "City field is required"
                        },
                        'landmark': {
                            required: "Area field is required",
                            maxlength: "Area max length is 125 characters"
                        },
                        'duration': {
                            required: "Job duration field is required"
                        },
                        'options_exp[]': {
                            required: "Please select at least one experience"
                        },
                        'options_outlined[]': {
                            required: "Please select at least one work with"
                        },
                        'req_language[]': {
                            required: "Please select required language field"
                        },
                        // 'preffered_lang[]': {
                        //     required: "Please select Additional Language field"
                        // },
                        'paycurrency': {
                            required: "Please select currency"
                        },
                        'payamountto': {
                            required: " Pay Amount To field is required "
                        },
                        'payamountfrom': {
                            required: " Pay Amount From field is required "
                        },
                        'frequency': {
                            required: "Pay frequency field is required"
                        },
                        'hrsperweek': {
                            required: "Hours per week field is required"
                        },
                        'workschedule': {
                            required: "Work schedule field is required"
                        },
                        'job_details': {
                            required: "Job details field is required"
                        },
                        'terms1': {
                            required: "This term a is mandate to proceed with the job post"
                        },
                        'terms2': {
                            required: "This term a is mandate to proceed with the job post"
                        },

                    },

                });
                if (form.valid() === true) {
                    if ($('#step1_information').is(":visible")) {
                        current_fs = $('#step1_information');
                        next_fs = $('#step2_information');
                        next_to_nxt_fs = $('#step3_information');

                        next_fs.show();
                        current_fs.hide();
                        next_to_nxt_fs.hide();

                        goTo('first', 'second');

                    } else if ($('#step2_information').is(":visible")) {
                        current_fs = $('#step2_information');
                        next_fs = $('#step3_information');
                        next_to_nxt_fs = $('#step1_information');

                        next_fs.show();
                        current_fs.hide();
                        next_to_nxt_fs.hide();

                        goTo('second', 'last')
                    } else if ($('#step3_information').is(":visible")) {
                        var btnval = $(this).prop("name");
                        $('#btnpressed').val(btnval);

                        var dateval = $('.jcalendar-selected').text();
                        var yearval = $('.jcalendar-year').text();
                        var month = $('.jcalendar-month').text();
                        var fulldate = month + ' ' + dateval + ',' + yearval;

                        $('#calendar1').val(fulldate);

                        showPreviewPopup();
                    }
                }
            });

            $('.chkbxsector').click(function(e) {
                $(this).next().removeClass('active');
                if ($(this).prop("checked")) {
                    $(this).next().addClass('active');
                }
            });

            $(".allownumericwithdecimal").on("keypress keyup blur", function(event) {

                if ($(this).val() == 0) {
                    $(this).val(null);
                }
                //this.value = this.value.replace(/[^0-9\.]/g,'');
                $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event
                        .which > 57)) {
                    event.preventDefault();
                }
            });

            // #######################################################################################
            // #######################################################################################
            // #######################################################################################
            // #######################################################################################
            // #######################################################################################
            // #######################################################################################
            // #######################################################################################
            function prepareEdit() {
                let isEdit = {{ $job ? 'true' : 'false' }};
                if (!isEdit) {
                    return;
                }

                let profile_category_id = "{{ $job?->profile_category_id }}";

                let paymentOption = "{{ $job?->paymentOption }}";
                let date = "{{ $job?->start_date }}";
                let asap = "{{ $job?->asap }}";
                

                $('form[id="wizard"] input[name="options"][value="' + profile_category_id + '"]').click();

                jobPositionChange();
                $('form[id="wizard"] input[name="paymentOption"][value="' + paymentOption + '"]').click();

                $('form[id="wizard"] input[name="paymentOption"][value="' + paymentOption + '"]').click();
                $('form[id="wizard"] input[name="date"][value="' + asap + '"]').click();

                $('form[id="wizard"] input[name="calendar"]').val(date);

                if(document.location.hash === '#edit-section-2'){
                    $('a.first_nxtbutton').click();

                }else if(document.location.hash === '#edit-section-3'){
                    console.log('hi')
                    $('a.first_nxtbutton').click();
                    setTimeout(() => {
                        $('button.second_nxtbutton').click();
                    }, 500);
                }

                
                // 
            }

            prepareEdit();

            $(document).on('click', 'input.jchkbox, input.workchkbox, input.expchkbox', function(e) {
                $(this).next().removeClass('active');
                if ($(this).prop("checked") == true) {
                    $(this).next().addClass('active');
                }
            });

        });

        $(document).on('click', '#marketing-learn-more', function(e) {
            $("#marketingModal").modal('show');
        });

        $(document).on('click', '#privacy-learn-more', function(e) {
            $("#privacyModal").modal('show');
            $("#privacyModal").css('z-index', 1070);
            $(".modal-backdrop").last().css('z-index', 1060);
        });

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    if (!$('body').hasClass('modal-open') && $("#post-vacancy-edit").hasClass('show')) {
                        $("body").first().addClass('modal-open');
                    }
                }
            });
        });

        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });

        var previousPage = '-';

        function goTo(from, to) {
            if (from == "first" && to == 'second') {
                $(".actions li:nth-child(2) a").click();
            } else if (from == "first" && to == 'last') {
                $("a#wizard-t-2").click();
            } else if (from == "second" && to == 'last') {
                $(".actions li:nth-child(2) a").click();
            }
            previousPage = from;
        }

        function goBack() {

            if (previousPage == "first") {

                if ($('#step2_information').is(":visible")) {
                    current_fs = $('#step2_information');
                    next_fs = $('#step1_information');
                    next_to_nxt_fs = $('#step3_information');

                    next_fs.show();
                    current_fs.hide();
                    next_to_nxt_fs.hide();
                }

                $("a#wizard-t-0").click();

            } else if (previousPage == "second") {

                if ($('#step3_information').is(":visible")) {
                    current_fs = $('#step3_information');
                    prev_fs = $('#step2_information');
                    prev_to_prev_fs = $('#step1_information');

                    current_fs.hide();
                    prev_fs.show();
                    prev_to_prev_fs.hide();
                }

                previousPage = "first";
                $("a#wizard-t-1").click();

            } else {
                alert('something went wrong');
            }
            console.log( current_fs ,prev_fs,prev_to_prev_fs);
        }

        function set_type_val(type_val) {
            $('form[id="wizard"] input[name="type"]').val(type_val);
        }

        function set_client_type_val(type_val) {
            $('form[id="wizard"] input[name="client_type"]').val(type_val);
        }

        function showPreviewPopup(type_val) {
            $('#post-vacancy-edit').modal('show');

            $('.edit-preview[data-type="category"]').html(
                $('form[id="wizard"] input[name="options"][value="' + $(
                    'form[id="wizard"] input[name="options"]:checked').val() + '"]').next().next().text()
            );

            let types = []
            $('form[id="wizard"] input[name="options_jobtype[]"]:checked').each(function(e) {
                types.push($(this).val());
            });
            $('.edit-preview[data-type="type"]').html(
                types.map(val => $('form[id="wizard"] input[name="options_jobtype[]"][value="' + val + '"]').next()
                    .text()).join(', ')
            );

            $('.edit-preview[data-type="job-title"]').html(
                $('form[id="wizard"] input[name="jobtitle"]').val()
            );

            $('.edit-preview[data-type="based-in"]').html(
                $('form[id="wizard"] select[name="job_position"]').val()
            );

            $('.edit-preview[data-type="country"]').html(
                $('form[id="wizard"] select[name="job_position"]').val() === 'Outside UK' ?
                $('form[id="wizard"] select[name="country1"]').val() :
                $('form[id="wizard"] select[name="uk_country"]').val()
            );

            $('.edit-preview[data-type="city"]').html(
                $('form[id="wizard"] select[name="job_position"]').val() === 'Outside UK' ?
                $('form[id="wizard"] input[name="city"]').val() :
                $('form[id="wizard"] select[name="ukcity"]').val()
            );

            $('.edit-preview[data-type="postal-code"]').html(
                $('form[id="wizard"] input[name="postal_code"]').val()
            );

            $('.edit-preview[data-type="area"]').html(
                $('form[id="wizard"] input[name="landmark"]').val()
            );

            $('.edit-preview[data-type="job-duration"]').html(
                $('form[id="wizard"] select[name="duration"]').val()
            );

            let tasks = []
            $('form[id="wizard"] input[name="options_exp[]"]:checked').each(function(e) {
                tasks.push($(this).val());
            });

            $('.edit-preview[data-type="task"]').html(
                tasks.map(val => $('form[id="wizard"] input[name="options_exp[]"][value="' + val + '"]').next().text())
                .join(', ')
            );

            let positions = []
            $('form[id="wizard"] input[name="options_outlined[]"]:checked').each(function(e) {
                positions.push($(this).val());
            });
            $('.edit-preview[data-type="position"]').html(
                positions.map(val => $('form[id="wizard"] input[name="options_outlined[]"][value="' + val + '"]').next()
                    .text()).join(', ')
            );

            $('.edit-preview[data-type="languages-req"]').html(
                $('form[id="wizard"] select[name="req_language[]"]').val() ?
                $('form[id="wizard"] select[name="req_language[]"]').val().join(', ') :
                '--'
            );

            $('.edit-preview[data-type="languages-pref"]').html(
                $('form[id="wizard"] select[name="preffered_lang[]"]').val() ?
                $('form[id="wizard"] select[name="preffered_lang[]"]').val().join(', ') :
                '--'
            );

            $('.edit-preview[data-type="start"]').html(
                $('form[id="wizard"] input[name="date"]:checked').val() === 'asap' ?
                'ASAP (As Soon As Possible)' :
                $('form[id="wizard"] input[name="calendar1"]').val()
            );

            $('.edit-preview[data-type="pay"]').html(
                $('form[id="wizard"] input[name="paymentOption"]:checked').val() === 'negotiable' ?
                'To be discussed / Negotiable' :
                $('form[id="wizard"] select[name="paycurrency"]').val() + ' ' +
                $('form[id="wizard"] input[name="payamountfrom"]').val() + ' - ' +
                $('form[id="wizard"] select[name="paycurrency"]').val() + ' ' +
                $('form[id="wizard"] input[name="payamountto"]').val() + ' ' +
                $('form[id="wizard"] select[name="frequency"]').val()
            );


            $('.edit-preview[data-type="hours"]').html(
                $('form[id="wizard"] select[name="hrsperweek"]').val()
            );

            $('.edit-preview[data-type="schedule"]').html(
                $('form[id="wizard"] textarea[name="workschedule"]').val()
            );

            $('.edit-preview[data-type="extra"]').html(
                $('form[id="wizard"] textarea[name="job_details"]').val()
            );
        }

        $(document).on('click', 'a.goto-edit[data-target]', function(e) {
            e.preventDefault();
            let target = $(this).data('target');
            $('#post-vacancy-edit').modal('hide');
            console.log(target);
            switch (target) {
                case 0:
                    // if ($('#step3_information').is(":visible")) {
                    //     console.log('hi')
                    //     current_fs = $('#step3_information');
                    //     next_fs = $('#step1_information');
                    //     next_to_nxt_fs = $('#step2_information');

                    //     next_fs.show();
                    //     current_fs.hide();
                    //     next_to_nxt_fs.hide();
                    // }

                    // $("a#wizard-t-0").click();
                    $("button.go-back-3").click();
                    $("button.go-back-2").click();
                    $('#step1_information').show();

                    break;
                case 1:

                    // if ($('#step3_information').is(":visible")) {
                    //     current_fs = $('#step3_information');
                    //     prev_fs = $('#step2_information');
                    //     prev_to_prev_fs = $('#step1_information');

                    //     current_fs.hide();
                    //     prev_fs.show();
                    //     prev_to_prev_fs.hide();
                    // }

                    // previousPage = "first";
                    $("button.go-back-3").click();
                    break;
            }
        });

        $(document).on('click', '#submit-edit-form', function(e) {
            e.preventDefault();

            $("label.terms1-error").addClass('d-none');
            $("label.terms2-error").addClass('d-none');

            if ($("#terms1").is(':checked') === false) {
                $("label.terms1-error").removeClass('d-none');
                return;
            }

            if ($("#terms2").is(':checked') === false) {
                $("label.terms2-error").removeClass('d-none');
                return;
            }

            $('form[id="wizard"] input[name="marketing"]').val('');
            if ($("#marketing").is(':checked') === true) {
                $('form[id="wizard"] input[name="marketing"]').val('1');
            }

            $.ajax({
                url: isEdit ? '' : '{{ url('user/client/postnew_vacancy') }}',
                type: "POST",
                data: $('#wizard').serialize(),
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success == '1') {
                        window.location = '/user/client/dashboard';
                    } else {
                        alert('something went wrong, contact support');
                    }
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert('something went wrong, contact support');
                }
            });
        });

        function loadCategories(){
            loadExpWorkchkbox();

            var profcat = $('input[name="options"]:checked').val();

            if(!profcat){
                profcat = $('input[name="options"]').val();
            }
            $.ajax({
                url: "{{ url('user/client/getjobtypes') }}" + '/' + profcat,
                "type": "POST",
                data: {
                    profileid: profcat,
                    _token: '{{ csrf_token() }}'
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success == '1') {
                        $('#JobTypeID').html(response.html);
                        if (isEdit) {
                            let jobtypes = "{{ $job?->jobtypes }}".split(',');
                            jobtypes.forEach(val => {
                                $('form[id="wizard"] input[name="options_jobtype[]"][value="' +
                                    val + '"]').click();
                            });
                        }

                    }
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                }
            });
        }

        function loadExpWorkchkbox() {
            var profcat = $('input[name="options"]:checked').val();

            $.ajax({
                url: "{{ url('user/client/getall_loader') }}" + '/' + profcat,
                type: "POST",
                data: {
                    profileid: profcat,
                    _token: '{{ csrf_token() }}'
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('.positionID').html(response.html);
                        $('.workwithID').html(response.html1);
                        let positions = "{{ $job?->position }}".split(',');
                            positions.forEach(val => {
                                $('form[id="wizard"] input[name="options_exp[]"][value="' +
                                    val + '"]').click();
                            });
                        let workwith = "{{ $job?->workwith }}".split(',');
                        workwith.forEach(val => {
                            $('form[id="wizard"] input[name="options_outlined[]"][value="' +
                                val + '"]').click();
                        });
                    }
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                }
            });
        }

    </script>
@endsection
