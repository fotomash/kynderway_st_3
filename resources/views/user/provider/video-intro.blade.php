@extends('layouts.master_user')

@section('css')
    <style>

    </style>
@endsection

@section('content')

    <section class="profile-account-setting">
        <div class="container">
            <div class="account-tabs-setting">
                <div class="row mb-4">
                </div>

                <div class="row">
                    @include('shared.sidebar', ['active' => 'video-intro'])
                    <div class="col-lg-9 pad-right-mob">
                        <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Video Intro</h3>
                        <hr class="bold" />
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="nav-password" role="tabpanel"
                                 aria-labelledby="nav-password-tab">
                                <div class="acc-setting">
                                    <form method="POST" id="video_frm" action="{{ url('/provider/add-videointro') }}"
                                          class="" enctype="multipart/form-data">
                                        @csrf

                                        <div class="cp-field">
                                            <h5>Upload Video (max 100MB file)</h5>
                                            <div class="cpp-fiel error-ele mb-5">
                                                <input type="file" id="video_file" name="video_file"
                                                       style="padding-top:8px;" value="" placeholder="Upload Video">
                                                <i class="fas fa-video"></i>
                                            </div>

                                            @if($totVideoUploaded > 0)
                                                @foreach($currentVideoId as $key => $val)
                                                    <h5>Currently Uploaded Video</h5>
                                                    <video width="100%" controls>
                                                        <source src="{{ url('storage/'. $val->videofile) }}"
                                                                type="{{ $val->filetype }}"/>
                                                    </video>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="save-stngs pd2">
                                            <button type="submit" class="btn btn-kinderway" style="float: right;">
                                                Upload
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
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            if ($("#video_frm").length) {
                $("#video_frm").validate({
                    errorPlacement: function ($error, $element) {
                        $error.appendTo($element.closest("div.error-ele"));
                    },
                    rules: {
                        video_file: {
                            required: true,
                            extension: 'ogg|ogv|avi|mpeg|mov|wmv|flv|mp4'
                        },
                    },
                    messages: {
                        'video_file': {
                            required: "Please select video",
                            extension: "Only ogg,ogv,avi,mpeg,mov,wmv,flv,mp4 file type is allowed"
                        },
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            }
        });
    </script>
@endsection
