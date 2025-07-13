{{-- @extends('layouts.master_user') --}}
@extends('layouts.master_website')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/website/form-wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="/website/form-wizard/css/style.css">

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

        #modalSuccessPostJob .modal-header .close {
            padding: 0 !important;
            margin: -1rem -1rem -1rem auto;
            margin-top: -1rem;
            position: relative;
            right: 4px;
            margin-top: 0px;
        }
    </style>
@endsection

@section('search-jobs')
    active
@endsection

@section('content')
    <main class="seearch">
        <div class="main-section">
            <div class="container">
                <div class="main-section-data">
                    @include('shared.response_msg')
                    <div class="row">
                        <div class="col-lg-12 mb-3 pad-left-mob pad-right-mob" style="font-weight: bold;">
                            <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Select
                                Category</h3>
                            <hr class="bold" />
                        </div>
                    </div>
                    <div class="row six-cols">
                        <div class="col-lg-12 mb-0 pl-0 pr-0" data-toggle="buttons">
                            <div class="row">
                                @include('shared.categories', [
                                    'arrows' => true,
                                    'active' => 'Nanny',
                                    'tag' => 'label',
                                    'class1' => 'pad-left-mob',
                                    'class2' => '',
                                    'class3' => 'form-check-label btn-kinderway-cat',
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="row jobtypediv">
                        <div class="col-lg-12 mb-3 mt-4 pad-left-mob pad-right-mob" style="font-weight: bold;">
                            <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Job Type
                            </h3>
                            <hr class="bold" />
                        </div>
                        <div class="col-lg-12 mb-3 pad-left-mob pad-right-mob" id="JobTypeID">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <input type="hidden" id="hidden_page" name="hidden_page" value="1">
                        <input type="hidden" id="hidden_profile" name="hidden_profile" value="">
                        <input type="hidden" id="hidden_usertype" name="hidden_usertype" value="3">
                        <input type="hidden" id="hidden_duration" name="hidden_duration" value="3">
                        <input type="hidden" id="hidden_jobtypes" name="hidden_jobtypes" value="">

                        <div class="col-lg-3 pad-left-mob">
                            <div class="filter-secs shadow">
                                <div class="filter-heading">
                                    <h3>Filters</h3>
                                    <a href="#" class="clearall" title="">Clear all filters</a>
                                </div>
                                <div class="paddy">
                                    <div class="filter-dd">
                                        <div class="filter-ttl">
                                            <h3 style="color: #884d9b">Location</h3>
                                            <a href="#" class="locationclear" title="">Clear</a>
                                        </div>
                                        <form>
                                            <select class="form-control" name="job_position" id="job_position"
                                                style="-webkit-appearance: menulist-button; margin-bottom: 5px;">
                                                <option value="">Select Location</option>
                                                <option value="UK">UK</option>
                                                {{-- 
                                                <option value="Outside UK">Outside UK (International)</option>
                                                --}}
                                            </select>
                                            <select class="form-control" name="searchCountry" id="searchCountry"
                                                style="-webkit-appearance: menulist-button; margin-bottom: 5px; display: none">
                                                <option value="">Select Country Name</option>
                                                @foreach ($countries as $key => $value)
                                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control" name="searchCityText" id="searchCity"
                                                value="" placeholder="Enter City"
                                                style="display: none; margin-bottom: 5px;">
                                            <select name="searchCityList" id="searchCityList" class="form-control"
                                                style="-webkit-appearance: menulist-button; width: 100%; margin-bottom: 5px; display: none">
                                                <option value="">Select City</option>
                                                @foreach ($londoncity as $key => $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            <select name="searchPostCode" id="searchPostCode"
                                                class="js-example-basic-single-4"
                                                style="-webkit-appearance: menulist-button; display: none; margin-bottom: 5px;">
                                                <option value="">Select Postal Code</option>
                                                @foreach ($londonpostal as $key => $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="hidden_page" name="hidden_page" value="1">
                                            <input type="hidden" id="hidden_profile" name="hidden_profile"
                                                value="">
                                            <input type="hidden" id="hidden_usertype" name="hidden_usertype"
                                                value="3">
                                            <input type="hidden" id="hidden_duration" name="hidden_duration"
                                                value="3">
                                            <input type="hidden" id="hidden_jobtypes" name="hidden_jobtypes"
                                                value="">
                                        </form>
                                    </div>
                                    <div class="filter-dd">
                                        <div class="filter-ttl">
                                            <h3 style="color: #884d9b">Filter by Job Types</h3>
                                            <a href="#" class="usertypeclear" title="">Clear</a>
                                        </div>
                                        <form class="job-tp">
                                            <ul class="avail-checks">
                                                <li>
                                                    <input class="utype" type="radio" name="usertype" id="c1"
                                                        value="1">
                                                    <label for="c1">
                                                        <span></span>
                                                    </label>
                                                    <small>Private</small>
                                                </li>
                                                <li>
                                                    <input class="utype" type="radio" name="usertype" id="c2"
                                                        value="2">
                                                    <label for="c2">
                                                        <span></span>
                                                    </label>
                                                    <small>Business</small>
                                                </li>
                                                <li>
                                                    <input class="utype" type="radio" name="usertype" id="c3"
                                                        value="3" checked>
                                                    <label for="c3">
                                                        <span></span>
                                                    </label>
                                                    <small>All</small>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>
                                    <div class="filter-dd">
                                        <div class="filter-ttl">
                                            <h3 style="color: #884d9b">Filter by Duration</h3>
                                            <a href="#" class="durationclear" title="">Clear</a>
                                        </div>
                                        <form class="job-tp">
                                            <ul class="avail-checks">
                                                <li>
                                                    <input type="radio" name="durationjob" id="jd1"
                                                        value="1">
                                                    <label for="jd1">
                                                        <span></span>
                                                    </label>
                                                    <small>Permanent</small>
                                                </li>
                                                <li>
                                                    <input type="radio" name="durationjob" id="jd2"
                                                        value="2">
                                                    <label for="jd2">
                                                        <span></span>
                                                    </label>
                                                    <small>Temporary</small>
                                                </li>
                                                <li>
                                                    <input type="radio" name="durationjob" id="jd3"
                                                        value="3" checked>
                                                    <label for="jd3">
                                                        <span></span>
                                                    </label>
                                                    <small>All</small>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>
                                    <div class="filter-dd mb-0">
                                        <button id="updateSearch" type="button" class="btn btn-kinderway btn-block"
                                            style="float: right;">Update Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-9 pad-right-mob">
                            <div class="row mt-1 mb-3">
                                <div class="col-lg-12 p-0">
                                    <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">
                                        Search Results</h3>
                                    <hr class="bold" />
                                </div>
                            </div>
                            <div class="main-ws-sec" id="setMainSearchSection">
                                @include('website.ajaxsearchjobs')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if (!Auth::user())
        <!--Start Login Message Modal -->
        <div id="loginConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-center">
                <div class="modal-content">
                    <div class="modal-header d-block" style="padding-bottom: 20px;">
                        <div class="swal-icon swal-icon--warning">
                            <span class="swal-icon--warning__body">
                                <span class="swal-icon--warning__dot"></span>
                            </span>
                        </div>
                        <h3 class="modal-title swal-title aligncenter modal-text" id="myModalLabel2">
                            Get Started
                        </h3>
                    </div>
                    <form method="post" enctype="multipart/form-data" class="js-validate form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body aligncenter">
                            <div class="form-group">
                                <div class="mt-3">
                                    <label class="form-label modal_margin">
                                        <span class="mintxt-modal" id="modal_job_val">Register or Login to View
                                            Job.</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="swal-button swal-button--confirm"
                                style="border-radius: 20px; background-color: #8c50a0; color: #fff;"
                                onclick="window.location.href = '{{ url('/register') }}';">Register</button>
                            <button type="button" class="swal-button swal-button--confirm"
                                style="border-radius: 20px; background-color: #404786; color: #fff;"
                                onclick="window.location.href = '{{ url('/login') }}';">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Model -->
    @endif
    <div id="modal_aside_right" class="modal fixed-left fade searchsidemodalId pr-0" tabindex="-1" role="dialog">
    </div>
    <div class="modal fade" id="modalSuccessPostJob" tabindex="-1" role="dialog"
        aria-labelledby="modalSuccessPostJobLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white" id="modalSuccessPostJobLabel">You have applied!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="modal-message" class="alert alert-success alert-dismissible mt-3">The job poster will contact
                        you if they think you are suitable for this position. Messages regarding this job application will
                        appear on your dashboard
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="jobapplybtnok" onclick="backlist()" data-url="nanny"
                        data-dismiss="modal" class="btn btn-lg btn-block btn-kinderway"
                        style="background-image: linear-gradient(to right, #8c50a0 , #304384); border-radius: 50px; cursor: pointer;">ok
                        !</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function backlist() {
            if ($(".modal").is(":visible")) {
                $("#modal_aside_right").hide();
                $(".modal-backdrop").hide();
                $('body').css('overflow', 'auto');
            }
        };

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            // $('.jobtypediv').hide();
            loadjobtype(1);

            $('.js-example-basic-single-general').select2({
                minimumResultsForSearch: -1
            });

            $('#load_more_job_results').on('click', function() {
                $("#loginConfirmModal").modal().show();
                $("#modal_job_val").text('Register or Login to View more jobs');
            });

            function fetch_data(page, profile = "", usertype = "", duration = "", jobtypes = "") {

                var job_position = $('#job_position').val();
                var country = $('#searchCountry').val();
                var city = (country == 'United Kingdom') ? $('#searchCityList').val() : $('#searchCity').val();
                var postalCode = $('#searchPostCode').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('/searchjobs_ajax') }}",
                    data: {
                        page: page,
                        profile: profile,
                        usertype: usertype,
                        duration: duration,
                        jobtypes: jobtypes,
                        job_position: job_position,
                        country: country,
                        city: city,
                        postalCode: postalCode,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#setMainSearchSection').html(data);
                        $('.post-bar').click(function(e) {
                            @if (!Auth::user())
                                $("#loginConfirmModal").modal().show();
                                $("#modal_job_val").text('Register or Login to View Job');
                                return false
                            @endif
                            e.preventDefault();
                            var currpopup = $(this).find('#popid').val();

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });

                            $.ajax({
                                url: "{{ url('/provider/search-sidebar') }}",
                                "type": "POST",
                                data: {
                                    currpopup: currpopup,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success == '1') {
                                        $("#modal_aside_right").show();
                                        $('.modal-backdrop').show();
                                        $('.searchsidemodalId').html(response.html);
                                        $('body').css('overflow', 'hidden');
                                    } else {
                                        alert(
                                            'something went wrong, contact support');
                                    }
                                },
                                error: function(jqXHR, testStatus, error) {
                                    // console.log(error);
                                    alert('something went wrong, contact support');
                                }
                            });
                        });
                    },
                    error: function(jqXHR, testStatus, error) {
                        // console.log(error);
                        alert('something went wrong, contact support');
                    }
                });
            }

            //Location => skills:
            $("#searchskills").on("keyup", function() {
                var searchval = document.getElementById('searchskills').value;
                $('#hidden_skills').val(searchval);
            });

            //Check for jobtypes:
            var arr_sort = new Array();

            function removeVal(arr, val) {
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i] == val)
                        arr.splice(i, 1);
                }
            }

            $(document).on('click', '.jchkbox', function() {

                if ($(this).prop("checked")) {
                    arr_sort.push($(this).val());
                } else {
                    removeVal(arr_sort, $(this).val());
                }

                $('#hidden_jobtypes').val(arr_sort);
                var page = $('#hidden_page').val();
                var profile = $('#hidden_profile').val();
                var duration = $('#hidden_duration').val();
                var usertype = $('#hidden_usertype').val();
                // console.log(arr_sort);
                fetch_data(page, profile, usertype, duration, arr_sort);
            });
            //-----------------------------------

            $("#updateSearch").click(function() {
                var currusertype = $('input[name="usertype"]:checked').val();
                $('#hidden_usertype').val(currusertype);

                var currduration = $('input[name="durationjob"]:checked').val();
                $('#hidden_duration').val(currduration);

                var page = $('#hidden_page').val();
                var profile = $('#hidden_profile').val();
                var duration = $('#hidden_duration').val();
                var jobtypes = $('#hidden_jobtypes').val();
                var usertype = $('#hidden_usertype').val();

                fetch_data(page, profile, usertype, duration, jobtypes);
            });


            $(".clearall").click(function(e) {

                e.preventDefault();
                $('#job_position').val('');
                $('#searchCountry').val('');
                $('#searchCity').val('');
                $('#searchCityList').val('');
                $('#searchPostCode').val('');

                $('#hidden_usertype').val(3);
                $(".usertype").prop("checked", false);
                $("#c3").prop("checked", true);

                $('#hidden_duration').val(3);
                $(".durationjob").prop("checked", false);
                $("#jd3").prop("checked", true);

                $('#searchCountry').hide();
                $('#searchCity').hide();
                $('#searchCityList').hide();

                var page = $('#hidden_page').val();
                var profile = $('#hidden_profile').val();
                var jobtypes = $('#hidden_jobtypes').val();

                fetch_data(page, profile, '3', '3', jobtypes);
            });

            $(".usertypeclear").click(function(e) {
                e.preventDefault();
                $('#hidden_usertype').val(3);
                $(".usertype").prop("checked", false);
                $("#c3").prop("checked", true);
                var page = $('#hidden_page').val();
                var profile = $('#hidden_profile').val();
                var duration = $('#hidden_duration').val();
                var jobtypes = $('#hidden_jobtypes').val();

                fetch_data(page, profile, '3', duration, jobtypes);
            });

            $(".durationclear").click(function(e) {
                e.preventDefault();
                $('#hidden_duration').val(3);
                $(".durationjob").prop("checked", false);
                $("#jd3").prop("checked", true);
                var page = $('#hidden_page').val();
                var profile = $('#hidden_profile').val();
                var usertype = $('#hidden_usertype').val();
                var jobtypes = $('#hidden_jobtypes').val();

                fetch_data(page, profile, usertype, '3', jobtypes);
            });

            $(".locationclear").click(function(e) {
                e.preventDefault();
                $('#job_position').val('');
                $('#searchCountry').val('');
                $('#searchCity').val('');
                $('#searchCityList').val('');
                $('#searchPostCode').val('');

                $('#searchCountry').hide();
                $('#searchCity').hide();
                $('#searchCityList').hide();


                var page = $('#hidden_page').val();
                var profile = $('#hidden_profile').val();
                var usertype = $('#hidden_usertype').val();
                var jobtypes = $('#hidden_jobtypes').val();
                var duration = $('#hidden_duration').val();

                fetch_data(page, profile, usertype, duration, jobtypes);
            });

            function loadjobtype(profileid) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('/getjobtypes') }}" + '/' + profileid,
                    "type": "POST",
                    data: {
                        profileid: profileid,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.success == '1') {
                            $('#JobTypeID').html(response.html);

                            $('.jchkbox').click(function(e) {
                                if ($(this).prop("checked") == true) {
                                    $(this).next().addClass('active');
                                } else if ($(this).prop("checked") == false) {
                                    $(this).next().removeClass('active');
                                }
                            });
                        } else {
                            alert('something went wrong, contact support');
                        }
                    },
                    error: function(jqXHR, testStatus, error) {
                        // console.log(error);
                        alert('something went wrong, contact support');
                    }
                });
            }

            $("input[name='options']").change(function(e) {
                e.preventDefault();

                var currprofile = $(this).val();
                $('#hidden_profile').val(currprofile);

                var optionid = $(this).attr("id");
                $('#hidden_jobtypes').val('');

                if (optionid == 'option1') {
                    $('.jobtypediv').hide();
                } else {
                    $('.jobtypediv').show();
                    loadjobtype(currprofile);
                }

                var page = $('#hidden_page').val();
                var usertype = $('#hidden_usertype').val();
                var duration = $('#hidden_duration').val();
                var jobtypes = $('#hidden_jobtypes').val();

                fetch_data(page, currprofile, usertype, duration, jobtypes);
            });

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var profile = $('#hidden_profile').val();
                var usertype = $('#hidden_usertype').val();
                var duration = $('#hidden_duration').val();
                var jobtypes = $('#hidden_jobtypes').val();
                fetch_data(page, profile, usertype, duration, jobtypes);
            });

            $("body").click(function(event) {
                if ($('.searchsidemodalId').children().length > 0) {
                    if (!$(event.target).closest('#openModal').length && !$(event.target).is(
                        '#openModal')) {
                        if ($("#openModal").is(":visible")) {
                            $(".searchsidemodalId").hide();
                            $('.modal-backdrop').hide();
                            $('body').css('overflow', 'auto');
                        }
                    }
                }
            });

            $('.post-bar').click(function(e) {
                @if (!Auth::user())
                    $("#loginConfirmModal").modal().show();
                    $("#modal_job_val").text('Register or Login to View Job');
                    return false
                @endif
                e.preventDefault();
                var currpopup = $(this).find('#popid').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('/provider/search-sidebar') }}",
                    "type": "POST",
                    data: {
                        currpopup: currpopup,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        //console.log(response);
                        if (response.success == '1') {
                            $("#modal_aside_right").show();
                            $('.modal-backdrop').show();
                            $('.searchsidemodalId').html(response.html);
                            $('body').css('overflow', 'hidden');

                            $("#goToProfile").click(function() {
                                // console.log('in');
                                var url = $("#goToProfile").attr('data-url');
                                // console.log(url);
                                $(location).attr('href',
                                    './provider/service-profiles/' + url);
                            });
                        } else {
                            alert('something went wrong, contact support');
                        }
                    },
                    error: function(jqXHR, testStatus, error) {
                        // console.log(error);
                        alert('something went wrong, contact support');
                    }
                });
            });

            $(document).on('click', '#jobapplybtn', function(e) {

                var jobappliedid = $('#jobappliedid').val();
                var jobuserid = $('#jobuserid').val();
                var providerprofileid = $('#profileid').val();
                var categoryid = $('#categoryid').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('/provider/setprovider-connnect') }}",
                    "type": "POST",
                    data: {
                        jobid: jobappliedid,
                        profilecat: categoryid,
                        profileid: providerprofileid,
                        jobuserid: jobuserid,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == '1') {
                            $('#modal_aside_right').modal('toggle');
                            $('#modal_aside_right').modal().hide();
                            $('#modalSuccessPostJob').modal('show');
                        } else {
                            $('#modal-message').text('Something went wrong, contact support');
                            $('#modalSuccessPostJob').modal('show');
                        }
                    },
                    error: function(jqXHR, testStatus, error) {
                        // console.log(error);
                        $('#modal-message').text('Something went wrong, contact support');
                        $('#modalSuccessPostJob').modal('show');
                    }
                });
            });
        });


        function setCountry(job_position) {

            if (job_position != '') {
                // console.log('not black');
                if (job_position == 'UK') {
                    // console.log('UK');
                    $("#searchCountry").val('United Kingdom');
                    $("#searchCountry").hide();
                    $("#searchCountry option[value!='United Kingdom']").attr('disabled', 'disabled');
                    $("#searchCountry option[value='United Kingdom']").removeAttr("disabled").attr('selected', 'selected');
                } else {
                    // console.log('not UK');
                    $("#searchCountry").val('');
                    $("#searchCountry").show();
                    $("#searchCountry option[value!='United Kingdom']").removeAttr("disabled");
                    $("#searchCountry option[value='United Kingdom']").attr('disabled', 'disabled').removeAttr("selected");
                }
            } else {
                $("#job_position").val('');
                $("#searchCountry").val('');
                $("#searchCountry").hide();
                $("#searchCountry option[value='United Kingdom']").removeAttr("disabled").removeAttr("selected");
                $("#searchCountry option[value!='United Kingdom']").removeAttr("disabled").removeAttr("selected");
            }
            $("#searchCountry").trigger('change');

        }

        $("#job_position").change(function() {
            var job_position = $('option:selected', this).text();
            setCountry(job_position);
        });

        $("#searchCountry").change(function() {
            var countryValue = $('option:selected', this).text();

            if (countryValue == 'United Kingdom') {
                $('#searchCityList').show();
                $('#searchCity').hide().val('');
            } else {
                $('#searchCity').show();
                $('#searchCityList').hide().val('');
                $('#searchPostCode').hide().val('');
            }
        });

        $("#searchCityList").change(function() {
            var cityValue = $('option:selected', this).text();

            if (cityValue == 'London') {
                $('#searchPostCode').show();
            } else {
                $('#searchPostCode').hide().val('');
            }
        });
    </script>
@endsection
