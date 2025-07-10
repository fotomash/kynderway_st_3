@if ($errors->any())
<div class="alert alert-danger alert-dismissible mt-3">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{!! $error !!}</li>
        @endforeach
    </ul>
</div>
@endif

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible mt-3">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! Session::get('success') !!}
</div>
@elseif(Session::has('warning'))
<div class="alert alert-warning alert-dismissible mt-3">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! Session::get('warning') !!}
</div>
@elseif(Session::has('danger'))
<div class="alert alert-danger alert-dismissible mt-3">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {!! Session::get('danger') !!}
</div>
@endif