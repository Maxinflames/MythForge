<title>MythForge - Account</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">User Details</div>

                        <div class="panel-body">
                            <form class="form-horizontal">

                                <div class="form-group">
                                    <label for="user_profile" class="col-md-5 control-label">Profile Picture</label>
                                    <div class="col-md-6">
                                        <img class="avatar img-rounded" id="user_profile"
                                            src="{{ Storage::url('/images/profile/'.$user->user_profile_picture) }}" alt="Avatar">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_name" class="col-md-5 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input id="user_name" type="text" readonly="true" class="form-control"
                                            name="user_name" value="{{ $user->user_name }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_first_name" class="col-md-5 control-label">First Name</label>

                                    <div class="col-md-6">
                                        <input id="user_first_name" type="text" readonly="true" class="form-control"
                                            name="user_first_name" value="{{ $user->user_first_name }}" value=""
                                            required autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_last_name" class="col-md-5 control-label">Last Name</label>

                                    <div class="col-md-6">
                                        <input id="user_last_name" type="text" readonly="true" class="form-control"
                                            name="user_last_name" value="{{ $user->user_last_name }}" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_email" class="col-md-5 control-label">Email Address</label>

                                    <div class="col-md-6">
                                        <input id="user_email" type="text" readonly="true" class="form-control"
                                            name="user_email" value="{{ $user->user_email_address }}" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_description" class="col-md-5 control-label">User Description</label>

                                    <div class="col-md-6">
                                        <textarea rows="4" id="user_description" readonly="true" type="text" class="form-control" name="user_description"
                                            placeholder="Introduce yourself and your interests!">{{ $user->user_description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="center"><a class="btn btn-primary"
                                            href="/user/edit">Edit</a></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
