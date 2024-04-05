@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/register">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="user_name" class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input id="user_name" type="text" class="form-control" name="user_name"
                                        value="{{ old('user_name') }}" value="" autofocus>

                                    @if ($errors->has('user_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input id="user_first_name" type="text" class="form-control" name="user_first_name"
                                        value="{{ old('user_first_name') }}" value="" autofocus>

                                    @if ($errors->has('user_first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_last_name" class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <input id="user_last_name" type="text" class="form-control" name="user_last_name"
                                        value="{{ old('user_last_name') }}" value="">

                                    @if ($errors->has('user_last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_email_address" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="user_email_address" type="email" class="form-control"
                                        value="{{ old('user_email_address') }}" name="user_email_address" value="">

                                    @if ($errors->has('user_email_address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_email_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="user_password" type="password" class="form-control" name="user_password">

                                    @if ($errors->has('user_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="center">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
