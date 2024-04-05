<title>item Manager - Account</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">Create New Item</div>

                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="/items/store">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label for="item_title" class="col-md-5 control-label">Item Title</label>
                                    <div class="col-md-6">
                                        <input id="item_title" type="text" class="form-control" name="item_title"
                                            value="" />
                                    </div>
                                </div>
                                @if ($errors->has('item_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('item_title') }}</strong>
                                    </span>
                                @endif


                                <div class="form-group">
                                    <label for="item_description" class="col-md-5 control-label">Item
                                        Description</label>
                                    <div class="col-md-7">
                                        <textarea rows="6" id="item_description" type="text" class="form-control" maxlength="10000"
                                            name="item_description"></textarea>
                                    </div>
                                </div>
                                @if ($errors->has('item_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('item_description') }}</strong>
                                    </span>
                                @endif


                                <div class="form-group">
                                    <label for="game_type_id" class="col-md-5 control-label">Game Type</label>
                                    <div class="col-md-6">
                                        <select name="game_type_id" id="game_type_id" class="form-control">
                                            @foreach ($game_types as $game_type)
                                                @if ($game_type->game_type_id == 1)
                                                    <option value="{{ $game_type->game_type_id }}" selected="true">
                                                        {{ $game_type->game_type_title }}</option>
                                                @else
                                                    <option value="{{ $game_type->game_type_id }}">
                                                        {{ $game_type->game_type_title }}</option>
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

                                <div class="content form-group">
                                    <input class="radio-input" id="status1" type="radio" name="item_status"
                                        checked="true" value="1" />
                                    <label class="radio-label" for="status1">Public</label>

                                    <input class="radio-input" id="status2" type="radio" name="item_status"
                                        value="0" />
                                    <label class="radio-label" for="status2">Private</label>
                                </div>
                                @if ($errors->has('item_status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('item_status') }}</strong>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <div class="content">
                                        <button type="submit" class="btn btn-primary">
                                            Create Item
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
