<style>
    a > span { padding-top: 0.7rem !important; }
    label > span.glyphicon { padding-top: 1.2rem !important; }
</style>

<div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
    <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Nanny') ? 'active' : '' }}" {{ ($tag == 'a') ? 'href=/provider/service-profiles/nanny' : '' }}>
        <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option2" autocomplete="off" value="1" {{ ($active == 'Nanny') ? 'checked' : '' }}>
        <div class="category-toys"></div>
        <p style="margin:0;">Nanny</p>
    </{{ $tag }}>
</div>

<div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
    <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Maternity') ? 'active' : '' }}" {{ ($tag == 'a') ? 'href=/provider/service-profiles/maternity-nurse' : '' }}>
        <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option3" autocomplete="off" value="2">
        <div class="category-maternity"></div>
        <p style="margin:0;">Maternity</p>
    </{{ $tag }}>
</div>

{{--
<div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
    <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Cleaner') ? 'active' : '' }} " {{ ($tag == 'a') ? 'href=/provider/service-profiles/cleaner' : '' }}>
        <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option6" autocomplete="off" value="5">
        <div class="category-cleaner"></div>
        <p style="margin:0;">Cleaner</p>
    </{{ $tag }}>
</div>

<div class="col-md-1 col-6 mb-3 text-center {{ $class2 }} pad-left-mob">
    <{{ $tag }} class="btn {{ $class3 }} shadow {{ ($active == 'Housekeeper') ? 'active' : '' }} " {{ ($tag == 'a') ? 'href=/provider/service-profiles/housekeeper' : '' }}>
        <input class="form-check-input setprofiletype_radio" type="radio" name="options" id="option7" autocomplete="off" value="6">
        <div class="category-housekeeper"></div>
        <p style="margin:0;">Housekeeper</p>
    </{{ $tag }}>
</div>
--}}