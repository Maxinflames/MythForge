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
                            <form class="form-horizontal" method="POST" action="/user/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="user_id" value="{{ $user->user_id }}" />

                                <div class="form-group">
                                    <label for="user_profile" class="col-md-5 control-label">Profile Picture</label>
                                    <div class="col-md-6">
                                        <img class="avatar img-rounded" id="user_profile"
                                            src="{{ Storage::url('/images/profile/' . $user->user_profile_picture) }}"
                                            alt="Avatar">
                                    </div>
                                </div>
                                @if ($errors->has('user_profile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_profile') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <label for="user_name" class="col-md-5 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input id="user_name" type="text" class="form-control" name="user_name"
                                            value="{{ $user->user_name }}" />
                                    </div>
                                </div>
                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group">
                                    <label for="user_first_name" class="col-md-5 control-label">First Name</label>

                                    <div class="col-md-6">
                                        <input id="user_first_name" type="text" class="form-control"
                                            name="user_first_name" value="{{ $user->user_first_name }}" value=""
                                            required autofocus>
                                    </div>
                                </div>
                                @if ($errors->has('user_first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_first_name') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group">
                                    <label for="user_last_name" class="col-md-5 control-label">Last Name</label>

                                    <div class="col-md-6">
                                        <input id="user_last_name" type="text" class="form-control" name="user_last_name"
                                            value="{{ $user->user_last_name }}" value="">
                                    </div>
                                </div>
                                @if ($errors->has('user_last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_last_name') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group">
                                    <label for="user_email_address" class="col-md-5 control-label">Email Address</label>

                                    <div class="col-md-6">
                                        <input id="user_email_address" type="text" class="form-control"
                                            name="user_email_address" value="{{ $user->user_email_address }}"
                                            value="">
                                    </div>
                                </div>
                                @if ($errors->has('user_email_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_email_address') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group">
                                    <label for="user_description" class="col-md-5 control-label">User Description</label>

                                    <div class="col-md-6">
                                        <textarea rows="4" id="user_description" type="text" class="form-control" name="user_description"
                                            placeholder="Introduce yourself and your interests!">{{ $user->user_description }}</textarea>
                                    </div>
                                </div>
                                @if ($errors->has('user_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_description') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <label for="user_password" class="col-md-5 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input id="user_password" type="password" class="form-control" autocomplete="off" name="user_password"
                                            placeholder="Leave blank to keep current password">

                                        @if ($errors->has('user_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('user_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-5 control-label">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" autocomplete="off" class="form-control"
                                            name="password_confirmation">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="content">
                                        <button type="submit" tabindex="7" class="btn btn-primary">
                                            Update User
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
