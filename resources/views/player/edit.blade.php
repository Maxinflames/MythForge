<title>MythForge - Edit Player Profile</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit Player Details</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                action="/campaign/{{ $campaign->campaign_id }}/players/{{ $player->player_id }}/update">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <input type="hidden" name="player_id" value="{{ $player->player_id }}" />


                                <div class="form-group">
                                    <label for="player_profile_picture" class="col-md-5 control-label">Character
                                        Picture</label>
                                    <div class="col-md-6">
                                        <input name="player_profile_picture", class="form-control" type="file">
                                    </div>
                                </div>
                                @if ($errors->has('player_profile_picture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('player_profile_picture') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <label for="user_name" class="col-md-5 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input id="user_name" type="text" readonly="true" class="form-control"
                                            name="user_name" value="{{ $player->user_name }}" />
                                    </div>
                                </div>
                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <label for="player_character_name" class="col-md-5 control-label">Player Character
                                        Name</label>

                                    <div class="col-md-6">
                                        <input id="player_character_name" type="text" class="form-control"
                                            name="player_character_name" value="{{ $player->player_character_name }}"
                                            value="" required autofocus>
                                    </div>
                                </div>
                                @if ($errors->has('player_character_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('player_character_name') }}</strong>
                                    </span>
                                @endif

                                @if ($player->user_id == Session::get('user_id'))
                                    <div>
                                        <div class="form-group">
                                            <div class="content">
                                                <button type="submit" class="btn btn-primary">
                                                    Update
                                                </button>
                                            </div>
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
