
<h2></h2>
<section>
    <fieldset id="step2_information" class="step_information">
        <div class="inner" style="border-radius: 15px;">
            <div class="form-content">
                <div class="form-header">
                    <h3 class="mt-5 pb-2 title-h3"
                        style="font-weight:bold; font-size: 26px; color: #304384;">New Job
                        Vacancy</h3>
                    <hr class="bold" style="margin: 0.5rem auto;">
                </div>
                <div class="row mt-5 pt-3">
                    <div class="col-lg-12 p-0">
                        <div class="cp-field p-0">
                            <h5>Job Title</h5>
                            <div class="cpp-fiel error-ele">
                                <input type="text" class="form-control" name="jobtitle"
                                        id="jobtitle"
                                        placeholder="'Experienced and caring maternity for our baby girl needed ASAP'"
                                        value="{{$job->jobtitle??''}}"
                                        >
                                <i class="fa fa-pencil"></i>
                            </div>
                        </div>


                        <div class="cp-field p-0">
                            <h5>Position based in</h5>
                            <div class="cpp-fiel error-ele">
                                <select class="form-control js-example-basic-single-general" style="width: 100%" name="job_position"
                                        id="job_position" required>
                                    @foreach([
                                        '' => 'Select Position based in',
                                        'UK' => 'UK',
                                        //'Outside UK' => 'Outside UK (International)',
                                    ] as $key => $value)
                                        <option value="{{$key}}" {{$job?->job_position === $key ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="cp-field col-lg-6 error-ele pad-right-desktop"
                            id="country_id" style="">
                            <h5>Country</h5>
                            <select name="country1" id="country1" class="js-example-basic-single-country" style="width: 100%">
                                <option value="">Select Country Name</option>
                                @foreach($countries AS $key => $value)
                                    <option
                                        value="{{$value->name}}" {{$job?->country === $value->name ? 'selected' : ''}} {{ ('United Kingdom' == $value->name)? 'disabled' : ''}}>{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="cp-field col-lg-6 pad-right-desktop" id="country_id_uk">
                            <h5>Country</h5>
                            <select name="uk_country" id="uk_country" class="js-example-basic-single-country" style="width: 100%">
                                @foreach($countries AS $key => $value)
                                    <option
                                        value="{{$value->name}}" {{$job?->country === $value->name ? 'selected' : ''}} {{ ('United Kingdom' == $value->name)? 'selected' : 'disabled'}} >{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="city_id"
                            class="cp-field col-lg-6 error-ele pad-left-desktop" style="">
                            <h5>City</h5>
                            <span class="citycls">
                                <input type="text" class="form-control" name="city"
                                        id="city" placeholder="Enter City" value="{{$job->city??''}}">
                            </span>
                            <span class="ukcitycls">
                                <select name="ukcity" id="ukcity" class="form-control  js-example-basic-single-city" style="width: 100%">
                                    <option value="">Select City</option>
                                    @foreach($londoncity AS $key => $value)
                                        <option value="{{$value}}" {{$job?->city === $value ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>

                        <div class="cp-field p-0 postalcls" style="padding-right: 20px;">
                            <h5>Postal Code</h5>
                            <div class="cpp-fiel">
                                <select name="postal_code" id="postal_code"
                                        class="form-control js-example-basic-single-postal"
                                        style="width: 100%">
                                    <option value="">Select Postal Code</option>
                                    @foreach($londonpostal AS $key => $value)
                                        <option value="{{$value}}" {{$job?->postalcode === $value ? 'selected' : ''}}>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="cp-field col-lg-12 p-0" style="">
                            <h5>Area</h5>
                            <div class="cpp-fiel error-ele">
                                <input type="text" class="form-control" name="landmark"
                                        id="landmark"
                                        placeholder="e.g. Notting Hill/Manhattan"
                                        value="{{$job->landmark??''}}">
                                <i class="fas fa-landmark"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 mb-4 p-0"
                    style="padding-left:20px; padding-right:20px;">
                    <div class="col-md-12 p-0">
                        <button type="button" onclick="goBack()" class="btn btn-kinderway go-back-2"
                                style="padding: 7px 20px;">Back
                        </button>
                        <button type="button" class="btn btn-kinderway-2 second_nxtbutton"
                                style="float: right; padding: 7px 20px;">Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</section>
