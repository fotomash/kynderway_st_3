@extends('layouts.master_admin')

@section('title')
    Message History - {{ $data['jobtitle'] }}
@endsection

@section('messages')
    active
@endsection

@section('css')
    <style>
        /*/////////////////////////////////*/
        /*/////////  chat styles  /////////*/
        /*/////////////////////////////////*/

        .scrollClass {
            /* height:calc(100vh - 500px); */
            overflow-y: scroll;
            background-color: #eee;
        }

        .chat {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .chat li {
            /*margin-bottom: 40px;*/
            padding-bottom: 5px;
            margin-top: 10px;
            /* width: 80%; */
            width: 55%;
        }

        .chat li .chat-body p {
            margin: 0;
        }

        .chat-care {
            /*overflow-y: scroll;
            height: 50px;*/
        }

        .chat-care .chat-img {
            width: 50px;
            /* height: 50px;*/
        }

        .chat-care .img-circle {
            border-radius: 50%;
        }

        .chat-care .chat-img {
            display: inline-block;
        }

        .chat-care .chat-body {
            /*  display: inline-block;*/
            /* max-width: 80%;*/

            border-radius: 12.5px;
            padding: 15px;
        }

        .chat-care .chat-body strong {
            color: #0169DA;
        }

        .chat-care .admin {
            background-color: #f5e4fb;
            text-align: right;
            float: right;
        }

        .chat-care .admin p {
            text-align: left;
        }

        .chat-care .agent {
            background-color: #fff;
            text-align: left;
            float: left;
        }

        .chat-care .left {
            float: left;
        }

        .chat-care .right {
            float: right;
        }

        .clearfix {
            clear: both;
        }

        .block-content {
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        {{-- <div class="col-lg-12 p-0">
            <h2 class="text-center">{{ $messageDetails[0]->jobtitle ?? '' }}</h2>
        </div> --}}
        <div class="col-lg-12 p-0">
                <div id="messageSection" class="block-content block-content-full scrollClass">
                    @foreach($messageDetails as $messageDetail)
                        <div class="col-md-12 mx-auto">
                            <div class="card">
                                <div class="card-body chat-care">
                                    <ul class="chat">

                                           {{--Check if provider--}}
                                        @if($data[$messageDetail->from_id]['settype'] == 'service_provider')
                                        <li class="agent clearfix">
                                            <div class="chat-body clearfix">
                                                <div class="header clearfix">
                                                    <strong class="primary-font">{{ $data[$messageDetail->from_id]['providername'] }}</strong>
                                                </div>
                                                <p>
                                                    {{ $messageDetail->body }}
                                                </p>
                                            </div>
                                        </li>
                                    @else
                                        <li class="admin clearfix">
                                            <div class="chat-body clearfix">
                                                <div class="header clearfix">
                                                    <strong class="right primary-font">{{ $data[$messageDetail->from_id]['postername'] }}</strong>
                                                </div>
                                                <p>
                                                    {{ $messageDetail->body }}
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var element = $('#messageSection')[0];
        element.scrollTop = element.scrollHeight - element.clientHeight;
        var h = window.innerHeight;
        // console.log("HEIGHT", h);
        // setTimeout(function() {
            $("div.scrollClass").css({
                "height":"calc(100vh - " + "350px)"
            });
        // }, 2000);
    </script>
@endsection
