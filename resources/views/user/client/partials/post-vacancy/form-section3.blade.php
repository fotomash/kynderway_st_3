<h2></h2>
<section>
    <fieldset id="step3_information" class="step_information">
        <div class="inner" style="border-radius: 15px;">
            <div class="form-content">
                <div class="form-header">
                    <h3 class="mt-5 pb-2"
                        style="font-weight:bold; font-size: 26px; color: #304384;">New Job
                        Vacancy</h3>
                    <hr class="bold" style="margin: 0.5rem auto;">
                </div>

                <div class="row mt-5 pt-3">
                    <div class="col-lg-12 p-0">

                        <div class="cp-field p-0">
                            <h5>Job Duration</h5>
                            <div class="cpp-fiel error-ele">
                                <select class="form-control" name="duration" id="duration" required style="-webkit-appearance: menulist-button;">
                                    @foreach([
                                            '' => 'Select Job Duration',
                                            'Permanent' => 'Permanent',
                                            'Temporary' => 'Temporary'
                                    ] as $key => $value)
                                        <option value="{{$key}}" {{$job?->jobduration === $key ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="cp-field p-0 error-ele">
                            <h5 class="mb-0">Task Required for this Position</h5>
                            <div class="cpp-fiel mt-3 error-ele positionID">
                            </div>
                        </div>
                        <div class="cp-field p-0">
                            <h5 class="mb-0">This position will involve working with</h5>
                            <div class="cpp-fiel mt-3 workwithID error-ele">
                            </div>
                        </div>
                        <div class="cp-field col-lg-6 pad-right-desktop" style="">
                            <h5>Required Languages</h5>
                            <div class="cpp-fiel error-ele">
                                <select class="js-example-basic-multiple"
                                        multiple="multiple" name="req_language[]"
                                        id="req_language" placeholder="required languages"
                                        style="width: 100%">
                                    <option value="">Select Required Languages</option>
                                    @foreach($languages AS $language)
                                        <option value="{{$language}}" {{in_array($language,explode(',',$job->req_language??''))? 'selected' : ''}}>{{$language}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                         
                        <div class="cp-field col-lg-6 pad-left-desktop" style="">
                            <h5>Additional Languages (Optional)</h5>
                            <div class="cpp-fiel error-ele">
                                <select class="js-example-basic-multiple"
                                        multiple="multiple" name="preffered_lang[]"
                                        id="preffered_lang" style="width: 100%">
                                    <option value="">Select Additional Languages</option>
                                    @foreach($languages AS $language)
                                        <option value="{{$language}}" {{in_array($language,explode(',',$job?->pref_language??'')) ? 'selected' : ''}}>{{$language}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="cp-field p-0">
                            <h5>Start Date</h5>
                            <p class="info">Please select the preferred start date or ASAP, as
                                per your requirement</p>

                            <div class="form-check-date">
                                <input class="form-check-input date-selector" type="radio" name="date" id="date-selector-asap" value="asap" checked>
                                <label class="form-check-label" for="date-selector-asap">
                                    ASAP (As Soon As Possible)
                                </label>
                            </div>
                            <div class="form-check-date">
                                <input class="form-check-input date-selector" type="radio" name="date" id="date-selector-calendar" value="calendar">
                                <label class="form-check-label" for="date-selector-calendar">
                                    Select a preferred start date
                                </label>
                            </div>
                            <div class="cpp-fiel --calendar col-md-6">
                                <input type="text" class="cpp-fiel mt-2" id="input-calendar" readonly />
                                <div id="calendar"></div>
                            </div>
                        </div>

                        <div class="cp-field p-0">
                            <h5 class="info">Pay Amount</h5>

                            <div class="form-check-date">
                                <input class="form-check-input money-selector" type="radio" name="paymentOption" id="money-selector-negotiable" value="negotiable" checked>
                                <label class="form-check-label" for="money-selector-negotiable">
                                    To be discussed / Negotiable
                                </label>
                            </div>
                            <div class="form-check-date">
                                <input class="form-check-input money-selector" type="radio" name="paymentOption" id="money-selector-amount" value="fix">
                                <label class="form-check-label" for="money-selector-amount">
                                    Select a preferred amount range
                                </label>
                            </div>
                        </div>

                        <div class="cp-field col-md-6 price-group">
                            <div class="cp-field col-lg-12 p-0 hide-on-negotiable" style="display:flex; justify-content: center;">
                                <p >Select Currency</p>
                                <select class="form-control" id="paycurrency" name="paycurrency" style="-webkit-appearance: menulist-button;">
                                    @foreach([
                                            '' => 'Select',
                                            'GBP' => 'GBP',
                                            'EUR' => 'EUR',
                                            'USD' => 'USD',
                                    ] as $key => $value)
                                        <option value="{{$key}}" {{$job?->payamountcurrency === $key ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="cp-field col-lg-12 p-0 hide-on-negotiable" style="display:flex; justify-content: center;">
                                <p>Amount From</p>
                                <div class="error-ele p-0">
                                    <div class="input-group p-0">
                                        <input type="text" name="payamountfrom" id="payamountfrom"
                                            class="form-control allownumericwithdecimal"
                                            placeholder="0.00"
                                            value="{{$job?->payamount_from}}"
                                            >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id=""><i
                                                    class="fa fa-chevron-right"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" name="payamountto" id="payamountto"
                                            class="form-control allownumericwithdecimal"
                                            placeholder="0.00"
                                            value="{{$job?->payamount_to}}"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="cp-field col-lg-12 p-0 hide-on-negotiable" style="display:flex; justify-content: center;">
                                <p>Select Pay Frequency</p>
                                <select class="form-control" name="frequency" id="frequency" style="-webkit-appearance: menulist-button;">
                                    @foreach([
                                        '' => 'Select',
                                        'Per Hour' => 'Per Hour',
                                        'Per Day' => 'Per Day',
                                        'Per Night' => 'Per Night',
                                        'Per Week' => 'Per Week',
                                        'Per Month' => 'Per Month',
                                        'Per Year' => 'Per Year'
                                ] as $key => $value)
                                    <option value="{{$key}}" {{$job?->payfrequency === $key ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="cp-field col-lg-12 p-0" style="">
                            <h5>Hours Per Week</h5>
                            <div class="cpp-fiel error-ele">
                                <select class="form-control" name="hrsperweek"
                                        id="hrsperweek"
                                        style="-webkit-appearance: menulist-button;">
                                        @foreach([
                                            '' => 'Select Hours',
                                            '1 Hour' => '1 Hour',
                                            '2 Hours' => '2 Hours',
                                            '3 Hours' => '3 Hours',
                                            '4 Hours' => '4 Hours',
                                            '5 Hours' => '5 Hours',
                                            '6 Hours' => '6 Hours',
                                            '7 Hours' => '7 Hours',
                                            '8 Hours' => '8 Hours',
                                            '9 Hours' => '9 Hours',
                                            '10 Hours' => '10 Hours',
                                            '11 Hours' => '11 Hours',
                                            '12 Hours' => '12 Hours',
                                            '13 Hours' => '13 Hours',
                                            '14 Hours' => '14 Hours',
                                            '15 Hours' => '15 Hours',
                                            '16 Hours' => '16 Hours',
                                            '17 Hours' => '17 Hours',
                                            '18 Hours' => '18 Hours',
                                            '19 Hours' => '19 Hours',
                                            '20 Hours' => '20 Hours',
                                            '21-30 Hours' => '21-30 Hours',
                                            '31-40 Hours' => '31-40 Hours',
                                            '41-50 Hours' => '41-50 Hours',
                                            '50+ Hours' => '50+ Hours'
                                    ] as $key => $value)
                                        <option value="{{$key}}" {{$job?->hoursperweek === $key ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="cp-field p-0">
                            <h5 class="mb-3">Work Schedule</h5>
                            <div class="cpp-fiel error-ele">
                                <textarea row="5" name="workschedule" id="workschedule" placeholder="Please specify required days and hours" style="white-space: pre-wrap;">{{$job?->workschedule??''}}</textarea>
                            </div>
                        </div>

                        <div class="cp-field p-0">
                            <h5>Extra Details About Job</h5>
                            <div class="cpp-fiel error-ele">
                                <textarea row="5" name="job_details" id="job_details" placeholder="Tell us more about your requirements" style="white-space: pre-wrap;">{{$job?->job_details??''}}</textarea>
                                <i class="fa fa-pencil"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" value="{{$job?->marketing??''}}" name="marketing_custom" id="marketing_custom">
                <div class="row mt-5 mb-4 p-0"
                    style="padding-left:20px; padding-right:20px;">
                    <div class="col-md-12 p-0">
                        <button type="button" onclick="goBack()" class="btn btn-kinderway go-back-3"
                                style="padding: 7px 20px;">Back
                        </button>
                        <button type="button" class="btn btn-kinderway-2 ml-3 third_savebtn"
                                name="postbutton" id="postbutton"
                                style="float: right; padding: 7px 20px;">Preview Job
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</section>