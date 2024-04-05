<title>Campaign Manager - View Application</title>

@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">View Application</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/applications/store">
                                <div class="form-group">
                                    <label for="campaign_title" class="col-md-5 control-label">Application For</label>
                                    <div class="col-md-6">
                                        <input id="campaign_title" type="text" readonly="true" class="form-control"
                                            name="campaign_title" value="{{ $campaign->campaign_title }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="application_message" class="col-md-5 control-label">Application
                                        Message</label>
                                    <div class="col-md-7">
                                        <textarea rows="6" id="application_message" type="text" readonly="true" class="form-control" maxlength="255"
                                            name="application_message">{{ $application->application_message }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="application_status" class="col-md-5 control-label">Application
                                        Status</label>
                                    <div class="col-md-6">
                                        @if ($application->application_status != null)
                                            <input id="application_status" type="text" readonly="true"
                                                class="form-control" name="application_status"
                                                value="{{ $application->application_status }}" />
                                        @else
                                            <input id="application_status" type="text" readonly="true"
                                                class="form-control" name="application_status" value="No Response" />
                                        @endif
                                    </div>
                                </div>
                                @if ($application->application_status != null)
                                    @if (Session::get('user_id') == $application->user_id)
                                        <div class="center">
                                            <a class="btn btn-primary"
                                                href="/applications/edit/{{ $application->application_id }}">Edit</a>
                                        </div>
                                    @elseif (Session::get('user_id') == $campaign->user_id)
                                        <div class="center">
                                            <form action="{{ route('application-update') }}" method="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="application_id"
                                                    value="{{ $application->application_id }}" />
                                                <input type="hidden" name="application_message"
                                                    value="{{ $application->application_message }}" />
                                                <input type="hidden" name="application_status" value="0" />

                                                <button type="submit" class="btn btn-primary">
                                                    Deny
                                                </button>
                                            </form>
                                            <form action="{{ route('application-update') }}" method="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <input type="hidden" name="application_id"
                                                    value="{{ $application->application_id }}" />
                                                <input type="hidden" name="application_message"
                                                    value="{{ $application->application_message }}" />
                                                <input type="hidden" name="application_status" value="1" />

                                                <button type="submit" class="btn btn-primary">
                                                    Accept
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
