@if ($errors->any())
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <ul>
            @foreach ($errors->all() as $error)
              <li>{!! $error !!}</li>
            @endforeach
        </ul>
      </div><br />
@endif

@if(Session::has('alert-success'))
	<p class="alert alert-success alert-dismissible mt-3">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! Session::get('alert-success') !!}</p>
@elseif(Session::has('alert-warning'))
	<p class="alert alert-warning alert-dismissible mt-3">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! Session::get('alert-warning') !!}</p>
@elseif(Session::has('alert-danger'))
	<p class="alert alert-danger alert-dismissible mt-3">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! Session::get('alert-danger') !!}</p>
@endif
