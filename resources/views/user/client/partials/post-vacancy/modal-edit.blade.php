<div class="modal fade post-vacancy-edit-modal" id="post-vacancy-edit" tabindex="-1" role="dialog" aria-labelledby="post-vacancy-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4">
          <div class="row mb-4">
            <div class="col-12">
                <h3 class="title-h3">You are about to submit this job.</h3>
                <h3 class="title-h3">Please review the details before submitting</h3>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12" style="border:  1px solid #ecedf3;padding: 0;border-radius: 1rem;">
                <div class="edit-header mb-4"><a href="#" class='goto-edit' data-target='0'>Back to edit <i class="ml-1 fa fa-pencil"></i></a></h3></div>
                <div class="row mt-4 mb-2">
                  <div class="col-3">Category</div>
                  <div class="col-9 edit-preview" data-type='category'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Type</div>
                  <div class="col-9 edit-preview" data-type='type'>--</div>
                </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12" style="border:  1px solid #ecedf3;padding: 0;border-radius: 1rem;">
                <div class="edit-header mb-4"><a href="#" class='goto-edit' data-target='1'>Back to edit <i class="ml-1 fa fa-pencil"></i></a></h3></div>
                <div class="row mt-4 mb-2">
                  <div class="col-3">Job Title</div>
                  <div class="col-9 edit-preview" data-type='job-title'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Position based in</div>
                  <div class="col-9 edit-preview" data-type='based-in'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Country</div>
                  <div class="col-9 edit-preview" data-type='country'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">City</div>
                  <div class="col-9 edit-preview" data-type='city'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Postal Code</div>
                  <div class="col-9 edit-preview" data-type='postal-code'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Area</div>
                  <div class="col-9 edit-preview" data-type='area'>--</div>
                </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-12" style="border:  1px solid #ecedf3;padding: 0;border-radius: 1rem;">
                <div class="edit-header mb-4"><a href="#" class='goto-edit' data-target='2'>Back to edit <i class="ml-1 fa fa-pencil"></i></a></h3></div>
                <div class="row mt-4 mb-2">
                  <div class="col-3">Job Duration</div>
                  <div class="col-9 edit-preview" data-type='job-duration'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Task Required for this Position</div>
                  <div class="col-9 edit-preview" data-type='task'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">This position will involve working with</div>
                  <div class="col-9 edit-preview" data-type='position'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Required Languages</div>
                  <div class="col-9 edit-preview" data-type='languages-req'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Additional Languages (Optional)</div>
                  <div class="col-9 edit-preview" data-type='languages-pref'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Start Date</div>
                  <div class="col-9 edit-preview" data-type='start'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Pay Amount</div>
                  <div class="col-9 edit-preview" data-type='pay'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Hours Per Week</div>
                  <div class="col-9 edit-preview" data-type='hours'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Work Schedule</div>
                  <div class="col-9 edit-preview" data-type='schedule'>--</div>
                </div>
                <div class="row mb-2">
                  <div class="col-3">Extra Details About Job</div>
                  <div class="col-9 edit-preview" data-type='extra'>--</div>
                </div>
            </div>
          </div>

          <div class="cp-field p-0 terms">
            {{--
            <div class="cpp-fiel error-ele mb-2 mt-2">
                <input type="checkbox" value="1" id="marketing" style="width: auto; height: auto;" @if($job?->marketing) checked @endif>
                <label for="marketing">
                    Boost your post to reach the maximum number of candidates that might be interested in your job offer. <span style="color: #007bff; cursor: pointer;" id="marketing-learn-more">Learn more</span>
                </label>
            </div>
            --}}
            <div class="cpp-fiel error-ele mb-2">
                <input type="checkbox" value="1" name="terms1" id="terms1" style="width: auto; height: auto;">
                <label for="terms1" style="cursor: pointer;">
                  My post does not violate Kynderway's
                </label>
                <a target="_blank" href="https://kynderway.com/terms" class="link-on-hover-blue" target="_blank">Terms of Service</a>
                <label for="terms1" style="cursor: pointer;">
                  including the requirement to be non-discriminatory.
                </label>
                <label class="terms1-error error d-none" for="terms1">This term a is mandate to proceed with the job post</label>
            </div>
            <div class="cpp-fiel error-ele">
                <input type="checkbox" value="1" name="terms2" id="terms2" style="width: auto; height: auto;">
                <label for="terms2" style="cursor: pointer;">
                    I confirm that my Job Posting does not contain any personal or business contact information.
                </label>
                <span style="color: #007bff; cursor: pointer;" id="privacy-learn-more">Learn more</span>
                <label class="terms2-error error d-none" for="terms2">This term a is mandate to proceed with the job post</label>
            </div>
        </div>
        </div>
        <div class="modal-footer">
          <button id="submit-edit-form" type="button" class="btn btn-kinderway-2">Post Now</button>
        </div>
      </div>
    </div>
</div>