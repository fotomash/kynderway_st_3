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
                        <h3 class="pb-2 title-h3" style="font-weight:bold; font-size: 26px; color: #304384;">Work Profiles</h3>
                        <hr class="bold" />
                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                                <div class="acc-setting">
                                    <div class="cp-field">
                                        <small style="color: #686868;line-height: 1.5rem">Select category to start creating your work profile.
                                            Create separate profiles for different services you provide. Take your time to reflect on your strength as well as your personality. Make a great first impression to enhance your chances of employment.</small>
                                        <div class="form-row four-cols mt-4">
                                            @include('shared.categories-profile', ['arrows' => false, 'active' => 'None', 'tag' => 'a', 'class1' => '', 'class2' => '', 'class3' => 'btn-kinderway-cat'])
                                        </div>
                                    </div>
                                    <div class="cp-field mb-4">
                                        <div class="row">
                                            <div class="col-md-12 p-0">

                                                @foreach($user_profiles as $profile)
                                                    @if(in_array($profile->profilecat->id, $profile_ids))
                                                        <div class="row my-2">
                                                            <div class="col-md-5 p-0" style="display: flex; align-items: center; font-size: 20px;">
                                                                {{ $profile->profilecat->categoryname }}
                                                            </div>
                                                            <div class="col-md-2">
                                                                <a class="btn btn-block btn-warning" href="/provider/service-profiles/{{ $profile->profilecat->slug }}"><span>Edit</span></a>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <a class="btn btn-block btn-success" href="javascript:void(0);" onclick="linkToClipboard('{{ env('APP_URL').'profile/'.$profile->profilecat->slug.'/'.$profile->slug }}');"><span>Copy/Share Link</span></a>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <form method="post" action="{{ url('/provider/'.$profile->id.'/delete-profile') }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-block btn-danger" style="float: right;">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
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
        });
    </script>
@endsection
