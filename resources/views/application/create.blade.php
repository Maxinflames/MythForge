<title>Campaign Manager - Create Application</title>

@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">Create New Application</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/applications/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="campaign_id" value="{{ $campaign->campaign_id }}" />
                                <input type="hidden" name="user_id" value="{{ Session::get('user_id') }}" />

                                <div class="form-group">
                                    <label for="campaign_title" class="col-md-5 control-label">Application For</label>
                                    <div class="col-md-6">
                                        <input id="campaign_title" type="text" readonly="true" class="form-control" name="campaign_title"
                                            value="{{$campaign->campaign_title}}" />
                                    </div>
                                </div>
                                @if ($errors->has('campaign_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_title') }}</strong>
                                    </span>
                                @endif


                                <div class="form-group">
                                    <label for="application_message" class="col-md-5 control-label">Application
                                        Message</label>
                                    <div class="col-md-7">
                                        <textarea rows="6" id="application_message" type="text" class="form-control" maxlength="255"
                                            name="application_message"></textarea>
                                    </div>
                                </div>
                                @if ($errors->has('application_message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('application_message') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <div class="content">
                                        <button type="submit" class="btn btn-primary">
                                            Submit Application
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
