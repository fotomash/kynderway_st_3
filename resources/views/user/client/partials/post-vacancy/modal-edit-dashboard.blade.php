          <div class="row mb-4">
            <div class="col-12">
                {{-- <h3 class="title-h3">You are about to submit this job.</h3>
                <h3 class="title-h3">Please review the details before submitting</h3> --}}
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12" style="border:  1px solid #ecedf3;padding: 0;border-radius: 1rem;">
                <div class="edit-header mb-4"><a href="#" class='goto-edit' data-target='0'>Back to edit <i class="ml-1 fa fa-pencil"></i></a></h3></div>
                <div class="row mt-4 mb-2">
                  <div class="col-3">Category</div>
                  <div class="col-9 edit-preview" data-type='category'>{{$categoryname}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Type</div>
                  <div class="col-9 edit-preview" data-type='type'>{{ implode(', ',
                    array_map(function($item) use ($types){
                      foreach($types as $exp){
                        if($item == $exp->id) return $exp->jobtype;
                      }
                    },explode(',',$job?->jobtypes))) }}</div>
                </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12" style="border:  1px solid #ecedf3;padding: 0;border-radius: 1rem;">
                <div class="edit-header mb-4"><a href="#" class='goto-edit' data-target='1'>Back to edit <i class="ml-1 fa fa-pencil"></i></a></h3></div>
                <div class="row mt-4 mb-2">
                  <div class="col-3">Job Title</div>
                  <div class="col-9 edit-preview" data-type='job-title'>{{$job->jobtitle??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Position based in</div>
                  <div class="col-9 edit-preview" data-type='based-in'>{{$job?->job_position??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Country</div>
                  <div class="col-9 edit-preview" data-type='country'>{{$job?->country??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">City</div>
                  <div class="col-9 edit-preview" data-type='city'>{{$job?->city??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Postal Code</div>
                  <div class="col-9 edit-preview" data-type='postal-code'>{{$job?->postalcode??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Area</div>
                  <div class="col-9 edit-preview" data-type='area'>{{$job->landmark??'--'}}</div>
                </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12" style="border:  1px solid #ecedf3;padding: 0;border-radius: 1rem;">
                <div class="edit-header mb-4"><a href="#" class='goto-edit' data-target='2'>Back to edit <i class="ml-1 fa fa-pencil"></i></a></h3></div>
                <div class="row mt-4 mb-2">
                  <div class="col-3">Job Duration</div>
                  <div class="col-9 edit-preview" data-type='job-duration'>{{$job?->jobduration??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Task Required for this Position</div>
                  <div class="col-9 edit-preview" data-type='task'>
                    {{ implode(', ',
                    array_map(function($item) use ($experiences){
                      foreach($experiences as $exp){
                        if($item == $exp->id) return $exp->exp_name;
                      }
                    },explode(',',$job?->position))) }}
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">This position will involve working with</div>
                  <div class="col-9 edit-preview" data-type='position'>
                    {{ implode(', ',
                    array_map(function($item)  use ($specialities){
                      foreach($specialities as $exp){
                        if($item == $exp->id) return $exp->name;
                      }
                    },explode(',',$job?->workwith))) }}
                  </div>
                </div>
                {{-- let positions = "{{ $job?->position }}".split(',');
                            positions.forEach(val => {
                                $('form[id="wizard"] input[name="options_exp[]"][value="' +
                                    val + '"]').click();
                            });
                        let workwith = "{{ $job?->workwith }}".split(',');
                        workwith.forEach(val => {
                            $('form[id="wizard"] input[name="options_outlined[]"][value="' +
                                val + '"]').click();

                                 --}}
                <div class="row mb-2">
                  <div class="col-3">Required Languages</div>
                  <div class="col-9 edit-preview" data-type='languages-req'>{{$job?->req_language??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Additional Languages (Optional)</div>
                  <div class="col-9 edit-preview" data-type='languages-pref'>{{$job?->pref_language??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Start Date</div>
                  <div class="col-9 edit-preview" data-type='start'>
                    @if ($job?->asap === 'asap')
                      ASAP (As Soon As Possible)
                    @else
                      {{$job?->start_date??'--'}}
                    @endif
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Pay Amount</div>
                  <div class="col-9 edit-preview" data-type='pay'>
                    @if ($job?->paymentOption === 'negotiable')
                    To be discussed / Negotiable
                    @else
                    {{$job?->payamountcurrency??''}} {{$job?->payamount_from??''}} - {{$job?->payamountcurrency??''}} {{$job?->payamount_to??''}} {{$job?->payfrequency??''}}
                    @endif
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Hours Per Week</div>
                  <div class="col-9 edit-preview" data-type='hours'>{{$job?->hoursperweek??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Work Schedule</div>
                  <div class="col-9 edit-preview" data-type='schedule'>{{$job?->workschedule??'--'}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Extra Details About Job</div>
                  <div class="col-9 edit-preview" data-type='extra'>{{$job?->job_details??'--'}}</div>
                </div>
            </div>
          </div>

          {{-- <div class="cp-field p-0 terms">
            <div class="cpp-fiel error-ele mb-2 mt-2">
                <input type="checkbox" value="1" id="marketing" style="width: auto; height: auto;">
                <label for="marketing">
                    Boost your post to reach the maximum number of candidates that might be interested in your job offer. <span style="color: #007bff; cursor: pointer;" id="marketing-learn-more">Learn more</span>
                </label>
            </div>
            <div class="cpp-fiel error-ele mb-2">
                <input type="checkbox" value="1" name="terms1" id="terms1" style="width: auto; height: auto;">
                <label for="terms1">
                    My post does not violate Kynderway's <a target="_blank" href="https://kynderway.com/terms" class="link-on-hover-blue" target="_blank">Terms of Service</a> including the requirement to be non-discriminatory.
                </label>
                <label class="terms1-error error d-none" for="terms1">This term a is mandate to proceed with the job post</label>
            </div>
            <div class="cpp-fiel error-ele">
                <input type="checkbox" value="1" name="terms2" id="terms2" style="width: auto; height: auto;">
                <label for="terms2">
                    I confirm that my Job Posting does not contain any personal or business contact information. <span style="color: #007bff; cursor: pointer;" id="privacy-learn-more">Learn more</span>
                </label>
                <label class="terms2-error error d-none" for="terms2">This term a is mandate to proceed with the job post</label>
            </div>
          </div> --}}