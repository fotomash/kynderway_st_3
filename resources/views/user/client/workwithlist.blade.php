<ul class="job-tags">
    @foreach($specialities AS $key => $value)
        <li class="limargin">
            <input type="checkbox" class="setchkbox workchkbox" name="options_outlined[]"
                   id="checkbox{{$loop->iteration}}-outlined" autocomplete="off" value="{{$value->id}}">
            <a class="shadow">
                <label class="" for="checkbox{{$loop->iteration}}-outlined">
                    {{ $value->name }}</label></a></li>
    @endforeach
</ul>