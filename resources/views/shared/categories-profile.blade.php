<style>
    a > span { padding-top: 0.7rem !important; }
    label > span.glyphicon { padding-top: 1.2rem !important; }
    .image{
        height: 60px;
        width: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cg clip-path='url(%23clip0_518_3565)'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M30 0C13.4531 0 0 13.4531 0 30C0 46.5469 13.4531 60 30 60C46.5469 60 60 46.5469 60 30C60 13.4531 46.5469 0 30 0Z' fill='%2364B47F'/%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M44.5078 19.8867C45.2344 20.6133 45.2344 21.8086 44.5078 22.5352L26.9297 40.1133C26.5664 40.4766 26.0859 40.6641 25.6055 40.6641C25.125 40.6641 24.6445 40.4766 24.2812 40.1133L15.4922 31.3242C14.7656 30.5977 14.7656 29.4023 15.4922 28.6758C16.2187 27.9492 17.4141 27.9492 18.1406 28.6758L25.6055 36.1406L41.8594 19.8867C42.5859 19.1484 43.7812 19.1484 44.5078 19.8867Z' fill='white'/%3E%3C/g%3E%3Cdefs%3E%3CclipPath id='clip0_518_3565'%3E%3Crect width='60' height='60' fill='white'/%3E%3C/clipPath%3E%3C/defs%3E%3C/svg%3E%0A");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        margin-bottom: 20px;
    }
    .introjs-bullets ul{
        display: none;
    }
    .introjs-skipbutton{
        display: none;
    }
</style>


@if(!in_array(1, $profile_ids))
    <div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
        <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Nanny') ? 'active' : '' }}" {{ ($tag == 'a') ? 'href=/provider/service-profiles/nanny' : '' }}>
            <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option2" autocomplete="off" value="1" {{ ($active == 'Nanny') ? 'checked' : '' }}>
            <div class="category-toys"></div>
            <p style="margin:0;">Nanny</p>
        </{{ $tag }}>
    </div>
@endif

@if(!in_array(2, $profile_ids))
    <div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
        <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Maternity') ? 'active' : '' }}" {{ ($tag == 'a') ? 'href=/provider/service-profiles/maternity-nurse' : '' }}>
            <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option3" autocomplete="off" value="2">
            <div class="category-maternity"></div>
            <p style="margin:0;">Maternity</p>
        </{{ $tag }}>
    </div>
@endif

@if(!in_array(5, $profile_ids))
    <div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
        <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Cleaner') ? 'active' : '' }} " {{ ($tag == 'a') ? 'href=/provider/service-profiles/cleaner' : '' }}>
            <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option6" autocomplete="off" value="5">
            <div class="category-cleaner"></div>
            <p style="margin:0;">Cleaner</p>
        </{{ $tag }}>
    </div>
@endif

@if(!in_array(6, $profile_ids))
    <div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
        <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Housekeeper') ? 'active' : '' }} " {{ ($tag == 'a') ? 'href=/provider/service-profiles/housekeeper' : '' }}>
            <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option7" autocomplete="off" value="6">
            <div class="category-housekeeper"></div>
            <p style="margin:0;">Housekeeper</p>
        </{{ $tag }}>
    </div>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

{{--<script>--}}

{{--    // if (!localStorage.getItem('completedIntro')) {--}}

{{--        $.ajax({--}}
{{--            url: '/user/check-new',--}}
{{--            type: 'GET',--}}
{{--            success: function (response) {--}}
{{--                if (response.is_new === 1) {--}}
{{--                    var intro = introJs().setOptions({--}}
{{--                        steps: [{--}}
{{--                            title: null,--}}
{{--                            element: document.querySelector('.card__image'),--}}
{{--                            intro: '<div class="intro-container"><div class="image"></div><h2 >Personal Profile Completed!</h2> </br> <p s>You’re almost there! Its time to create your work profile. Start now! </p> </br> <a id="continue-button"  style="border: 0;padding: 17px 20px;border-radius: 7px;text-align: center;display: block;background-color: #253159; margin: auto;margin-top: 39px;color: white; width: fit-content;" >Continue</a></div>'--}}
{{--                        },--}}

{{--                        ]--}}
{{--                    });--}}

{{--                    intro.start();--}}
{{--                    document.getElementById('continue-button').addEventListener('click', function () {--}}
{{--                        intro.exit();--}}
{{--                    });--}}
{{--                    localStorage.setItem('completedIntro', 'true');--}}

{{--                }--}}
{{--            },--}}
{{--            error: function (error) {--}}
{{--                console.log(error);--}}
{{--            }--}}
{{--        });--}}



{{--</script>--}}
