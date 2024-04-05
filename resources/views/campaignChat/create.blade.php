<title>Campaign Manager - Create New Chat</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">Create New Chat</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/campaign/{{$campaign->campaign_id}}/chats/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="campaign_chat_title" class="col-md-5 control-label">Chat Title</label>
                                    <div class="col-md-6">
                                        <input id="campaign_chat_title" type="text" class="form-control" name="campaign_chat_title"
                                            value="" />
                                    </div>
                                </div>
                                @if ($errors->has('campaign_chat_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_chat_title') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <div class="content">
                                        <button type="submit" class="btn btn-primary">
                                            Create Chat
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
