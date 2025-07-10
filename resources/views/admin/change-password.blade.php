@extends('layouts.master_admin')

@section('title')
    Change Password
@endsection

@section('change-password')
    active
@endsection

@section('css')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-content block-content-full">
                    <form class="js-validation-change-password" method="POST" action="change-password">
                        @csrf
                        <div class="row items-push">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="val-old-password">Old Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="val-old-password" name="old_password">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="val-new-password">New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="val-new-password" name="new_password">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="val-confirm-password">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="val-confirm-password" name="confirm_password">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('assets/js/pages/be_forms_change_password.min.js') }}"></script>
@endsection
