<h2></h2>
<section class="">
    <div class="inner" style="border-radius: 15px;">
        <div class="form-content" style="padding-bottom: 0;">
            <div class="form-header">
                <h3 class="mt-5 pb-2 title-h3"
                    style="font-weight:bold; font-size: 26px; color: #304384;">New Job
                    Vacancy</h3>
                <hr class="bold" style="margin: 0.5rem auto;">
            </div>
            <p class="text-center mb-4 mt-5 pt-5">Start by selecting a category below</p>

            <fieldset id="step1_information" class="step_information">
                <div class="" data-toggle="buttons">
                    <div class="row  four-cols">
                        @include('shared.categories', ['arrows' => false, 'active' => 'All', 'tag' => 'label', 'class1' => '', 'class2' => '', 'class3' => 'form-check-label btn-kinderway-cat'])
                    </div>
                </div>

                <div class="form-row mt-5">
                    <div class="col-lg-12 error-ele" id="JobTypeID">
                    </div>
                </div>
            </fieldset>
            <div class="row mb-4 p-0" style="padding-left:20px; padding-right:20px;">
                <div class="col-md-12 p-0">
                    <a href="javascript:void(0)" class="btn btn-kinderway-2 first_nxtbutton"
                        style="float: right; padding: 7px 20px;">Next</a>
                </div>
            </div>
        </div>
    </div>
</section>
