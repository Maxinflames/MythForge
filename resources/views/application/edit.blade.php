<title>Campaign Manager - Edit Application</title>

@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">Edit Application</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/applications/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="application_id" value="{{ $application->application_id }}" />
                                <input type="hidden" name="application_status" />

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
                                        @if (Session::get('user_id') == $application->user_id && $application->application_status == null)
                                            <textarea rows="6" id="application_message" type="text" class="form-control" maxlength="255"
                                                name="application_message">{{ $application->application_message }}</textarea>
                                        @else
                                            <textarea rows="6" id="application_message" type="text" class="form-control" readonly="true" maxlength="255"
                                                name="application_message">{{ $application->application_message }}</textarea>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="application_status_display" class="col-md-5 control-label">Application
                                        Status</label>
                                    <div class="col-md-6">
                                        @if ($application->application_status != null)
                                            @if ($application->application_status == 1)
                                                <input id="application_status_display" type="text" readonly="true"
                                                    class="form-control" name="application_status_display"
                                                    value="Accepted" />
                                            @else
                                                <input id="application_status_display" type="text" readonly="true"
                                                    class="form-control" name="application_status_display"
                                                    value="Declined" />
                                            @endif
                                        @else
                                            @if (Session::get('user_id') == $application->user_id)
                                                <input id="application_status_display" type="text" readonly="true"
                                                    class="form-control" name="application_status_display"
                                                    value="No Response" />
                                            @else
                                                <input class="radio-input" id="status1" type="radio" name="application_status"
                                                    checked="true" value="1" />
                                                <label class="radio-label" for="status1">Accept</label>

                                                <input class="radio-input" id="status2" type="radio" name="application_status"
                                                    value="0" />
                                                <label class="radio-label" for="status2">Decline</label>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @if ($application->application_status == null)
                                    <div class="form-group">
                                        <div class="content">
                                            <button type="submit" class="btn btn-primary">
                                                Submit Changes
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
