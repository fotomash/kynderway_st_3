<ul class="job-tags">
    @foreach($jtypes AS $key => $value)
        <li class="limargin">
            <input type="checkbox" class="setchkbox jchkbox" name="options_jobtype[]"
                   id="checkbox{{$loop->iteration}}_jtype" autocomplete="off" value="{{$value->id}}">
            <a class="shadow">
                <label class="" for="checkbox{{$loop->iteration}}_jtype">
                    {{ $value->jobtype }}</label></a></li>
    @endforeach
</ul>