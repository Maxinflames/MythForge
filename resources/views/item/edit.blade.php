<title>Campaign Manager - Edit Item - {{ $item->item_title }}</title>
@extends('layouts.app')

@section('content')
    <div class="flex-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading center">Edit Item Details</div>
                        <form class="form-horizontal" method="POST" action="/items/update/{{$item->item_id}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="item_id" value="{{ $item->item_id }}" />
                            <input type="hidden" name="user_id" value="{{ $item->user_id }}" />

                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="item_title" class="col-md-5 control-label">Item Title</label>
                                    <div class="col-md-6">
                                        <input id="item_title" type="text" class="form-control" name="item_title"
                                            value="{{ $item->item_title }}" />
                                    </div>
                                    @if ($errors->has('item_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="game_type_id" class="col-md-5 control-label">Game Type</label>
                                    <div class="col-md-6">
                                        <select name="game_type_id" id="game_type_id" class="form-control">
                                            @foreach ($game_types as $game_type)
                                                @if ($game_type->game_type_id == $item->game_type_id)
                                                    <option value="{{ $game_type->game_type_id }}" selected="true">
                                                        {{ $game_type->game_type_title }}</option>
                                                @else
                                                    <option value="{{ $game_type->game_type_id }}">
                                                        {{ $game_type->game_type_title }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('game_type_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('game_type_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="item_description" class="col-md-5 control-label">Item
                                        Description</label>
                                    <div class="col-md-6">
                                        <textarea rows="15" id="item_description" type="text" class="form-control" maxlength="10000"
                                            name="item_description">{{ $item->item_description }}</textarea>
                                    </div>
                                    @if ($errors->has('item_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="content form-group">
                                    @if ($item->item_status == 1)
                                        <input class="radio-input" id="status1" type="radio" name="item_status"
                                            checked="true" value="1" />
                                        <label class="radio-label" for="status1">Public</label>

                                        <input class="radio-input" id="status2" type="radio" name="item_status"
                                            value="0" />
                                        <label class="radio-label" for="status2">Private</label>
                                    @else
                                        <input class="radio-input" id="status1" type="radio" name="item_status"
                                            value="1" />
                                        <label class="radio-label" for="status1">Public</label>

                                        <input class="radio-input" id="status2" type="radio" name="item_status"
                                            checked="true" value="0" />
                                        <label class="radio-label" for="status2">Private</label>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="content">
                                        <button type="submit" class="btn btn-primary">
                                            Update Item Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
