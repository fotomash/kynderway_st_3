@extends('layouts.master_website')

@section('css')

    <link rel="stylesheet"
          href="/website/form-wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">

@endsection

@section('content')


<main class="seearch">
    <div class="main-section">
        <div class="container">
            <div class="main-section-data text-center">

                @if(Request::get('url') != null )
                <iframe src="https://docs.google.com/gview?url={{env('APP_URL')}}storage/provider_document/{{ Request::get('url') }}&embedded=true" style="border:0px #ffffff none;" height="600px"  width="100%" allowfullscreen>
                </iframe>

                @endif
{{--                <iframe src="/storage/provider_document/{{ Request::get('url') }}#toolbar=0" style="width: 100%; height: 700px; min-height: 100%;"></iframe>--}}

{{--                <a target="_blank" class="btn btn-success mt-2 px-4" href="/storage/provider_document/{{ Request::get('url') }}" download>Download</a>--}}
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')

@endsection
