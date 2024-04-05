<title>Campaign Manager - Create New Campaign</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">Create New Campaign</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/campaign/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="campaign_title" class="col-md-5 control-label">Campaign Title</label>
                                    <div class="col-md-6">
                                        <input id="campaign_title" type="text" class="form-control" name="campaign_title"
                                            value="" />
                                    </div>
                                </div>
                                @if ($errors->has('campaign_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_title') }}</strong>
                                    </span>
                                @endif


                                <div class="form-group">
                                    <label for="campaign_description" class="col-md-5 control-label">Campaign
                                        Description</label>
                                    <div class="col-md-6">
                                        <textarea rows="6" id="campaign_description" type="text" class="form-control" maxlength="10000"
                                            name="campaign_description"></textarea>
                                    </div>
                                </div>
                                @if ($errors->has('campaign_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_description') }}</strong>
                                    </span>
                                @endif


                                <div class="form-group">
                                    <label for="game_type_id" class="col-md-5 control-label">Game Type</label>
                                    <div class="col-md-6">
                                        <select name="game_type_id" id="game_type_id" class="form-control">
                                            @foreach ($game_types as $game_type)
                                                @if ($game_type->game_type_id == 1)
                                                    <option value="{{ $game_type->game_type_id }}" selected="true">{{ $game_type->game_type_title }}</option>
                                                @else
                                                    <option value="{{ $game_type->game_type_id }}">{{ $game_type->game_type_title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if ($errors->has('game_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('game_type_id') }}</strong>
                                    </span>
                                @endif


                                <div class="form-group">
                                    <label for="campaign_player_limit" class="col-md-5 control-label">Player Limit</label>
                                    <div class="col-md-2">
                                        <input id="campaign_player_limit" type="number" min="1" class="form-control"
                                            name="campaign_player_limit" value="" />
                                    </div>
                                </div>
                                @if ($errors->has('campaign_player_limit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('campaign_player_limit') }}</strong>
                                    </span>
                                @endif


                                <div class="form-group">
                                    <div class="content">
                                        <button type="submit" class="btn btn-primary">
                                            Create Campaign
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
