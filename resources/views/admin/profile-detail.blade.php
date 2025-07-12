<div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="work-profile-tab" data-toggle="tab" data-target="#work-profile" type="button" role="tab" aria-controls="work-profile" aria-selected="true">Work profile</button>
          <button class="nav-link" id="user-profile-tab" data-toggle="tab" data-target="#user-profile" type="button" role="tab" aria-controls="user-profile" aria-selected="false">User Profile</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="work-profile" role="tabpanel" aria-labelledby="work-profile-tab">
            <div class="row p-3">
                <div class="col-md-6">
                    <div class="mb-2">
                        <strong>Years of Experience : </strong> {{ str_replace(' Year', '', str_replace(' Years', '', $profilePost->experience2)) }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Pay Amount: </strong> {!! config('kinderway.currencySymbols.'.$profilePost->currency)!!}
                        {{  $profilePost->payamount  }} {{ strtolower($profilePost->payfrequency) }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Job Duration : </strong> {{ $profilePost->job_duration }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Job Types : </strong> {{ $allJobTypes }}
                    </div>
        
        
        
                    <div class="mb-2">
                        <strong>Are you comfortable with pets?  </strong> {{ ($profilePost->aid_value==1) ? 'Yes' : 'No' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Do you have a driving license? </strong> {{ ($profilePost->licensevalue==1) ? 'Yes' : 'No' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Do you have a certified qualifications for this category? </strong> {{ ($profilePost->qualificatinosvalue==1) ? 'Yes' : 'No' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Do you have a criminal record check? </strong> {{ ($profilePost->recordvalue==1) ? 'Yes' : 'No' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Do you have a First Aid certificate? </strong> {{ ($profilePost->aid_value==1) ? 'Yes' : 'No' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Do you have references? </strong> {{ ($profilePost->refvalue==1) ? 'Yes' : 'No' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>I Work With : </strong> {{ $allWorkWith }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Education and Work Experience : </strong> {{ $profilePost->edu_description }}
                    </div>
        
                </div>
        
        
                <div class="col-md-6">
                    <div class="mb-2">
                        <strong>Verified : </strong> {{  (isset($profilePost['userdetails']['getVerified']) && ($profilePost['userdetails']['getVerified']['status'] == 1)) ? 'Yes' : 'No'  }}
                        ( {{ ($profilePost['userdetails']['getVerified']['adv_check']??0 == '0') ? 'Standard Check' : 'Advanced Check' }} )
                    </div>
        
                    <div class="mb-2">
                        <strong>Profile Category : </strong> {{ $profilePost['profilecat']['categoryname']??'N/A' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Provider Name : </strong> {{  $profilePost['userdetails']['name']??'N/A' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Provider Name : </strong> {{  $profilePost['userdetails']['name']??'N/A' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Age : </strong> {{  ($profilePost['userdetails']['birth_date']??null) ? (\Carbon\Carbon::parse($profilePost['userdetails']['birth_date'])?->age??'N/A') : 'N/A' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Nationality : </strong> {{  $profilePost['userdetails']['nationality']??'N/A'  }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Country : </strong> {{ $profilePost['userdetails']['country']??'N/A' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>City : </strong> {{ $profilePost['userdetails']['city']??'N/A' }}
                    </div>
        
        
        
                    <div class="mb-2">
                        <strong>Area : </strong> {{ $profilePost['userdetails']['landmark']??'N/A' }}
                    </div>
        
                    @if(($profilePost['userdetails']['postal_code']??'') != '')
                    <div class="mb-2">
                        <strong>Postal Code : </strong> {{ $profilePost['userdetails']['postal_code']??'N/A' }}
                    </div>
                    @endif
        
                    <div class="mb-2">
                        <strong>Languages : </strong> {{ $profilePost['userdetails']['native_language']??'N/A' }}
                    </div>
        
                    <div class="mb-2">
                        <strong>Other Languages : </strong>
                        @if(isset($profilePost['userdetails']['userlanguages']))
                            @foreach($profilePost['userdetails']['userlanguages'] as $key=>$val)
        
                                <div class="row">
                                    <div class="col-md-6 pr-4">
                                        {{ $val['language_name'] }}
                                    </div>
                                    <div class="col-md-6">
                                        -   {{ $val['language_level'] }}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="user-profile" role="tabpanel" aria-labelledby="user-profile-tab">
            <div class="row p-3">
                <div class="col-md-6">
                    <div class="mb-2">
                        <strong>First Name :</strong> {{ $profilePost['userdetails']['name']??'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Last Name :</strong> {{  $profilePost['userdetails']['last_name']??'N/A' }}
                    </div>

                    @if($profilePost['userdetails']['client_type']??'' == 'Business')
                        <div class="mb-2">
                            <strong>Company Name :</strong> {{ $profilePost['userdetails']['company_name']??'N/A' }}
                        </div>
                        <div class="mb-2">
                            <strong>Company Website :</strong> {{ $profilePost['userdetails']['company_website']??'N/A'}}
                        </div>
                    @endif

                    <div class="mb-2">
                        <strong>Email :</strong> {{  $profilePost['userdetails']['email'] }}
                    </div>
                    <div class="mb-2">
                        <strong>User Type :</strong> {{  ( $profilePost['userdetails']['client_type'] != '') ? $profilePost['userdetails']['client_type'] : "Provider"  }}
                    </div>
                    <div class="mb-2">
                        <strong>Phone Code :</strong> {{  $profilePost['userdetails']['phone_code']??'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Phone :</strong> {{  $profilePost['userdetails']['phone']??'N/A'}}
                    </div>
                    <div class="mb-2">
                        <strong>Country :</strong> {{  $profilePost['userdetails']['country']??'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Nationality :</strong> {{  $profilePost['userdetails']['nationality']??'N/A' }}
                    </div>
                    {{--<div class="mb-2">
                        <strong>State :</strong> {{  $user->state }}
                    </div>--}}
                    <div class="mb-2">
                        <strong>City :</strong> {{ $profilePost['userdetails']['city']??'N/A' }}
                    </div>

                    @if($profilePost['userdetails']['postal_code'] != '')
                    <div class="mb-2">
                        <strong>Postal Code :</strong> {{  $profilePost['userdetails']['postal_code']??'N/A' }}
                    </div>
                    @endif

                    <div class="mb-2">
                        <strong>Area :</strong> {{ $profilePost['userdetails']['landmark']??'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Native Language:</strong> {{ $profilePost['userdetails']['native_language']??'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Birth Date:</strong> @if($profilePost['userdetails']['birth_date']) {{ \Carbon\Carbon::parse($profilePost['userdetails']['birth_date'].' 00:00:00')->format('jS M Y') }} @else - @endif
                    </div>
                    {{-- <div class="mb-2">
                        <strong>Job Position:</strong> {{  ($user->job_position != '') ? $user->job_position : "-"  }}
                    </div> --}}
                    <div class="mb-2">
                        <strong>Assigned Admin:</strong> {{  ( $profilePost['userdetails']['assign_user_id'] ) ? $profilePost['userdetails']['assigned']['name'] : "-"  }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-2">
                        <img src="{{ UserHelper::getProfileImage($profilePost['userdetails']['profile_picture']) }}" alt="Profile Picture" width="100" height="100">
                    </div>
                    {{-- <div class="mb-2">
                        <strong>Type :</strong> {{ $user->type }}
                    </div> --}}
                    <div class="mb-2">
                        <strong>Secondary Notification :</strong> {{ ($profilePost['userdetails']['secondary_notifications']  == 1) ? "On" : "Off" }}
                    </div>
                    <div class="mb-2">
                        <strong>Profile Privacy :</strong> {{ ($profilePost['userdetails']['privacy']  == 1) ? "On" : "Off" }}
                    </div>
                    <div class="mb-2">
                        <strong>Email Verification :</strong> {{ ($profilePost['userdetails']['email_verified_at']  != '') ? "Yes" : "No" }}
                    </div>
                    <div class="mb-2">
                        <strong>Account Status :</strong> {{ ($profilePost['userdetails']['is_block']  == 1) ? "Suspended" : "Active" }}
                    </div>
                    <div class="mb-2">
                        <strong>Admin Notes :</strong> {{ $profilePost['userdetails']['admin_notes']??''  }}
                    </div>

                    @if(count($profilePost['userdetails']['userlanguages']) > 0)
                    <div class="mb-2">
                        <strong>Other Lanugages :</strong>

                        @foreach($profilePost['userdetails']['userlanguages'] as $key=>$val)

                            <div class="row">
                                <div class="col-md-12 pr-4">
                                    {{ $val['language_name'] }} :  {{ $val['language_level'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>

        </div>
      </div>

    </div>
