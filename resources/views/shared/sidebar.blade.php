<div class="col-lg-3 pad-left-mob">
    <div class="row">
        <div class="col-lg-12 p-0">
            <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Dashboard</h3>
            <hr class="bold" />
        </div>
    </div>

    <div class="user-data full-width shadow">
        <div class="user-profile">
            <div class="username-dt" style="background-image: url('{{ Helper::getProfileImage(Auth::user()->profile_picture) }}'); height:260px; background-size: cover;">
                {{-- <div class="usr-pic">
                    <div class="user-pro-img"> --}}
                        {{-- <img src="/website/images/resources/user-pro-img.png" alt=""> --}}

                        @if(Auth::user()->type == 'service_seeker')

                            <form action="{{ url('/user/client/update_profile_picture') }}" method="POST" id="update_profile_picture_frm" class="" enctype="multipart/form-data">

                        @else

                            <form action="{{ url('/provider/update_profile_picture') }}" method="POST" id="update_profile_picture_frm" class="" enctype="multipart/form-data">

                        @endif

                        {{-- <form action="{{ url('/user/update_profile_picture') }}" method="POST" id="update_profile_picture_frm" class="" enctype="multipart/form-data"> --}}
                            @csrf
                            <div class="add-dp" id="OpenImgUpload">
                                <input type="file" name="profile_picture" id="file" onchange="update_profile_picture(this);" accept="image/*" >
                                <label for="file"><i class="fas fa-upload"></i></label>
                            </div>
                        </form>
                    {{-- </div>
                </div> --}}
            </div>
            <div class="user-specs">
                <h3>{{ Str::limit(Auth::user()->name, 18) }}</h3>
                @if(Auth::user()->city && Auth::user()->country)
                    <span>{{ Str::limit(Auth::user()->city . ', ' .Auth::user()->country, 35) }}</span>
                @else

                @endif
            </div>
        </div>
        <ul class="user-fw-status">
        </ul>
    </div>

    @if(Auth::user()->type == 'service_seeker')

        <div class="acc-leftbar shadow">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link @if($active == 'dashboard') active  @endif" id="nav-acc-tab" href="/user/client/dashboard" @if($active == "dashboard") aria-selected="true" @else aria-selected="false" @endif><i class="fas fa-tachometer-alt"></i>My Dashboard</a>
                <a class="nav-item nav-link @if($active == 'manage-profile') active  @endif" id="security" href="/user/client/manage-profile" @if($active == "manage-profile") aria-selected="true" @else aria-selected="false" @endif><i class="fas fa-user-alt"></i>Personal Profile</a>
                <a class="nav-item nav-link @if($active == 'manage-account') active  @endif" id="nav-manage-account" href="/user/client/manage-account" @if($active == "manage-account") aria-selected="true" @else aria-selected="false" @endif><i class="fa fa-lock"></i>Manage Account</a>
            </div>
        </div>

    @else

        <div class="acc-leftbar shadow">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link @if($active == 'dashboard') active  @endif" id="nav-acc-tab" href="/provider/dashboard" @if($active == "dashboard") aria-selected="true" @else aria-selected="false" @endif><i class="fas fa-tachometer-alt"></i>My Dashboard</a>
                <a class="nav-item nav-link @if($active == 'manage-profile') active  @endif" id="security" href="/provider/manage-profile" @if($active == "manage-profile") aria-selected="true" @else aria-selected="false" @endif><i class="fas fa-user-alt"></i>Personal Profile</a>
                <a class="nav-item nav-link @if($active == 'video-intro') active  @endif" id="nav-video" href="/provider/video-intro" @if($active == "video-intro") aria-selected="true" @else aria-selected="false" @endif><i class="fas fa-video"></i>Video Intro</a>
                <a class="nav-item nav-link @if($active == 'service-profiles') active  @endif" id="profiles" href="/provider/service-profiles" @if($active == "service-profiles") aria-selected="true" @else aria-selected="false" @endif><i class="fas fa-users"></i>Work Profiles</a>
                <a class="nav-item nav-link @if($active == 'manage-account') active  @endif" id="nav-manage-account" href="/provider/manage-account" @if($active == "manage-account") aria-selected="true" @else aria-selected="false" @endif><i class="fa fa-lock"></i>Manage Account</a>
                <a class="nav-item nav-link @if($active == 'manage-documents') active  @endif" id="nav-manage-documents" href="/provider/manage-documents" @if($active == "manage-documents") aria-selected="true" @else aria-selected="false" @endif><i class="fa fa-file"></i>Manage Documents</a>
                <a class="nav-item nav-link @if($active == 'get-verified') active  @endif" id="nav-get-verified" href="/provider/get-verified" @if($active == "get-verified") aria-selected="true" @else aria-selected="false" @endif><i class="fas fa-user-check"></i>Get Verified</a>
            </div>
        </div>

    @endif

</div>
<script>


    function update_profile_picture(that){
        $(that).hide();
        $('form[id="update_profile_picture_frm"]').submit();
    }
</script>
