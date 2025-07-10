@extends('layouts.master_website')

@section('css')
    <link rel="stylesheet" href="/website/form-wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="/website/form-wizard/css/style.css">
    <style>
        .modal .modal-dialog-aside{
            width: 800px;
            max-width:100%;
            height: 100%;
            margin:0;
            transform: translate(0);
            transition: transform .2s;
        }
        .modal .modal-dialog-aside .modal-content{
            height: inherit;
            border:0;
            border-radius: 0;
        }
        .modal .modal-dialog-aside .modal-content .modal-body{
            overflow-y: auto
        }
        .modal.fixed-left .modal-dialog-aside{
            margin-left:auto;
            transform: translateX(100%);
        }
        .modal.fixed-right .modal-dialog-aside{
            margin-right:auto;
            transform: translateX(-100%);
        }
        .modal.show .modal-dialog-aside{
            transform: translateX(0);
        }
    </style>
@endsection

@section('search-providers')
active
@endsection

@section('content')
<main class="seearch">
    <div class="main-section">
        <div class="container">
            <div class="main-section-data">
                @include('shared.response_msg')
                {{-- <div class="row">
                    <div class="col-lg-12 mb-3 pad-left-mob pad-right-mob" style="font-weight: bold;">
                        <h3 class="pb-2" style="font-weight:bold; font-size: 26px; color: #304384;">Select Category</h3>
                        <hr class="bold" />
                    </div>
                </div> --}}
                {{-- <div class="row six-cols pl-0 pr-0" data-toggle="buttons">
                    @include('shared.categories', ['arrows' => true, 'active' => 'Nanny', 'tag' => 'label', 'class1' => 'pad-left-mob', 'class2' => '', 'class3' => 'form-check-label btn-kinderway-cat'])
                </div> --}}
                {{-- <div class="row jobtypediv">
                    <div class="col-lg-12 mb-3 mt-4 pad-left-mob pad-right-mob" style="font-weight: bold;">
                        <h3 class="pb-2" style="font-weight:bold; font-size: 26px; color: #304384;">Job Type</h3>
                        <hr class="bold" />
                    </div>
                    <div class="col-lg-12 mb-3 pad-left-mob pad-right-mob" id="JobTypeID">
                    </div>
                </div> --}}
                <div class="row mt-4">
                    <input type="hidden" id="hidden_page" name="hidden_page" value="1">
                                                            <input type="hidden" id="hidden_profile" name="hidden_profile" value="">
                                                            <input type="hidden" id="hidden_language" name="hidden_language" value="3">
                                                            <input type="hidden" id="hidden_exp" name="hidden_exp" value="3">
                                                            <input type="hidden" id="hidden_jobtypes" name="hidden_jobtypes" value="">

