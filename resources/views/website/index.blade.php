@extends('layouts.master_website')

@section('css')
    <link rel="stylesheet"
          href="/website/form-wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <link rel="stylesheet" href="/website/form-wizard/css/style.css">
    <style>
        .modal .modal-dialog-aside {
            width: 800px;
            max-width: 100%;
            height: 100%;
            margin: 0;
            transform: translate(0);
            transition: transform .2s;
        }

        .modal .modal-dialog-aside .modal-content {
            height: inherit;
            border: 0;
            border-radius: 0;
        }

        .modal .modal-dialog-aside .modal-content .modal-body {
            overflow-y: auto
        }

        .modal.fixed-left .modal-dialog-aside {
            margin-left: auto;
            transform: translateX(100%);
        }

        .modal.fixed-right .modal-dialog-aside {
            margin-right: auto;
            transform: translateX(-100%);
        }

        .modal.show .modal-dialog-aside {
            transform: translateX(0);
        }
    </style>
@endsection

@section('content')


@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection