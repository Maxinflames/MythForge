<title>MythForge - Player Profile</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Player Details</div>

                        <div class="panel-body">
                            <form class="form-horizontal">

                                <div class="form-group">
                                    <label for="player_profile_picture" class="col-md-5 control-label">Character
                                        Picture</label>
                                    <div class="col-md-6">
                                        <img class="avatar img-rounded" id="player_profile_picture"
                                            src="{{ Storage::url('/images/player/' . $player->player_profile_picture) }}"
                                            alt="Avatar">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="user_name" class="col-md-5 control-label">User Name</label>
                                    <div class="col-md-6">
                                        <input id="user_name" type="text" readonly="true" class="form-control"
                                            name="user_name" value="{{ $player->user_name }}" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="player_character_name" class="col-md-5 control-label">Player Character
                                        Name</label>

                                    <div class="col-md-6">
                                        <input id="player_character_name" type="text" readonly="true"
                                            class="form-control" name="player_character_name"
                                            value="{{ $player->player_character_name }}" value="" required autofocus>
                                    </div>
                                </div>
                                @if ($player->user_id == Session::get('user_id'))
                                    <div>
                                        <div class="form-group">
                                            <div class="center"><a class="btn btn-primary" href="/campaign/{{$campaign->campaign_id}}/players/{{$player->player_id}}/edit">Edit</a></div>
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