{{--  <div class="col-lg-3 pad-left-mob">--}}
{{--                        <div class="filter-secs shadow">--}}
{{--                            <div class="filter-heading">--}}
{{--                                <h3>Filters</h3>--}}
{{--                                <a href="#" title="" class="clearall">Clear all filters</a>--}}
{{--                            </div>--}}
{{--                            <div class="paddy">--}}
{{--                                <div class="filter-dd">--}}
{{--                                    <div class="filter-ttl">--}}
{{--                                        <h3 style="color: #884d9b">Location</h3>--}}
{{--                                        <a href="#" class="locationclear" title="">Clear</a>--}}
{{--                                    </div>--}}
{{--                                    <form>--}}
{{--                                        <select class="form-control" name="job_position" id="job_position" style="-webkit-appearance: menulist-button; margin-bottom: 5px;">--}}
{{--                                            <option value="">Select Location</option>--}}
{{--                                            <option value="UK">UK</option>--}}
{{--                                            <option value="Outside UK">Outside UK (International)</option>--}}
{{--                                        </select>--}}
{{--                                        <select class="form-control" name="searchCountry" id="searchCountry" style="-webkit-appearance: menulist-button; margin-bottom: 5px; display: none;">--}}
{{--                                            <option value="">Select Country Name</option>--}}
{{--                                            @foreach($countries AS $key => $value)--}}
{{--                                                <option value="{{$value->name}}">{{$value->name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        <input type="text" class="form-control" name="searchCityText" id="searchCity" value="" placeholder="Enter City" style="display: none; margin-bottom: 5px;">--}}
{{--                                        <select name="searchCityList" id="searchCityList" class="form-control" style="-webkit-appearance: menulist-button; width: 100%; margin-bottom: 5px; display: none;" >--}}
{{--                                            <option value="">Select City</option>--}}
{{--                                            @foreach($londonCity AS $key => $value)--}}
{{--                                                <option value="{{$value}}">{{$value}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        <select name="searchPostCode" id="searchPostCode" class="js-example-basic-single-4" style="-webkit-appearance: menulist-button; display: none; margin-bottom: 5px;">--}}
{{--                                            <option value="">Select Postal Code</option>--}}
{{--                                            @foreach($londonPostal AS $key => $value)--}}
{{--                                                <option value="{{$value}}">{{$value}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        <input type="hidden" id="hidden_page" name="hidden_page" value="1">--}}
{{--                                        <input type="hidden" id="hidden_profile" name="hidden_profile" value="">--}}
{{--                                        <input type="hidden" id="hidden_language" name="hidden_language" value="3">--}}
{{--                                        <input type="hidden" id="hidden_exp" name="hidden_exp" value="3">--}}
{{--                                        <input type="hidden" id="hidden_jobtypes" name="hidden_jobtypes" value="">--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                                <div class="filter-dd">--}}
{{--                                    <div class="filter-ttl">--}}
{{--                                        <h3 style="color: #884d9b">Years Experience</h3>--}}
{{--                                        <a href="#" title="" class="expclear" >Clear</a>--}}
{{--                                    </div>--}}
{{--                                    <form class="job-tp">--}}
{{--                                        <select name="experienceval" id="experienceval">--}}
{{--                                            <option value="">Any Experience Level</option>--}}
{{--                                            <option value="0 - 1 Year">0 - 1 Year</option>--}}
{{--                                            <option value="1-2 Years">1-2 Years</option>--}}
{{--                                            <option value="2-3 Years">2-3 Years</option>--}}
{{--                                            <option value="3-5 Years">3-5 Years</option>--}}
{{--                                            <option value="5-10 Years">5-10 Years</option>--}}
{{--                                            <option value="10-20 Years">10-20 Years</option>--}}
{{--                                            <option value="20-30 Years">20-30 Years</option>--}}
{{--                                            <option value="30-40 Years">30-40 Years</option>--}}
{{--                                            <option value="40-50 Years">40-50 Years</option>--}}
{{--                                            <option value="50+ Years" >50+ Years</option>--}}
{{--                                        </select>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                                <div class="filter-dd">--}}
{{--                                    <div class="filter-ttl">--}}
{{--                                        <h3 style="color: #884d9b">Language</h3>--}}
{{--                                        <a href="#" title="" class="langclear">Clear</a>--}}
{{--                                    </div>--}}
{{--                                    <form class="job-tp">--}}
{{--                                        <select name="setlanguage" id=setlanguage>--}}
{{--                                            <option value="">Any Language</option>--}}
{{--                                            @foreach($languages AS $language)--}}
{{--                                                <option value="{{$language}}" >{{$language}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                                <div class="filter-dd mb-0">--}}
{{--                                    <button id="updateSearch"  type="button" class="btn btn-kinderway btn-block" style="float: right;">Update Search</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div> --}}
                    <div class="col-lg-12 pad-right-mob">
                        {{-- <div class="row mt-1 mb-3">
                            <div class="col-lg-12 pl-0 pr-0">
                                <h3 class="pb-2" style="font-weight:bold; font-size: 26px; color: #304384;">Search Results</h3>
                                <hr class="bold" />
                            </div>
                        </div> --}}
                        <div class="main-ws-sec" id="setMainSearchSection" style="height: 70vh;">
                                @include('website.ajaxsearchprovider')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!--Start Login Message Modal -->
<div id="loginConfirmModal" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <span class="mintxt-modal" id="modal_profile_val">Register or Login to View Profile.</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" onclick="window.location.href = '{{ url('/register') }}';">Register</button>
                    <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #404786; color: #fff;" onclick="window.location.href = '{{ url('/login') }}';">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Model -->

@if(Auth::check())
    <!--Start Login Message Modal -->
    <div id="postVacancyModal" class="modal fade set-modal-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    <span class="mintxt-modal">Post a job to see more candidates.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="swal-button swal-button--confirm" style="border-radius: 20px; background-color: #8c50a0; color: #fff;" onclick="window.location.href = '{{ url('/user/client/post-vacancy') }}';">Post a job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Model -->
@endif

<div id="modal_aside_right" class="modal fixed-left fade searchsidemodalId pr-0" tabindex="-1" role="dialog">
</div>

@endsection

@section('js')
<script>
    function backlist() {
        if ($(".modal").is(":visible")) {
            $("#modal_aside_right").hide();
            $('.modal-backdrop').hide();
            $('body').css('overflow', 'auto');
        }
    };

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        // $('.jobtypediv').hide();
        loadjobtype(1);

        $('#hidden_language').val('');
        $('#hidden_exp').val('');

        function fetch_data(page, profile="", setlanguage="", exp="", jobtypes="")
        {
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
                url:  "{{ url('/searchprovider_ajax') }}",
                data:{
                    page:page,
                    profile:profile,
                    setlanguage:setlanguage,
                    exp:exp,
                    jobtypes:jobtypes,
                    job_position:job_position,
                    country:country,
                    city:city,
                    postalCode:postalCode,
                    _token: '{{csrf_token()}}'
                },
                success:function(data){
                     $('#setMainSearchSection').html(data);
                },
           });
        }

         $("body").click(function(event) {
             if ($('.searchsidemodalId').children().length > 0){
                if(!$(event.target).closest('#openModal').length && !$(event.target).is('#openModal')) {
                    if ($(".modal").is(":visible")) {
                        if(!$("#reportModal").is(":visible")){
                            // console.log('hide backdrop');
                            $('.modal-backdrop').hide();
                        }
                       $("#modal_aside_right").hide();
                       $('body').css('overflow', 'auto');
                    }
                }
             }
        });

        //Check for jobtypes:
        var arr_sort = new Array();

        function removeVal(arr, val) {
            for(var i = 0; i < arr.length; i++)
            {
                if (arr[i] == val)
                    arr.splice(i, 1);
            }
        }

        $(document).on('click','.jchkbox',function() {
            // console.log('test1');
            if ($(this).prop("checked")){
                arr_sort.push($(this).val());
            }
            else{
                removeVal(arr_sort, $(this).val());
            }

            $('#hidden_jobtypes').val(arr_sort);
            var page = $('#hidden_page').val();
            var profile = $('#hidden_profile').val();
            var yof_exp = $('#hidden_exp').val();
            var setlanguage = $('#hidden_language').val();
            //console.log(arr_sort);
            fetch_data(page, profile, setlanguage, yof_exp, arr_sort);
        });
          //---------------------------

        $(".clearall").click(function(e){

            e.preventDefault();

            $('#job_position').val('');
            $('#searchCountry').val('');
            $('#searchCity').val('');
            $('#searchCityList').val('');
            $('#searchPostCode').val('');

            $('#hidden_exp').val('');
            $("#experienceval").val($("#experienceval option:first").val());

            $('#hidden_language').val('');
            $("#setlanguage").val($("#setlanguage option:first").val());

            $('#searchCountry').hide();
            $('#searchCity').hide();
            $('#searchCityList').hide();

            var page = $('#hidden_page').val();
            var profile = $('#hidden_profile').val();
            var jobtypes = $('#hidden_jobtypes').val();

            fetch_data(page, profile, '', '', jobtypes, '');
        });


        $(".langclear").click(function(e){
            e.preventDefault();
            $('#hidden_language').val('');
            $("#setlanguage").val($("#setlanguage option:first").val());

            var page = $('#hidden_page').val();
            var profile = $('#hidden_profile').val();
            var exp = $('#hidden_exp').val();
            var jobtypes = $('#hidden_jobtypes').val();

            fetch_data(page, profile, '', exp, jobtypes);
        });

        $(".expclear").click(function(e){
            e.preventDefault();
            $('#hidden_exp').val('');
            $("#experienceval").val($("#experienceval option:first").val());

            var page = $('#hidden_page').val();
            var profile = $('#hidden_profile').val();
            var setlanguage = $('#hidden_language').val();
            var jobtypes = $('#hidden_jobtypes').val();

            fetch_data(page, profile, setlanguage, '', jobtypes);
        });

        $(".locationclear").click(function(e){
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
            var setlanguage = $('#hidden_language').val();
            var jobtypes = $('#hidden_jobtypes').val();
            var exp = $('#hidden_exp').val();

            fetch_data(page, profile, setlanguage, exp, jobtypes);
        });

        function loadjobtype(profileid){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:  "{{ url('/getjobtypes_guest') }}"+ '/' + profileid,
                "type" : "POST",
                data:{
                  profileid:profileid,
                   _token: '{{csrf_token()}}'
                },
                success:function(response){
                    // console.log(response);
                    if(response.success == '1'){
                        $('#JobTypeID').html(response.html);

                        $('.jchkbox').click(function (e)
                        {
                            // console.log('test');
                            if($(this).prop("checked") == true){
                                $(this).next().addClass('active');
                            }
                            else if($(this).prop("checked") == false){
                                $(this).next().removeClass('active');
                            }
                        });
                    }else {
                        alert('something went wrong, contact support');
                    }
                },
           });
        }

         $("input[name='options']").change(function(e){
            e.preventDefault();

            var currprofile = $(this).val();
            $('#hidden_profile').val(currprofile);

            var optionid = $(this).attr("id");
            $('#hidden_jobtypes').val('');

            if(optionid == 'option1'){
                $('.jobtypediv').hide();
            }else{
                $('.jobtypediv').show();
                loadjobtype(currprofile);
            }

            var page = $('#hidden_page').val();
            var setlanguage = $('#hidden_language').val();
            var yof_exp = $('#hidden_exp').val();
            var jobtypes = $('#hidden_jobtypes').val();

            fetch_data(page, currprofile, setlanguage, yof_exp, jobtypes);
        });

        $("#updateSearch").click(function(){
            var currlanguage = $("#setlanguage option:selected").val();
            $('#hidden_language').val(currlanguage);

            var currexp = $("#experienceval option:selected").val();
            $('#hidden_exp').val(currexp);

            var page = $('#hidden_page').val();
            var profile = $('#hidden_profile').val();
            var setlanguage = $('#hidden_language').val();
            var jobtypes = $('#hidden_jobtypes').val();
            var yof_exp = $('#hidden_exp').val();

            fetch_data(page, profile, setlanguage, yof_exp, jobtypes);
        });

        $(document).on('click', '.pagination a',function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var profile = $('#hidden_profile').val();
            var setlanguage = $('#hidden_language').val();
            var yof_exp = $('#hidden_exp').val();
            var jobtypes = $('#hidden_jobtypes').val();
            fetch_data(page, profile, setlanguage, yof_exp, jobtypes);
        });

        $(document).on('click','#pills-profile-tab',function(e) {
            $("#modal_aside_right").show();
            $('.modal-backdrop').show();
            $('#pills-home').hide();
            $('#pills-document').hide();
           $('#pills-profile').show();
        });

        $(document).on('click','#pills-home-tab',function(e) {
            $("#modal_aside_right").show();
            $('.modal-backdrop').show();
            $('#pills-home').show();
            $('#pills-document').hide();
            $('#pills-profile').hide();
        });

        $(document).on('click','.viewprofile,.videopush',function(e) {
            @if(!Auth::user())
                $("#loginConfirmModal").modal().show();
                return false
            @endif
            $("#modal_aside_right").modal('show');
            $('.modal-backdrop').show();
            var classbutton = this.id;

            e.preventDefault();
            var currpopup = $(this).attr("data-popup");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:  "{{ url('/search-providerbar') }}",
                "type" : "POST",
                data:{
                  currpopup:currpopup,
                   _token: '{{csrf_token()}}'
                },
                success:function(response){
                    //console.log(response);
                    if(response.success == '1'){
                        $("#modal_aside_right").show();
                        $('.modal-backdrop').show();
                        $('.searchsidemodalId').html(response.html);

                        if(classbutton == 'videobutton'){
                            $(".videoclass").addClass("active");
                            $(".documentclass").removeClass("active");
                            $(".profileclass").removeClass("active");

                            $('#pills-home').hide();
                            $('#pills-profile').tab('show');
                        }
                        else{
                            $(".profileclass").addClass("active");
                            $(".documentclass").removeClass("active");
                            $(".videoclass").removeClass("active");
                            $('#pills-profile').hide();
                            $('#pills-home').show();
                        }

                        $('body').css('overflow', 'hidden');
                    }else {
                        alert('something went wrong, contact support');
                    }
                },
           });
        });

        $(document).on('click','#connectidbtn',function(e) {
            var jobid = $('input[name="jobtitle"]:checked').attr("data-jobid");
            var providerprofileid = $('#profileid').val();
            var profilecat = $('#profilecat').val();
            var providerid = $('#providerid').val();

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });

            $.ajax({
                url:  "{{ url('/setjobpost-connnect') }}",
                "type" : "POST",
                data:{
                  jobid:jobid,
                  profilecat:profilecat,
                  profileid:providerprofileid,
                  providerid:providerid,
                   _token: '{{csrf_token()}}'
                },
                success:function(response){
                    // console.log(response);
                    if(response.success == '1'){
                         window.location = 'user/client/dashboard';
                    }else {
                        alert('something went wrong, contact support');
                    }
                },
           });
        });
        // setCountry('UK');
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
        }else {
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

        if(countryValue == 'United Kingdom'){
            $('#searchCityList').show();
            $('#searchCity').hide().val('');
        }else{
            $('#searchCity').show();
            $('#searchCityList').hide().val('');
            $('#searchPostCode').hide().val('');
        }
    });

    $("#searchCityList").change(function() {
        var cityValue = $('option:selected', this).text();

        if(cityValue == 'London'){
            $('#searchPostCode').show();
        }else{
            $('#searchPostCode').hide().val('');
        }
    });
</script>
@endsection
